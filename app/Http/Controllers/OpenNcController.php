<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\OutwardPostcode;
use App\Models\UpdateSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OpenNcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dateRange = $request->job_date_range;
        $dates = explode(' - ', $dateRange);
        $startDate = $dates[0] ?? null;
        $endDate = $dates[1] ?? null;

        $jobs = Job::firmDataOnly()->whereHas('jobStatus', function ($query) use ($request) {
            if ($request->filled('job_status_id')) {
                $query->where('id', $request->job_status_id);
            }
        })->whereHas('client', function ($query) use ($request) {
            if ($request->filled('client')) {
                $query->where('id', $request->client);
            }
        })->whereHas('property', function ($query) use ($request) {
            if ($request->filled('outward_postcode')) {
                $query->where('postcode', 'LIKE', $request->outward_postcode . '%');
            }
        })->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->when($request->job_filter, function ($query) use ($request) {
            switch ($request->job_filter) {
                case '1':
                    $query->whereNull('close_date');
                    break;
                case '2':
                    $query->whereNot('close_date');
                    break;
                default:
                    break;
            }
        })->whereIn('job_status_id', [16, 29])
            ->get();

        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();
        $jobStatuses = JobStatus::all();
        $outwardPostcodes = OutwardPostcode::all();

        return view('pages.open-nc.index')
            ->with('jobs', $jobs)
            ->with('clients', $clients)
            ->with('jobStatuses', $jobStatuses)
            ->with('outwardPostcodes', $outwardPostcodes);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::firmDataOnly()->findOrFail($id);
        $bookings = Booking::where('job_number', 'LIKE', "%" . Str::limit($job->job_number, 13, '') . "%")
            ->get();
        $updateSurveys = UpdateSurvey::where('job_id', $job->id)
            ->get();

        return view('pages.job.show')
            ->with('job', $job)
            ->with('bookings', $bookings)
            ->with('updateSurveys', $updateSurveys);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
