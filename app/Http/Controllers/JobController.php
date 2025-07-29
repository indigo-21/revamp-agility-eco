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
use App\Models\Scheme;
use App\Models\UpdateSurvey;
use App\Services\JobDispatcherService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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
                // $batchIds = [];

                // Split data into batches and dispatch
                $batches = array_chunk($processedData, $batchSize);
                // foreach ($batches as $index => $batch) {
                //     foreach ($batch as $row) {
                //         // $batchId = "upload_{$fileName}_{$index}_" . now()->format('YmdHis');
                //         $this->jobDispatcherService->dispatchJob($row);
                //         // $batchIds[] = $batchId;
                //     }
                // }

                // Log::info("JobController: File upload queued for processing", [
                //     'filename' => $fileName,
                //     'records_queued' => $jobDataCount,
                //     'batches_created' => count($batches)
                // ]);

                return redirect()->back()
                    ->with('success', "Jobs queued for processing.")
                    ->with('message', " {$jobDataCount} records will be processed asynchronously in " . count($batches) . " batches. Please wait for the job to complete since there are multiple records to process.");
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
}
