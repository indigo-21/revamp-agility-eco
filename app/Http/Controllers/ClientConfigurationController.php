<?php

namespace App\Http\Controllers;

use App\Models\ClientConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.client-configuration.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.client-configuration.form');
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
    public function show(ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientConfiguration $clientConfiguration)
    {
        //
    }
}
