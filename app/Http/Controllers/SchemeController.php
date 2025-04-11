<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use App\Models\SurveyQuestionSet;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schemes = Scheme::all();

        return view('pages.platform-configuration.scheme.index')
            ->with('schemes', $schemes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $survey_question_set = SurveyQuestionSet::all();

        return view('pages.platform-configuration.scheme.form')
            ->with('survey_question_set', $survey_question_set);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $scheme = new Scheme($request->all());
        $scheme->save();

        return redirect()->route('scheme.index')
            ->with('success', 'Scheme created successfully.');

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
        $scheme = Scheme::findOrFail($id);
        $survey_question_set = SurveyQuestionSet::all();

        return view('pages.platform-configuration.scheme.form')
            ->with('scheme', $scheme)
            ->with('survey_question_set', $survey_question_set);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $scheme = Scheme::findOrFail($id);
        $scheme->update($request->all());

        return redirect()->route('scheme.index')
            ->with('success', 'Scheme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scheme = Scheme::findOrFail($id);
        $scheme->delete();

        return redirect()->route('scheme.index')
            ->with('success', 'Scheme deleted successfully.');
    }
}
