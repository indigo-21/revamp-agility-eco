<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobBooked = Job::where('job_status_id', 1)->count();
        $jobPending = Job::whereIn('job_status_id', [5, 6, 7, 8, 9, 10, 25, 22])->count();
        $jobFailed = Job::where('job_status_id', 16)->count();
        $totalJobs = Job::count();
        $jobFailPercent = ($jobFailed / $totalJobs) * 100;

        return view('dashboard')
            ->with('jobBooked', $jobBooked)
            ->with('jobPending', $jobPending)
            ->with('jobFailed', $jobFailed)
            ->with('jobFailPercent', $jobFailPercent);
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
