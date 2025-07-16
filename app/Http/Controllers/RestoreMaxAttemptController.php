<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestoreMaxAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::where('job_status_id', 29)
            ->get();

        return view('pages.booking.restore-max-attempt.index')
            ->with('jobs', $jobs);
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
        //
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
        $job = Job::findOrFail($id);
        $booking = new Booking;

        $job->max_attempts = 0;
        $job->last_update = now();
        $job->job_status_id = 25;

        $job->save();

        $booking->job_number = Str::substr($job->job_number, 0, -3);
        $booking->booking_outcome = "Restored Max Attempts";
        $booking->user_id = auth()->user()->id;
        $booking->property_inspector_id = $job->property_inspector_id;
        $booking->booking_date = now();
        $booking->booking_notes = "Changed the status to Job Unbooked";

        $booking->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
