<?php

namespace App\Http\Controllers;

use App\Models\CompletedJob;
use App\Models\Job;
use Illuminate\Http\Request;

class UpdateSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::whereIn('job_status_id', [3, 16, 26])
            ->get();

        return view('pages.update-survey.index')
            ->with('jobs', $jobs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        $completedJob = CompletedJob::find($id);

        return view('pages.update-survey.upload-image')
            ->with('completedJob', $completedJob);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);

        return view('pages.update-survey.edit')
            ->with('job', $job);
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
