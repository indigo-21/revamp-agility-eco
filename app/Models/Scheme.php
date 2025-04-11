<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'short_name',
        'long_name',
        'survey_question_set_id',
        'description',
    ];

    public function surveyQuestionSet()
    {
        return $this->belongsTo(SurveyQuestionSet::class);
    }
}
