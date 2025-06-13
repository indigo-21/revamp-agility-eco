<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompletedJob extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;


    public function surveyQuestionSet(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestionSet::class);
    }

    public function surveyQuestion(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    public function completedJobPhotos(): HasMany
    {
        return $this->hasMany(CompletedJobPhoto::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function remediations(): HasMany
    {
        return $this->hasMany(Remediation::class);
    }
}
