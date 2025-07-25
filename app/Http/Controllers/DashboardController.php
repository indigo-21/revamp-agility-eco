<?php

namespace App\Http\Controllers;

use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\JobMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Parse date range if provided
        $startDate = null;
        $endDate = null;
        $startDate2 = null;
        $endDate2 = null;
        if ($request->has('job_date_range') && !empty($request->job_date_range)) {
            $dateRange = explode(' - ', $request->job_date_range);
            if (count($dateRange) == 2) {
                $startDate = $dateRange[0] . ' 00:00:00';
                $endDate = $dateRange[1] . ' 23:59:59';
            }
        }

        if ($request->has('job_date_range2') && !empty($request->job_date_range2)) {
            $dateRange2 = explode(' - ', $request->job_date_range2);
            if (count($dateRange2) == 2) {
                $startDate2 = $dateRange2[0] . ' 00:00:00';
                $endDate2 = $dateRange2[1] . ' 23:59:59';
            }
        }

        $jobBooked = Job::where('job_status_id', 1)->count();
        $jobPending = Job::whereIn('job_status_id', [5, 6, 7, 8, 9, 10, 25, 22])->count();
        $jobFailed = Job::where('job_status_id', 16)->count();
        $totalJobs = Job::count();
        $jobFailPercent = $totalJobs > 0 ? ($jobFailed / $totalJobs) * 100 : 0;

        // Single query to get both failed and total counts
        $dashboardData = Job::with(['installer.user', 'jobMeasure.measure', 'scheme'])
            ->join('job_measures', 'jobs.id', '=', 'job_measures.job_id')
            ->join('measures', 'job_measures.measure_id', '=', 'measures.id')
            ->join('installers', 'jobs.installer_id', '=', 'installers.id')
            ->join('users', 'installers.user_id', '=', 'users.id')
            ->join('schemes', 'jobs.scheme_id', '=', 'schemes.id')
            ->selectRaw('
                COUNT(*) as total_jobs,
                SUM(CASE WHEN jobs.job_status_id = 16 THEN 1 ELSE 0 END) as failed_jobs,
                ROUND((SUM(CASE WHEN jobs.job_status_id = 16 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as nc_rate,
                users.firstname as installer_name,
                measures.measure_cat,
                schemes.short_name as scheme_name,
                jobs.installer_id,
                job_measures.measure_id,
                jobs.scheme_id
            ')
            ->whereIn('jobs.job_status_id', [3, 16])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('jobs.created_at', [$startDate, $endDate]);
            })
            ->groupBy('jobs.installer_id', 'job_measures.measure_id', 'jobs.scheme_id')
            ->havingRaw('SUM(CASE WHEN jobs.job_status_id = 16 THEN 1 ELSE 0 END) > 0')
            // ->when(request()->has('installer_id'), function ($query) {
            //     return $query->where('jobs.installer_id', request('installer_id'));
            // })
            ->get()
            ->map(function ($item) {
                return [
                    'installer_name' => $item->installer_name,
                    'measure_cat' => $item->measure_cat,
                    'scheme_name' => $item->scheme_name,
                    'total_jobs' => $item->total_jobs,
                    'failed_jobs' => $item->failed_jobs,
                    'nc_rate' => $item->nc_rate
                ];
            });

        $dashboardData2 = CompletedJob::selectRaw('COUNT(*) as answered_questions, survey_questions.nc_severity, survey_questions.question_number')
            ->join('survey_questions', 'completed_jobs.survey_question_id', '=', 'survey_questions.id')
            ->when($startDate2 && $endDate2, function ($query) use ($startDate2, $endDate2) {
                return $query->whereBetween('completed_jobs.created_at', [$startDate2, $endDate2]);
            })
            ->groupBy('survey_question_id')
            ->get();

        return view('dashboard')
            ->with('jobBooked', $jobBooked)
            ->with('jobPending', $jobPending)
            ->with('jobFailed', $jobFailed)
            ->with('jobFailPercent', $jobFailPercent)
            ->with('dashboardData', $dashboardData)
            ->with('dashboardData2', $dashboardData2);
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
