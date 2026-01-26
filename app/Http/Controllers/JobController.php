<?php

namespace App\Http\Controllers;

use App\DataTables\JobsDataTable;
use App\Imports\JobImport;
use App\Models\Booking;
use App\Models\Client;
use App\Models\ClientJobType;
use App\Models\Customer;
use App\Models\Installer;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Measure;
use App\Models\OutwardPostcode;
use App\Models\QueueJob;
use App\Models\Scheme;
use App\Models\UpdateSurvey;
use App\Services\JobDispatcherService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{

    protected $jobDispatcherService;

    public function __construct(JobDispatcherService $jobDispatcherService)
    {
        $this->jobDispatcherService = $jobDispatcherService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(JobsDataTable $jobsDataTable, Request $request)
    {
        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();
        $jobStatuses = JobStatus::all();
        $outwardPostcodes = OutwardPostcode::all();

        return $jobsDataTable->render('pages.job.index', [
            'clients' => $clients,
            'jobStatuses' => $jobStatuses,
            'outwardPostcodes' => $outwardPostcodes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $installers = Installer::all();
        $customers = Customer::all();
        $schemes = Scheme::all();
        $measures = Measure::all();
        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();

        return view('pages.job.form')
            ->with('installers', $installers)
            ->with('customers', $customers)
            ->with('schemes', $schemes)
            ->with('measures', $measures)
            ->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job = (new JobService())->store($request);

        return response()->json($job);
        // return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::find($id);
        $bookings = Booking::where('job_number', 'LIKE', "%" . Str::limit($job->job_number, 13, '') . "%")
            ->get();
        $updateSurveys = UpdateSurvey::where('job_id', $job->id)
            ->get();


        return view('pages.job.show')
            ->with('job', $job)
            ->with('bookings', $bookings)
            ->with('updateSurveys', $updateSurveys);
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
        $job = Job::find($id);

        $job->delete();

        return redirect()->back()->with('success', 'Job deleted successfully');
    }

    /**
     * Export jobs to CSV using current filters.
     */
    public function exportCsv(Request $request, JobsDataTable $jobsDataTable)
    {
        set_time_limit(0);

        $query = $jobsDataTable->query(new Job());

        $dataTable = $jobsDataTable->dataTable($query);

        if (method_exists($dataTable, 'skipPaging')) {
            $dataTable->skipPaging();
        }

        if (method_exists($dataTable, 'getFilteredQuery')) {
            $query = $dataTable->getFilteredQuery();
        }


        Log::info('Jobs CSV export params', [
            'search' => $request->input('search.value'),
            'columns' => $request->input('columns'),
            'request' => $request->all(),
        ]);

        $filename = 'Jobs_' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            $headers = [
                'Job ID',
                'Job Number',
                'Cert#',
                'UMR',
                'Job Status',
                'Property Inspector',
                'Booked Date',
                'Postcode',
                'Installer',
                'Remediation Deadline',
                'NC Level',
                'Close Date',
                'Deadline',
                'Invoice Status',
                '28-Reminder',
            ];

            fputcsv($handle, $headers);

            $writeRows = function ($jobs) use ($handle) {
                foreach ($jobs as $job) {
                    $jobGroup = substr($job->job_number, 0, max(strlen($job->job_number) - 3, 0));

                    $bookingDate = 'N/A';
                    if (! empty($jobGroup)) {
                        $booking = Booking::where('job_number', 'LIKE', "%{$jobGroup}%")
                            ->where('booking_outcome', 'Booked')
                            ->latest()
                            ->first();

                        if ($booking) {
                            $bookingDate = $booking->booking_date;
                        }
                    }

                    fputcsv($handle, [
                        $job->id,
                        $job->job_number,
                        $job->cert_no,
                        $job->jobMeasure?->umr ?? 'N/A',
                        $job->jobStatus?->description ?? 'N/A',
                        trim(($job->propertyInspector?->user?->firstname ?? '') . ' ' . ($job->propertyInspector?->user?->lastname ?? '')),
                        $bookingDate,
                        $job->property?->postcode ?? 'N/A',
                        $job->installer?->user?->firstname ?? 'N/A',
                        $job->rework_deadline,
                        $job->job_remediation_type,
                        $job->close_date,
                        $job->deadline,
                        $job->invoiceStatus?->name ?? 'N/A',
                        $job->sent_reminder === 1 ? 'Yes' : 'No',
                    ]);
                }
            };

            if ($query instanceof \Illuminate\Support\Enumerable) {
                $sorted = collect($query)->sortBy('id');
                $writeRows($sorted);
                return;
            }

            if ($query instanceof \Illuminate\Database\Eloquent\Builder || $query instanceof \Illuminate\Database\Query\Builder) {
                $query->orderBy('id')->chunk(1000, function ($jobs) use ($writeRows) {
                    $writeRows($jobs);
                });
                return;
            }

            $jobs = collect($query)->sortBy('id');
            $writeRows($jobs);

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function upload(Request $request)
    {
        try {
            $job_import = new JobImport;
            Excel::import($job_import, $request->file);

            // save the file to storage public
            $storagePath = 'job_imports';
            $fileName = $request->file->getClientOriginalName();
            $request->file('file')->storeAs($storagePath, $fileName, 'public');

            $jobDataCount = count($job_import->job_data);

            Log::info("JobController: File upload started", [
                'filename' => $fileName,
                'records_count' => $jobDataCount,
                'client_id' => $request->client_id
            ]);

            $processedData = [];

            foreach ($job_import->job_data as $row) {
                $scheme_data = Scheme::where('short_name', $row->scheme_id)->first();
                $installer_data = Installer::with('user')
                    ->whereHas('user', function ($query) use ($row) {
                        $query->where('firstname', $row->installer_id);
                    })->first();

                if (!$scheme_data) {
                    (new JobService)->storeException($row->cert_no, $row->umr, 9, $row->scheme_id);
                }

                if (!$installer_data) {
                    (new JobService)->storeException($row->cert_no, $row->umr, 7, $row->installer_id);
                }

                $row->client_id = $request->client_id;
                $row->job_type_id = $request->job_type_id;
                $row->scheme_id = $scheme_data->id ?? null;
                $row->installer_id = $installer_data->id ?? null;
                $row->customer_primary_tel = (string) $row->customer_primary_tel ?? null;
                $row->customer_secondary_tel = (string) $row->customer_secondary_tel ?? null;
                $row->job_csv_filename = $fileName;
                $row->measures[] = [
                    "job_suffix" => "01",
                    "umr" => $row->umr,
                    "measure_cat" => $row->measure_cat,
                    "info" => $row->info
                ];
                $row->csv_filename = $fileName;

                $processedData[] = $row;

            }

            if ($jobDataCount <= 20) {
                foreach ($processedData as $row) {
                    (new JobService())->store($row);
                }

                Log::info("JobController: File upload completed synchronously", [
                    'filename' => $fileName,
                    'records_processed' => $jobDataCount
                ]);

                return redirect()->back()->with('success', "Jobs imported successfully. Processed {$jobDataCount} records synchronously.");

            } else {
                // Large files - process asynchronously
                $batchSize = $jobDataCount > 100 ? 10 : 25; // Smaller batches for very large files
                $batchIds = [];

                // Set initial queue count for progress tracking
                session(['initial_queue_count' => $jobDataCount]);

                // Split data into batches and dispatch
                $batches = array_chunk($processedData, $batchSize);
                foreach ($batches as $index => $batch) {
                    foreach ($batch as $row) {
                        $batchId = "upload_{$fileName}_{$index}_" . now()->format('YmdHis');
                        $this->jobDispatcherService->dispatchJob($row);
                        $batchIds[] = $batchId;
                    }
                }

                Log::info("JobController: File upload queued for processing", [
                    'filename' => $fileName,
                    'records_queued' => $jobDataCount,
                    'batches_created' => count($batches),
                    'initial_queue_count' => $jobDataCount
                ]);

                return redirect()->back()
                    ->with('success', "Jobs queued for processing. {$jobDataCount} records will be processed asynchronously in " . count($batches) . " batches. Please wait for the job to complete since there are multiple records to process.")
                    ->with('dataCount', $jobDataCount)
                    ->with('showProgress', true);
            }
        } catch (\Exception $e) {
            Log::error("JobController: File upload failed", [
                'filename' => $request->file->getClientOriginalName() ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred during file upload: ' . $e->getMessage());
        }
    }

    public function searchClient(Request $request)
    {
        $client_job_types = Client::where('id', $request->client_id)
            ->with(['clientJobTypes', 'clientJobTypes.jobType'])
            ->get();

        return response()->json($client_job_types);
    }

    public function closeJob(Request $request, string $id)
    {

        $job = Job::find($id);

        $job->job_status_id = $request->job_status_id;
        $job->last_update = now();
        $job->close_date = now();

        $job->save();

        return redirect()->back()
            ->with('success', 'Job closed successfully');
    }

    public function removeDuplicates()
    {
        Job::where('job_status_id', 6)->delete();

        return response()->json([
            'message' => 'Duplicate jobs removed successfully'
        ]);
    }

    // public function getQueueJobs()
    // {
    //     $queueJobs = QueueJob::where('queue', 'job-allocation')
    //         ->count();

    //     return Response::json([
    //         'queue_jobs_count' => $queueJobs
    //     ]);
    // }

    /**
     * Get detailed queue status for progress tracking
     */
    public function getQueueStatus()
    {
        try {
            // Get queue jobs for job-allocation queues
            $jobAllocationJobs = DB::table('queue_jobs')
                ->where('queue', 'job-allocation')
                ->count();

            $batchAllocationJobs = DB::table('queue_jobs')
                ->where('queue', 'job-allocation-batch')
                ->count();

            // Get failed jobs
            $failedJobs = DB::table('queue_failed_jobs')
                ->where(function ($query) {
                    $query->where('queue', 'job-allocation')
                        ->orWhere('queue', 'job-allocation-batch');
                })
                ->count();

            // Calculate total pending jobs
            $totalPending = $jobAllocationJobs + $batchAllocationJobs;

            // Get the initial count from session or estimate
            $initialCount = session('initial_queue_count', $totalPending);

            // If we have an initial count and current pending is less, calculate progress
            $processed = max(0, $initialCount - $totalPending);
            $progressPercentage = $initialCount > 0 ? round(($processed / $initialCount) * 100, 2) : 0;

            // If no jobs are pending and we had an initial count, we're done
            if ($totalPending === 0 && $initialCount > 0) {
                $progressPercentage = 100;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'job_allocation_pending' => $jobAllocationJobs,
                    'batch_allocation_pending' => $batchAllocationJobs,
                    'total_pending' => $totalPending,
                    'failed_jobs' => $failedJobs,
                    'initial_count' => $initialCount,
                    'processed' => $processed,
                    'progress_percentage' => $progressPercentage,
                    'is_processing' => $totalPending > 0,
                    'status' => $totalPending > 0 ? 'processing' : 'completed'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error("JobController: Failed to get queue status", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get queue status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set initial queue count for progress tracking
     */
    public function setInitialQueueCount(Request $request)
    {
        $count = $request->input('count', 0);
        session(['initial_queue_count' => $count]);

        return response()->json([
            'success' => true,
            'initial_count' => $count
        ]);
    }

    /**
     * Reset queue progress tracking
     */
    public function resetQueueProgress()
    {
        session()->forget('initial_queue_count');

        return response()->json([
            'success' => true,
            'message' => 'Queue progress reset'
        ]);
    }
}
