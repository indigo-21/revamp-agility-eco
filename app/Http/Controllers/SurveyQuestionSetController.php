<?php

namespace App\Http\Controllers;

use App\Imports\surveyQuestionImport;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionSet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class SurveyQuestionSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveyQuestionSets = SurveyQuestionSet::all();
        return view('pages.platform-configuration.survey-question-set.index', compact('surveyQuestionSets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('question_set_file') && $request->file('question_set_file')->isValid()) {         
            $file = $request->file('question_set_file');
            $extension = $file->getClientOriginalExtension();
            $newdate= Carbon::now()->format('Y-m-d_H-i-s');
            $newName = $request->question_revision.'-'.$newdate.'.'.$extension;  
            $path = $file->storeAs('uploads',$newName,'public');
        }
        $question_set = new SurveyQuestionSet($request->all());
        $question_set->question_set_file = $newName; 
        $question_set->save();

        Excel::import(new surveyQuestionImport($question_set->id), $file);

        return redirect()->route('survey-question-set.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            "surveyQuestionSets"=> SurveyQuestionSet::find($id),
            "surveyQuestions"   => SurveyQuestion::where('survey_question_set_id',$id)->get(),
        ];
        // dd( $surveyQuestionSets);
        return view('pages.platform-configuration.survey-question-set.show', $data);
        // return view('pages.platform-configuration.survey-question-set.show',compact('surveyQuestionSets'));
      
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
