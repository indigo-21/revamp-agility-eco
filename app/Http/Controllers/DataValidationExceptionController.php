<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exception as DataException;
use App\Models\Installer;
use App\Models\Job;
use App\Models\JobMeasure;
use App\Models\Measure;
use App\Models\Scheme;
use App\Services\JobService;
use Illuminate\Http\Request;

class DataValidationExceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::whereIn('job_status_id', [7, 8, 9])
            ->get();

        return view('pages.exception.data-validation.index')
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
        $jobNumbers = $request->input('jobNumbers');

        if (!is_array($jobNumbers) || count($jobNumbers) === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select at least one job to reimport.',
            ], 422);
        }

        $missingJobs = [];

        foreach ($jobNumbers as $jobNumber) {
            $job = Job::where('job_number', $jobNumber)->first();

            if (!$job) {
                $missingJobs[] = $jobNumber;
                continue;
            }

            $job->postcode = $job->property?->postcode;
            $job->customer_primary_tel = $job->customer?->customer_primary_tel;
            $exceptions = DataException::where('cert_no', $job->cert_no)
                ->where('job_status_id', $job->job_status_id)
                ->when($job->jobMeasure, function ($query) use ($job) {
                    $query->where('umr', $job->jobMeasure->umr);
                })
                ->get();


            foreach ($exceptions as $key => $dataException) {

                if ($job->job_status_id == $dataException->job_status_id) {
                    switch ($dataException->job_status_id) {
                        case 8:
                            $measure_cat = ["measure_cat" => $dataException->value];
                            $getMeasure = (new JobService)->getMeasure($measure_cat);

                            if ($getMeasure) {

                                $measure_data = JobMeasure::where('umr', $dataException->umr)
                                    ->first();

                                if (!$measure_data) {
                                    break;
                                }

                                $measure_data->measure_id = $getMeasure->id;

                                $measure_data->save();

                                $measure = [
                                    "measure_cat" => $getMeasure->measure_cat,
                                    'umr' => $measure_data->umr,
                                    'info' => $measure_data->info,
                                ];

                                (new JobService)->update($job, $measure);
                                DataException::where('id', $dataException->id)->delete();
                            }

                            break;

                        case 7:

                            $installer = Installer::with('user')
                                ->whereHas('user', function ($query) use ($dataException) {
                                    $query->where('firstname', $dataException->value);
                                })->first();

                            if ($installer) {
                                if (!$job->jobMeasure?->measure) {
                                    break;
                                }

                                $measure = [
                                    "measure_cat" => $job->jobMeasure->measure->measure_cat,
                                    'umr' => $job->jobMeasure->umr,
                                    'info' => $job->jobMeasure->info,
                                ];

                                $job->installer_id = $installer?->id;

                                (new JobService)->update($job, $measure);
                                DataException::where('id', $dataException->id)->delete();
                            }

                            break;
                        case 9:
                            $scheme_data = Scheme::where('short_name', $dataException->value)->first();

                            if ($scheme_data) {
                                if (!$job->jobMeasure?->measure) {
                                    break;
                                }

                                $measure = [
                                    "measure_cat" => $job->jobMeasure->measure->measure_cat,
                                    'umr' => $job->jobMeasure->umr,
                                    'info' => $job->jobMeasure->info,
                                ];


                                $job->scheme_id = $scheme_data?->id;

                                $result = (new JobService)->update($job, $measure);
                                // $test[] = $result;
                                DataException::where('id', $dataException->id)->delete();
                            }


                            break;

                        default:
                            # code...
                            break;
                    }
                }
            }
        }
        // return response()->json($test);

        $message = 'Data validation exceptions processed successfully.';
        if (count($missingJobs) > 0) {
            $message .= ' Missing jobs: ' . implode(', ', array_slice($missingJobs, 0, 10));
            if (count($missingJobs) > 10) {
                $message .= '...';
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
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
