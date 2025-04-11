<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyQuestionSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'question_revision',
        'question_set',
        'question_set_file'
    ];

}
