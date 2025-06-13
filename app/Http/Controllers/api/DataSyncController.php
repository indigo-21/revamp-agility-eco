<?php

namespace App\Http\Controllers\api;

use App\Models\CompletedJob;
use App\Models\CompletedJobPhoto;
use App\Models\TempSyncLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\ClientInstaller;
use App\Models\ClientKeyDetail;
use App\Models\ClientMeasure;
use App\Models\ClientSlaMetric;
use App\Models\Customer;
use App\Models\Installer;
use App\Models\Job;
use App\Models\JobMeasure;
use App\Models\Property;
use App\Models\PropertyInspector;
use App\Models\PropertyInspectorJobType;
use App\Models\PropertyInspectorMeasure;
use App\Models\PropertyInspectorPostcode;
use App\Models\PropertyInspectorQualification;
use App\Models\UserType;
use App\Models\AccountLevel;
use App\Models\Booking;
use App\Models\ChargingScheme;
use App\Models\Client;
use App\Models\ClientJobType;
use App\Models\ClientType;
use App\Models\JobStatus;
use App\Models\JobType;
use App\Models\Measure;
use App\Models\OutwardPostcode;
use App\Models\Scheme;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionSet;
use App\Models\User;

class DataSyncController extends Controller
{
    public function fetchData(Request $request)
    {
        $modelMap = [
            'account_levels' => AccountLevel::class,
            'user_types' => UserType::class,
            'users' => User::class,
            'client_types' => ClientType::class,
            'charging_schemes' => ChargingScheme::class,
            'clients' => Client::class,
            'job_types' => JobType::class,
            'client_job_types' => ClientJobType::class,
            'survey_question_sets' => SurveyQuestionSet::class,
            'schemes' => Scheme::class,
            'installers' => Installer::class,
            'measures' => Measure::class,
            'job_statuses' => JobStatus::class,
            'survey_questions' => SurveyQuestion::class,
            'outward_postcodes' => OutwardPostcode::class,
            'property_inspectors' => PropertyInspector::class,
            'property_inspector_postcodes' => PropertyInspectorPostcode::class,
            'property_inspector_qualifications' => PropertyInspectorQualification::class,
            'property_inspector_measures' => PropertyInspectorMeasure::class,
            'jobs' => Job::class,
            'job_measures' => JobMeasure::class,
            'customers' => Customer::class,
            'properties' => Property::class,
            'client_key_details' => ClientKeyDetail::class,
            'client_sla_metrics' => ClientSlaMetric::class,
            'client_measures' => ClientMeasure::class,
            'client_installers' => ClientInstaller::class,
            'property_inspector_job_types' => PropertyInspectorJobType::class,
            'bookings' => Booking::class,
            'temp_sync_logs' => TempSyncLogs::class,
            'completed_jobs' => CompletedJob::class,
            'completed_job_photos' => CompletedJobPhoto::class,
        ];

        if (!array_key_exists($request->table, $modelMap)) {
            throw ValidationException::withMessages([
                'table' => ['The table you are trying to access does not exist.'],
            ]);
        }

        $model = $modelMap[$request->table];
        $tableName = (new $model)->getTable();
        $columns = Schema::getColumnListing($tableName);

        $data = $model::select($columns)->get()->map(function ($item) use ($columns) {
            return collect($columns)->mapWithKeys(function ($col) use ($item) {
                $value = $item->$col;

                // Convert date columns to 'Y-m-d H:i:s'
                if ($value instanceof \Carbon\Carbon) {
                    $value = $value->format('Y-m-d H:i:s');
                }

                return [$col => $value];
            });
        });

        return response()->json($data->values());

        // $model = $modelMap[$request->table];

        // $data = $model::all();

        // return response()->json($data);
    }


}
