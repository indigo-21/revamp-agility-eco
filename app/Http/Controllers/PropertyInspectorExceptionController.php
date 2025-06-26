<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Http\Request;

class PropertyInspectorExceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $jobs = Job::selectRaw('*, SUBSTRING(job_number, 1, LENGTH(job_number) - 3) as job_group')
            ->whereIn('job_status_id', [22])
            ->groupBy('job_group')
            ->get();

        return view('pages.exception.property-inspector.index')
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
        $jobs = Job::where('job_number', 'LIKE', "%$request->jobNumber%")->get();
        $propertyInspector = PropertyInspector::find($request->piId);

        foreach ($jobs as $key => $job) {

            $job_data = Job::find($job->id);

            $job_data->job_status_id = 25; // Job Booked Not Uploaded
            $job_data->last_update = now();
            $job_data->property_inspector_id = $propertyInspector->id;
            
            $job_data->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Property Inspector assigned successfully.',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $propertyInspectors = PropertyInspector::where('is_active', 1)
            ->where('id_expiry', '>=', now())
            ->get();
        $job = Job::where('job_number', 'LIKE', "%$id%")->first();

        return view('pages.exception.property-inspector.show')
            ->with('propertyInspectors', $propertyInspectors)
            ->with('job', $job)
            ->with('job_number', $id);
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
