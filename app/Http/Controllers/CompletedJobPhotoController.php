<?php

namespace App\Http\Controllers;

use App\Models\CompletedJob;
use App\Models\CompletedJobPhoto;
use App\Models\Job;
use App\Models\UpdateSurvey;
use App\Services\UpdateSurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompletedJobPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadCompletedJobPhoto(Request $request)
    {

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $imageName = $photo->getClientOriginalName();
            $photo->storeAs('completed_job_photos', $imageName, 'public');

            return $imageName;
            // return response()->json([
            //     'filename' => $photo->getClientOriginalName(),
            //     'mime_type' => $photo->getMimeType(),
            //     'size' => $photo->getSize(),
            //     'name' => $photo->getClientOriginalName(),
            // ]);
        } else {
            return response()->json(['error' => 'No file received.'], 400);
        }

    }

    public function updateSurveyPhoto(Request $request)
    {
        $completedJob = CompletedJob::find($request->completed_job_id);
        $job = Job::find($completedJob->job_id);
        $updateOutcome = "Added Images. <br>";

        if ($request->hasFile('photo')) {
            $updateSurvey = new UpdateSurvey();

            $updateSurvey->job_id = $job->id;
            $updateSurvey->completed_job_id = $completedJob->id;
            $updateSurvey->user_id = auth()->user()->id;
            $updateSurvey->update_outcome = "Added Images. <br>";

            foreach ($request->file('photo') as $photo) {

                $imageName = $photo->getClientOriginalName();
                $photo->storeAs('completed_job_photos', $imageName, 'public');

                $updateOutcome .= "Image: <a href='/storage/completed_job_photos/{$imageName}' target='_blank'
                        class='btn-link text-danger'>{$imageName}</a> <br>";

                $completedJobPhoto = new CompletedJobPhoto;

                $completedJobPhoto->id = Str::uuid()->toString();
                $completedJobPhoto->completed_job_id = $completedJob->id;
                $completedJobPhoto->filename = $imageName;
                $completedJobPhoto->file_path = $request->input('filepath');
                $completedJobPhoto->status = 1;

                $completedJobPhoto->save();

            }
        }

        (new UpdateSurveyService)->store(
            $job->id,
            $completedJob->id,
            $updateOutcome
        );
    }

    public function deleteSurveyPhoto(Request $request)
    {
        $completedJobPhoto = CompletedJobPhoto::find($request->input('completed_job_photo_id'));
        $completedJob = CompletedJob::find($completedJobPhoto->completed_job_id);
        $job = Job::find($completedJob->job_id);

        (new UpdateSurveyService)->store(
            $job->id,
            $completedJob->id,
            "Image Removed. <br> Image: {$completedJobPhoto->filename} <br>"
        );

        if (!$completedJobPhoto) {
            throw ValidationException::withMessages(['completed_job_photo_id' => 'Completed job photo not found.']);
        }

        $completedJobPhoto->delete();
        return response()->json(['message' => 'Completed job photo deleted successfully.'], 200);
    }


}
