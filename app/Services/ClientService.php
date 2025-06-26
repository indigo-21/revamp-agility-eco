<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientInstaller;
use App\Models\ClientJobType;
use App\Models\ClientKeyDetail;
use App\Models\ClientMeasure;
use App\Models\ClientSlaMetric;
use App\Models\JobType;
use App\Models\Measure;
use Str;

class ClientService
{
    public function store($request, $user_id, $client_id = null)
    {

        if ($client_id) {
            $client = Client::find($client_id);
        } else {
            $client = new Client();
            $client->user_id = $user_id;
        }

        $client->client_abbrevation = $request->client_abbrevation;
        $client->client_type_id = $request->client_type_id;
        $client->address1 = $request->address1;
        $client->address2 = $request->address2;
        $client->address3 = $request->address3;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->postcode = $request->postcode;

        if ($request->is_active) {
            if (!$client_id) {
                $client->date_last_activated = now();
            }
        } else {
            $client->date_last_deactivated = null;
        }

        $client->save();

        self::storeClientKeyDetails($client, $request);
        self::storeClientSlaMetrics($client, $request);
        self::storeClientInstallers($client, $request);
        self::storeClientMeasures($client, $request);
        self::storeClientJobTypes($client, $request);
    }

    public function storeClientKeyDetails($client, $request)
    {
        $clientKeyDetails = new ClientKeyDetail;

        $clientKeyDetails->client_id = $client->id;
        $clientKeyDetails->is_active = $request->is_active;
        $clientKeyDetails->can_job_outcome_appealed = $request->can_job_outcome_appealed;
        $clientKeyDetails->charging_scheme_id = $request->charging_scheme_id;
        $clientKeyDetails->payment_terms = $request->payment_terms;
        $clientKeyDetails->charge_by_property_rate = $request->charge_by_property_rate;
        $clientKeyDetails->currency = $request->currency;

        $clientKeyDetails->save();
    }

    public function storeClientSlaMetrics($client, $request)
    {
        // Assuming you have a ClientSlaMetrics model
        $clientSlaMetrics = new ClientSlaMetric;

        $clientSlaMetrics->client_id = $client->id;
        $clientSlaMetrics->client_maximum_retries = $request->client_maximum_retries;
        $clientSlaMetrics->maximum_booking_attempts = $request->maximum_booking_attempts;
        $clientSlaMetrics->maximum_remediation_attempts = $request->maximum_remediation_attempts;
        $clientSlaMetrics->maximum_no_show = $request->maximum_no_show;
        $clientSlaMetrics->maximum_number_appeals = $request->maximum_number_appeals;
        $clientSlaMetrics->job_deadline = $request->job_deadline;
        $clientSlaMetrics->cat1_remediate_notify = $request->cat1_remediate_notify;
        $clientSlaMetrics->cat1_remediate_notify_duration_unit = $request->cat1_remediate_notify_duration_unit;
        $clientSlaMetrics->cat1_remediate_complete = $request->cat1_remediate_complete;
        $clientSlaMetrics->cat1_remediate_complete_duration_unit = $request->cat1_remediate_complete_duration_unit;
        $clientSlaMetrics->cat1_reinspect_remediation = $request->cat1_reinspect_remediation;
        $clientSlaMetrics->cat1_reinspect_remediation_duration_unit = $request->cat1_reinspect_remediation_duration_unit;
        $clientSlaMetrics->cat1_challenge = $request->cat1_challenge;
        $clientSlaMetrics->cat1_challenge_duration_unit = $request->cat1_challenge_duration_unit;
        $clientSlaMetrics->cat1_remediate_no_access = $request->cat1_remediate_no_access;
        $clientSlaMetrics->cat1_remediate_no_access_duration_unit = $request->cat1_remediate_no_access_duration_unit;
        $clientSlaMetrics->cat1_unremediated = $request->cat1_unremediated;
        $clientSlaMetrics->cat1_unremediated_duration_unit = $request->cat1_unremediated_duration_unit;
        $clientSlaMetrics->nc_remediate_notify = $request->nc_remediate_notify;
        $clientSlaMetrics->nc_remediate_notify_duration_unit = $request->nc_remediate_notify_duration_unit;
        $clientSlaMetrics->nc_remediate_complete = $request->nc_remediate_complete;
        $clientSlaMetrics->nc_remediate_complete_duration_unit = $request->nc_remediate_complete_duration_unit;
        $clientSlaMetrics->nc_reinspect_remediation = $request->nc_reinspect_remediation;
        $clientSlaMetrics->nc_reinspect_remediation_duration_unit = $request->nc_reinspect_remediation_duration_unit;
        $clientSlaMetrics->nc_challenge = $request->nc_challenge;
        $clientSlaMetrics->nc_challenge_duration_unit = $request->nc_challenge_duration_unit;
        $clientSlaMetrics->nc_remediate_no_access = $request->nc_remediate_no_access;
        $clientSlaMetrics->nc_remediate_no_access_duration_unit = $request->nc_remediate_no_access_duration_unit;
        $clientSlaMetrics->nc_unremediated = $request->nc_unremediated;
        $clientSlaMetrics->nc_unremediated_duration_unit = $request->nc_unremediated_duration_unit;

        $clientSlaMetrics->save();
    }

    public function storeClientInstallers($client, $request)
    {
        $client->clientInstallers()->delete(); // Clear existing installers

        if (isset($request->client_installers)) {
            foreach ($request->client_installers as $installer) {
                $clientInstaller = new ClientInstaller;

                $clientInstaller->client_id = $client->id;
                $clientInstaller->installer_id = $installer;

                $clientInstaller->save();
            }
        }
    }

    public function storeClientMeasures($client, $request)
    {
        $client->clientMeasures()->delete(); // Clear existing measures

        if (isset($request->measures)) {
            foreach ($request->measures as $measureData) {
                // Find or create the measure by category
                $measure = Measure::where('measure_cat', $measureData['measure_cat'])->first();

                $clientMeasure = new ClientMeasure;

                $clientMeasure->client_id = $client->id;
                $clientMeasure->measure_id = $measure?->id;
                $clientMeasure->measure_fee = $measureData['measure_fee_value'];
                $clientMeasure->measure_fee_currency = $measureData['measure_fee_currency'];

                $clientMeasure->save();
            }
        }
    }

    public function storeClientJobTypes($client, $request)
    {
        $client->clientJobTypes()->delete(); // Clear existing job types

        if (isset($request->job_type_id)) {
            foreach ($request->job_type_id as $jobType) {
                $jobTypeData = JobType::find($jobType);

                $clientJobType = new ClientJobType;

                $clientJobType->client_id = $client->id;
                $clientJobType->job_type_id = $jobType;
                $clientJobType->visit_duration = $request[Str::lower($jobTypeData->type) . "_visit_duration"];

                $clientJobType->save();
            }
        }
    }
}