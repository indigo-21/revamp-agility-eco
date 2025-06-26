<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PropertyInspector;
use App\Models\PropertyInspectorMeasure;
use App\Models\PropertyInspectorQualification;
use Illuminate\Http\Request;

class DocumentExceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentExpires = PropertyInspector::where('photo_expiry', '<=', now())
            ->where('photo_expiry', '!=', null)
            ->get();
        $qualificationExpires = PropertyInspectorQualification::where('expiry_date', '<=', now())
            ->where('expiry_date', '!=', null)
            ->get();
        $measureExpires = PropertyInspectorMeasure::where('expiry', '<=', now())
            ->where('expiry', '!=', null)
            ->get();

        return view('pages.exception.document.index')
            ->with('documentExpires', $documentExpires)
            ->with('qualificationExpires', $qualificationExpires)
            ->with('measureExpires', $measureExpires);
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
