<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measure;
use Illuminate\Http\Request;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $measures = Measure::all();
       return view('pages.platform-configuration.measure.index')
       ->with("measures", $measures);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $measures = Measure::all();

        return view("pages.platform-configuration.measure.form")
        ->with('measures', $measures);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $measure = new Measure($request->all());

        $measure->save();

        return redirect()->route('measure.index')->with('success', 'Measure created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Measure $measure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Measure $measure)
    {

        return view("pages.platform-configuration.measure.form")
        ->with('measure', $measure);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Measure $measure)
    {
        $data = $request->except (['_token', '_method']);
        $measure->update($data);

        return redirect()->route('measure.index')->with('success', 'Measure updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measure $measure)
    {
        //
    }

    
}
