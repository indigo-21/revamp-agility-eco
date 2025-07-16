<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $installerFailedJobs = Job::leftJoin('job_measures', 'jobs.id', '=', 'job_measures.job_id')
            ->select(DB::raw('count(*) as failed_count'), 'installer_id', 'measure_id')
            ->where('job_status_id', 16)
            ->groupBy('installer_id', 'job_measures.measure_id')
            ->get();

        $installerJobs = Job::leftJoin('job_measures', 'jobs.id', '=', 'job_measures.job_id')
            ->select(DB::raw('count(*) as total_count'), 'installer_id', 'measure_id')
            ->whereIn('job_status_id', [3, 16])
            ->groupBy('installer_id', 'job_measures.measure_id')
            ->get();

        // Map the two collections based on installer_id and measure_id
        $installerJobsMap = $installerJobs->keyBy(function ($item) {
            return $item->installer_id . '_' . $item->measure_id;
        });

        $dashboardData = $installerFailedJobs->map(function ($failedJob) use ($installerJobsMap) {
            $key = $failedJob->installer_id . '_' . $failedJob->measure_id;
            $totalJob = $installerJobsMap->get($key);
            
            $totalCount = $totalJob ? $totalJob->total_count : 0;
            $failedCount = $failedJob->failed_count;
            $ncRate = $totalCount > 0 ? ($failedCount / $totalCount) * 100 : 0;
            
            return [
                'installer_id' => $failedJob->installer_id,
                'measure_id' => $failedJob->measure_id,
                'total_jobs' => $totalCount,
                'failed_jobs' => $failedCount,
                'nc_rate' => round($ncRate, 2)
            ];
        });

        return view('dashboard')
            ->with('jobBooked', $jobBooked)
            ->with('jobPending', $jobPending)
            ->with('jobFailed', $jobFailed)
            ->with('jobFailPercent', $jobFailPercent)
            ->with('dashboardData', $dashboardData);
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
