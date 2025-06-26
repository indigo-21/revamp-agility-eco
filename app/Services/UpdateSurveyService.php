<?php 

namespace App\Services;

use App\Models\UpdateSurvey;

class UpdateSurveyService
{
    public function store($job_id, $completed_job_id, $update_outcome)
    {
        $updateSurvey = new UpdateSurvey;

        $updateSurvey->job_id = $job_id;
        $updateSurvey->completed_job_id = $completed_job_id;
        $updateSurvey->user_id = auth()->user()->id;
        $updateSurvey->update_outcome = $update_outcome;

        $updateSurvey->save();
    }
}