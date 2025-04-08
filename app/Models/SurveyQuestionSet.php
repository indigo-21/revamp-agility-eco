<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionSet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'question_revision',
        'question_set',        
        'question_set_file'
    ];

}
