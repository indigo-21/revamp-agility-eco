<?php

namespace App\Http\Controllers;

use App\Imports\JobImport;
use App\Models\Booking;
use App\Models\Client;
use App\Models\ClientJobType;
use App\Models\Customer;
use App\Models\Installer;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Measure;
use App\Models\OutwardPostcode;
use App\Models\Scheme;
use App\Models\UpdateSurvey;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Example: "2025-06-03 - 2025-07-31"
        $dateRange = $request->job_date_range;
        $dates = explode(' - ', $dateRange);
        $startDate = $dates[0] ?? null;
        $endDate = $dates[1] ?? null;

        $jobs = Job::whereHas('jobStatus', function ($query) use ($request) {
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
        })->get();

        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();
        $jobStatuses = JobStatus::all();
        $outwardPostcodes = OutwardPostcode::all();

        return view('pages.job.index')
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
        $installers = Installer::all();
        $customers = Customer::all();
        $schemes = Scheme::all();
        $measures = Measure::all();
        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();

        return view('pages.job.form')
            ->with('installers', $installers)
            ->with('customers', $customers)
            ->with('schemes', $schemes)
            ->with('measures', $measures)
            ->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job = (new JobService())->store($request);

        return response()->json($job);
        // return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::find($id);
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
        $job = Job::find($id);

        $job->delete();

        return redirect()->back()->with('success', 'Job deleted successfully');
    }

    public function upload(Request $request)
    {
        $job_import = new JobImport;
        Excel::import($job_import, $request->file);

        // save the file to storage public
        $storagePath = 'job_imports';
        $fileName = $request->file->getClientOriginalName();
        $request->file('file')->storeAs($storagePath, $fileName, 'public');

        foreach ($job_import->job_data as $row) {
            $scheme_data = Scheme::where('short_name', $row->scheme_id)->first();
            $installer_data = Installer::with('user')
                ->whereHas('user', function ($query) use ($row) {
                    $query->where('firstname', $row->installer_id);
                })->first();

            if (!$scheme_data) {
                (new JobService)->storeException($row->cert_no, $row->umr, 9, $row->scheme_id);
            }

            if (!$installer_data) {
                (new JobService)->storeException($row->cert_no, $row->umr, 7, $row->installer_id);
            }

            $row->client_id = $request->client_id;
            $row->job_type_id = $request->job_type_id;
            $row->scheme_id = $scheme_data->id ?? null;
            $row->installer_id = $installer_data->id ?? null;
            $row->customer_primary_tel = (string) $row->customer_primary_tel ?? null;
            $row->customer_secondary_tel = (string) $row->customer_secondary_tel ?? null;
            $row->job_csv_filename = $fileName;
            $row->measures[] = [
                "job_suffix" => "01",
                "umr" => $row->umr,
                "measure_cat" => $row->measure_cat,
                "info" => $row->info
            ];
            $row->csv_filename = $fileName;

            // dd($row);

            (new JobService())->store($row);

        }

        return redirect()->back()->with('success', 'Jobs imported successfully');
    }

    public function searchClient(Request $request)
    {
        $client_job_types = Client::where('id', $request->client_id)
            ->with(['clientJobTypes', 'clientJobTypes.jobType'])
            ->get();

        return response()->json($client_job_types);
    }

    public function closeJob(Request $request, string $id)
    {

        $job = Job::find($id);

        $job->job_status_id = $request->job_status_id;
        $job->last_update = now();
        $job->close_date = now();

        $job->save();

        return redirect()->back()
            ->with('success', 'Job closed successfully');
    }

    public function removeDuplicates()
    {
        Job::where('job_status_id', 6)->delete();
        
        return response()->json([
            'message' => 'Duplicate jobs removed successfully'
        ]);
    }
}
