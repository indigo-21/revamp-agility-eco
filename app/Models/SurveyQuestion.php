<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = [
        'survey_question_set_id',
        'measure_cat',
        'inspection_stage',
        'question_number',
        'question',
        'can_have_photo',
        'na_allowed',
        'unable_to_validate_allowed',
        'remote_reinspection_allowed',
        'score_monitoring',
        'nc_severity',
        'uses_dropdown',
        'dropdown_list',
        'innovation_measure',
        'innovation_question_list',
        'measure_type',
        'innovation_product'
        
    ];
}
