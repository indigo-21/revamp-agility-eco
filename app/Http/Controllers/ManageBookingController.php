<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Http\Request;

class ManageBookingController extends Controller
{
    public function index()
    {
        $propertyInspector = PropertyInspector::find(auth()->user()->propertyInspector?->id);

        $jobs = Job::selectRaw('*, SUBSTRING(job_number, 1, LENGTH(job_number) - 3) as job_group')
            ->groupBy('job_group')
            ->where('job_status_id', 1)
            ->when($propertyInspector, function ($query) use ($propertyInspector) {
                return $query->where('property_inspector_id', $propertyInspector->id);
            })
            ->get();

        return view('pages.booking.manage-booking.index')
            ->with('jobs', $jobs);
    }

    public function edit(string $job_number)
    {
        $job = Job::where('job_number', 'LIKE', "%$job_number%")->first();

        return view('pages.booking.manage-booking.rebook')
            ->with('job_number', $job_number)
            ->with('job', $job);
    }

    public function show(string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();
        $bookings = Booking::where('job_number', $job_number)->get();

        return view('pages.booking.manage-booking.history')
            ->with('job_number', $job_number)
            ->with('jobs', $jobs)
            ->with('bookings', $bookings);
    }

    public function rebook(Request $request, string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();

        $booking = new Booking();

        $booking->job_number = $job_number;
        $booking->booking_outcome = "Rebook";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            $job_data->last_update = now();
            $job_data->schedule_date = $request->booking_date;

            $job_data->save();

        }

        return redirect()->route('manage-booking.index')
            ->with('success', 'Rebook created successfully.');
    }

    public function unbook(string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();

        $booking = new Booking();

        $booking->job_number = $job_number;
        $booking->booking_outcome = "unbook";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = "This job has been unbooked";

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            $job_data->last_update = now();
            $job_data->job_status_id = 25;
            $job_data->schedule_date = null;

            $job_data->save();

        }

        return redirect()->route('manage-booking.index')
            ->with('success', 'Rebook created successfully.');
    }
}
