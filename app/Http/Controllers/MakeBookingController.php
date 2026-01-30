<?php

namespace App\Http\Controllers;

use App\DataTables\MakeBookingsDataTable;
use App\Models\Booking;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Http\Request;

class MakeBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MakeBookingsDataTable $makeBookingsDataTable)
    {
        return $makeBookingsDataTable->render('pages.booking.make-booking.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $job_number)
    {
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$job_number%")->get();
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
        $job = Job::firmDataOnly()->where('job_number', 'LIKE', "%$job_number%")->firstOrFail();
        $propertyInspector = PropertyInspector::find($job->property_inspector_id);

        return view('pages.booking.make-booking.book')
            ->with('job_number', $job_number)
            ->with('job', $job)
            ->with('propertyInspector', $propertyInspector);
    }

    public function book(Request $request, string $job_number)
    {
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$job_number%")
            ->whereIn('job_status_id', [1, 2, 23, 25])
            ->get();

        if ($jobs->isEmpty()) {
            abort(404);
        }

        $booking = new Booking;

        $booking->job_number = $job_number;
        $booking->booking_outcome = "Booked";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::firmDataOnly()->find($job->id);
            if (!$job_data) {
                continue;
            }

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
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$job_number%")->get();
        $property_inspectors = PropertyInspector::all();

        if ($jobs->isEmpty()) {
            abort(404);
        }

        $job_data = Job::firmDataOnly()->findOrFail($jobs->first()->id);

        return view('pages.booking.make-booking.edit-pi')
            ->with('job_number', $job_number)
            ->with('jobs', $jobs)
            ->with('job_data', $job_data)
            ->with('property_inspectors', $property_inspectors);
    }

    public function editPISubmit(Request $request, string $job_number)
    {
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$job_number%")->get();

        if ($jobs->isEmpty()) {
            abort(404);
        }

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
            $job_data = Job::firmDataOnly()->find($job->id);
            if (!$job_data) {
                continue;
            }
            $job_data->property_inspector_id = $request->property_inspector_id;
            $job_data->last_update = now();

            $job_data->save();
        }

        return redirect()->route('make-booking.index')
            ->with('success', 'Property Inspector updated successfully.');
    }

    public function closeJob(Request $request)
    {
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$request->job_number%")->get();

        if ($jobs->isEmpty()) {
            abort(404);
        }

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

            $job_data = Job::firmDataOnly()->find($job->id);
            if (!$job_data) {
                continue;
            }

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
        $jobs = Job::firmDataOnly()->where('job_number', 'LIKE', "%$request->job_number%")->get();

        if ($jobs->isEmpty()) {
            abort(404);
        }

        $booking = new Booking;

        $booking->job_number = $request->job_number;
        $booking->booking_outcome = "Attempt Made";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $jobs->first()->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = $request->booking_notes;

        $booking->save();

        foreach ($jobs as $key => $job) {

            $job_data = Job::firmDataOnly()->find($job->id);
            if (!$job_data) {
                continue;
            }

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

    public function getBookedJobs(Request $request)
    {
        // Get the latest booking id for each job_number for this inspector
        $latestIds = Booking::selectRaw('MAX(id) as id')
            ->where('booking_outcome', 'Booked')
            ->where('property_inspector_id', $request->property_inspector_id)
            ->groupBy('job_number')
            ->pluck('id')
            ->toArray();

        // Fetch only those latest booking rows
        $jobs = Booking::whereIn('id', $latestIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->job_number,
                    'start' => $item->booking_date,
                    'backgroundColor' => "#f56954",
                    'borderColor' => "#f56954",
                    'allDay' => true,
                ];
            });

        return response()->json($jobs);
    }

}