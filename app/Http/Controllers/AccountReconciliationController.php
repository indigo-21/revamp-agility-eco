<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use Illuminate\Http\Request;

class AccountReconciliationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobs = Job::whereNotNull('invoice_status_id');
        $clients = Client::all();

        if ($request->filled('invoice_status_id')) {

            if ($request->invoice_status_id == 1) {
                $jobs->where('invoice_status_id', 2);
            } else if ($request->invoice_status_id == 2) {
                $jobs->where('invoice_status_id', 1);
            }
        }

        if ($request->filled('client_name')) {
            $jobs->where('client_id', (int) $request->client_name);
        }

        $jobs = $jobs->get();


        return view('pages.account-reconciliation.index')
            ->with('jobs', $jobs)
            ->with('clients', $clients);
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

        $job->invoice_status_id = 2;

        $job->save();

        return response()->json([
            'status' => true,
            'message' => 'Job invoice status updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
