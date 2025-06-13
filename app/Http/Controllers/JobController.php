<?php

namespace App\Http\Controllers;

use App\Imports\JobImport;
use App\Models\Client;
use App\Models\ClientJobType;
use App\Models\Customer;
use App\Models\Installer;
use App\Models\Job;
use App\Models\Measure;
use App\Models\Scheme;
use App\Services\JobService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();
        $clients = Client::whereHas('clientKeyDetails', function ($query) {
            $query->where('is_active', 1);
        })->with('clientKeyDetails')->get();

        return view('pages.job.index')
            ->with('jobs', $jobs)
            ->with('clients', $clients);
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

        return view('pages.job.show')
            ->with('job', $job);
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

    public function upload(Request $request)
    {
        $job_import = new JobImport;
        Excel::import($job_import, $request->file);

        // save the file to storage public
        $storagePath = 'job_imports';
        $fileName = $request->file->getClientOriginalName();
        $request->file('file')->storeAs($storagePath, $fileName, 'public');

        foreach ($job_import->job_data as $row) {
            $scheme_data = Scheme::where('short_name', $row->scheme_id)->first();
            $installer_data = Installer::with('user')
                ->whereHas('user', function ($query) use ($row) {
                    $query->where('firstname', $row->installer_id);
                })->first();


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

            // dd($row);

            (new JobService())->store($row);

        }

        return redirect()->back()->with('success', 'Jobs imported successfully');
    }

    public function searchClient(Request $request)
    {
        $client_job_types = Client::where('id', $request->client_id)
            ->with(['clientJobType', 'clientJobType.jobType'])
            ->get();

        return response()->json($client_job_types);
    }
}
