<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Http\Request;

class MakeBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyInspector = PropertyInspector::find(auth()->user()->propertyInspector?->id);

        // get all the jobs columns and group by job_number AES0000000010-01 remove the last 3 characters 
        $jobs = Job::selectRaw('*, SUBSTRING(job_number, 1, LENGTH(job_number) - 3) as job_group')
            ->groupBy('job_group')
            ->whereIn('job_status_id', [25, 23])
            ->where('close_date', null)
            ->when($propertyInspector, function ($query) use ($propertyInspector) {
                return $query->where('property_inspector_id', $propertyInspector->id);
            })
            ->get();

        return view('pages.booking.make-booking.index')
            ->with('jobs', $jobs);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();
        $bookings = Booking::where('job_number', $job_number)->get();

        return view('pages.booking.make-booking.history')
            ->with('job_number', $job_number)
            ->with('jobs', $jobs)
            ->with('bookings', $bookings);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $job_number)
    {
        $job = Job::where('job_number', 'LIKE', "%$job_number%")->first();

        return view('pages.booking.make-booking.book')
            ->with('job_number', $job_number)
            ->with('job', $job);
    }

    public function book(Request $request, string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();

        $booking = new Booking;

        $booking->job_number = $job_number;
        $booking->booking_outcome = "Booked";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            $job_data->job_status_id = 2; // Job Booked Not Uploaded
            $job_data->last_update = now();
            $job_data->schedule_date = $request->booking_date;

            $job_data->save();

        }

        return redirect()->route('make-booking.index')
            ->with('success', 'Booking created successfully.');

    }

    public function editPI(string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();
        $property_inspectors = PropertyInspector::all();


        $job_data = Job::find($jobs->first()->id);

        return view('pages.booking.make-booking.edit-pi')
            ->with('job_number', $job_number)
            ->with('jobs', $jobs)
            ->with('job_data', $job_data)
            ->with('property_inspectors', $property_inspectors);
    }

    public function editPISubmit(Request $request, string $job_number)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$job_number%")->get();

        $property_inspector_old = PropertyInspector::find($jobs->first()->property_inspector_id);
        $property_inspector_new = PropertyInspector::find($request->property_inspector_id);

        $property_inspector_old_name = $property_inspector_old->user->firstname . ' ' . $property_inspector_old->user->lastname;
        $property_inspector_new_name = $property_inspector_new->user->firstname . ' ' . $property_inspector_new->user->lastname;

        $booking = new Booking;

        $booking->job_number = $job_number;
        $booking->booking_outcome = "PI Changed";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $request->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = "Property Inspector from {$property_inspector_old_name} Changed to {$property_inspector_new_name}";

        $booking->save();

        foreach ($jobs as $key => $job) {
            $job_data = Job::find($job->id);
            $job_data->property_inspector_id = $request->property_inspector_id;
            $job_data->last_update = now();

            $job_data->save();
        }

        return redirect()->route('make-booking.index')
            ->with('success', 'Property Inspector updated successfully.');
    }

    public function closeJob(Request $request)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$request->job_number%")->get();

        $job_status_id = match ($request->booking_outcome) {
            'Wrong Contact Details' => 28, // Wrong Contact Details
            'Customer Refused' => 15, // Customer Refused
            'Job Deadline Expired' => 27, // Job Deadline Expired
        };

        $booking = new Booking;

        $booking->job_number = $request->job_number;
        $booking->booking_outcome = $request->booking_outcome;
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            $job_data->job_status_id = $job_status_id; // Closed
            $job_data->last_update = now();
            $job_data->close_date = now();

            $job_data->save();
        }

        return redirect()->route('make-booking.index')
            ->with('success', 'Job closed successfully.');
    }

    public function attemptMade(Request $request)
    {
        $jobs = Job::where('job_number', 'LIKE', "%$request->job_number%")->get();

        $booking = new Booking;

        $booking->job_number = $request->job_number;
        $booking->booking_outcome = "Attempt Made";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            if ($job->max_attempts + 1 >= $job->client->clientSlaMetric->maximum_booking_attempts) {

                $job_data->max_attempts = $job->max_attempts + 1;
                $job_data->last_update = now();
                $job_data->close_date = now();
                $job_data->job_status_id = 29; // Fail Max Attempts
                $job_data->save();


                return redirect()->route('make-booking.index')
                    ->with('success', 'Max attempts reached.');
            }

            $job_data->max_attempts = $job->max_attempts + 1;
            $job_data->last_update = now();
            $job_data->save();


        }

        return redirect()->route('make-booking.index')
            ->with('success', 'Attempt made successfully.');
    }

}
