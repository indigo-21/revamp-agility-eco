<?php

namespace App\Http\Controllers;

use App\Models\CompletedJob;
use App\Models\CompletedJobPhoto;
use App\Models\Job;
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
        // return true;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $imageName = $photo->getClientOriginalName();
            $photo->storeAs('completed_job_photos', $imageName, 'public');

            $completedJobPhoto = new CompletedJobPhoto;

            $completedJobPhoto->id = Str::uuid()->toString();
            $completedJobPhoto->completed_job_id = $request->input('completed_job_id');
            $completedJobPhoto->filename = $imageName;
            $completedJobPhoto->file_path = $request->input('filepath');
            $completedJobPhoto->status = 1;

            $completedJobPhoto->save();

            return $imageName;
        } else {
            return response()->json(['error' => 'No file received.'], 400);
        }
    }

    public function deleteSurveyPhoto(Request $request)
    {
        $completedJobPhoto = CompletedJobPhoto::find($request->input('completed_job_photo_id'));

        if (!$completedJobPhoto) {
            throw ValidationException::withMessages(['completed_job_photo_id' => 'Completed job photo not found.']);
        }

        $completedJobPhoto->delete();
        return response()->json(['message' => 'Completed job photo deleted successfully.'], 200);
    }

    
}
