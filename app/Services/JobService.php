<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Customer;
use App\Models\Exception;
use App\Models\Installer;
use App\Models\Job;
use App\Models\JobMeasure;
use App\Models\Measure;
use App\Models\Property;
use App\Models\Scheme;
use Carbon\Carbon;

class JobService
{
    public function store($request)
    {
        foreach ($request->measures as $measure) {
            $job = new Job;

            [
                $client,
                $installer_data,
                $scheme_data,
                $job_number,
                $measure_data,
                $job_status,
                $property_inspector
            ] = self::jobValidation($request, $measure);

            $request->deadline = $client ? (int) $client->clientSlaMetric->job_deadline : 0;
            $request->first_visit_by = $client ? (int) $client->clientSlaMetric->job_deadline / 2 : 0;

            $job->job_number = $job_number;
            $job->cert_no = $request->cert_no;
            $job->job_type_id = $request->job_type_id;
            $job->job_status_id = $job_status;
            $job->last_update = now();
            $job->client_id = $client?->id;
            $job->max_attempts = 0;
            $job->max_noshow = 0;
            $job->max_remediation = 0;
            $job->max_appeal = 0;
            $job->deadline = Carbon::now()->addDays($request->deadline);
            $job->first_visit_by = Carbon::now()->addDays($request->first_visit_by);
            $job->property_inspector_id = $property_inspector?->first()->id ?? null;
            $job->duration = $measure_data?->measure_duration;
            $job->notes = $request->notes ?? null;
            $job->lodged_by_tmln = $request->lodged_by_tmln;
            $job->lodged_by_name = $request->lodged_by_name;
            $job->installer_id = $installer_data?->id;
            $job->sub_installer_tmln = $request->sub_installer_tmln;
            $job->scheme_id = $scheme_data?->id;
            $job->csv_filename = $request->csv_filename ?? null;

            $job->save();

            self::storeJobCustomer($request, $job->id);
            self::storeJobProperty($request, $job->id);
            // if ($job_status != 8) {
            self::storeJobMeasure($measure, $measure_data, $job->id);
            // }
        }


        return $request;
    }

    public function update($request, $measure)
    {
        $job = Job::find($request->id);

        [
            $client,
            $installer_data,
            $scheme_data,
            $job_number,
            $measure_data,
            $job_status,
            $property_inspector
        ] = self::jobValidation($request, $measure, $update = true);

        $job->job_status_id = $job_status;
        $job->property_inspector_id = $property_inspector?->first()->id ?? null;
        $job->duration = $measure_data?->measure_duration;
        $job->installer_id = $installer_data?->id;
        $job->scheme_id = $scheme_data?->id;

        $job->save();

        return $job_status;

    }

    public function storeJobCustomer($request, $job_id)
    {
        $job_customer = new Customer;

        $job_customer->job_id = $job_id;
        $job_customer->customer_name = $request->customer_name;
        $job_customer->customer_primary_tel = $request->customer_primary_tel;
        $job_customer->customer_secondary_tel = $request->customer_secondary_tel;
        $job_customer->customer_email = $request->customer_email;

        $job_customer->save();
    }

    public function storeJobProperty($request, $job_id)
    {
        $job_property = new Property;

        $job_property->job_id = $job_id;
        $job_property->house_flat_prefix = $request->house_flat_prefix;
        $job_property->address1 = $request->address1;
        $job_property->address2 = $request->address2;
        $job_property->address3 = $request->address3;
        $job_property->city = $request->city;
        $job_property->county = $request->county;
        $job_property->postcode = $request->postcode;

        $job_property->save();
    }

    public function storeJobMeasure($measure, $measure_data, $job_id)
    {
        $job_measure = new JobMeasure;

        $job_measure->job_id = $job_id;
        $job_measure->measure_id = $measure_data?->id;
        $job_measure->umr = $measure['umr'];
        $job_measure->info = $measure['info'];

        $job_measure->save();
    }

    public function jobValidation($request, $measure, $update = false)
    {

        $client = self::getClient($request);
        $job_duplicates = self::checkJobDuplicates($request, $measure);
        $installer_data = self::getInstaller($request);
        $scheme_data = self::getScheme($request);
        $job_number = self::getJobNumber($request, $client, $measure);
        $measure_data = self::getMeasure($measure);
        $check_customer_contact = $this->checkCustomerContactInformation($request);
        $postcode = (new PropertyInspectorJobAllocationService)->getPostcode($request->postcode);

        if (!$measure_data) {
            // return job status 8 - job data invalid measure
            $job_status = 8;

            // create exception for invalid measure
            self::storeException($request->cert_no, $measure['umr'], 8, $measure['measure_cat'], $measure['info']);

        } else if (!$job_duplicates && !$update) {
            // return job status 6 - job data invalid duplicate
            $job_status = 6;
        } else if (!$postcode) {
            // return job status 10 - job data invalid postcode
            $job_status = 10;

            // self::storeException($request, $measure, 10, $request->postcode);


        } else if (!$installer_data) {
            // return job status 7 - job data invalid installer
            $job_status = 7;

            //   self::storeException($request, $measure, 7, $request->installer_id);

        } else if ($client->clientKeyDetails->is_active == 0) {
            // return job status 18 - job data client inactive
            $job_status = 18;
        } else if (!$scheme_data) {
            // return job status 19 - job data invalid scheme
            $job_status = 9;

            // self::storeException($request, $measure, 9, $request->scheme_id);

        } else if (!$check_customer_contact && !$update) {
            // return job status 11 - job data invalid contact information
            $job_status = 11;
        } else {
            $job_status = 12;
        }

        if ($job_status == 12) {
            $property_inspector = (new PropertyInspectorJobAllocationService())->PIAllocationProcess($request, $measure, false);

            // return job status 22 - job data no property inspector
            // return job status 25 - job data property inspector allocated (job_unbooked)
            $job_status = !isset($property_inspector) && $property_inspector == null ? 22 : 25;
        }

        return [
            $client,
            $installer_data,
            $scheme_data,
            $job_number,
            $measure_data,
            $job_status,
            $property_inspector ?? null
        ];
    }

    public function checkJobDuplicates($request, $measure): bool
    {
        $getUmrAndCert = Job::with('jobMeasure')
            ->where('cert_no', $request->cert_no)
            ->whereHas('jobMeasure', function ($query) use ($measure) {
                $query->where('umr', $measure['umr']);
            })
            ->count();

        if ($getUmrAndCert > 0) {
            return false;
        }

        return true;
    }

    public function storeException($cert_no, $umr, $status, $value, $info = null)
    {
        $exception = new Exception;

        $exception->umr = $umr;
        $exception->cert_no = $cert_no;
        $exception->value = $value;
        $exception->info = $info;
        $exception->job_status_id = $status;

        $exception->save();

    }

    public function getJobNumber($request, $client, $measure)
    {
        $job_number = '';
        $first_job_number = 1;

        // $last_job = Job::orderBy('created_at', 'desc')
        //     ->first();

        $last_job = Job::orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(job_number, '-', 1), SUBSTRING(job_number, 1, 3), -1) AS UNSIGNED) DESC")
            ->first();

        $job_duplicate = Job::with('jobMeasure')
            ->where('cert_no', $request->cert_no)
            ->get();

        // Example job number = AES0000000001-01
        // get the digits before the after the AES and -

        if ($job_duplicate->isNotEmpty()) {
            $last_job_number = $job_duplicate[0]->job_number;
            $last_job_number = explode('-', $last_job_number);
            $last_job_number = substr($last_job_number[0], 3);
            $last_job_number = (int) $last_job_number;
            $mid_job_number = str_pad($last_job_number, 10, '0', STR_PAD_LEFT);
        } else {
            if ($last_job) {
                $last_job_number = $last_job->job_number;
                $last_job_number = explode('-', $last_job_number);
                $last_job_number = substr($last_job_number[0], 3);
                $last_job_number = (int) $last_job_number + 1;
                $mid_job_number = str_pad($last_job_number, 10, '0', STR_PAD_LEFT);
            } else {
                $mid_job_number = str_pad($first_job_number, 10, '0', STR_PAD_LEFT);
            }
        }

        $job_number = "{$client->client_abbrevation}{$mid_job_number}-" . str_pad($job_duplicate->count() + 1, 2, '0', STR_PAD_LEFT);

        return $job_number;

    }

    public function checkCustomerContactInformation($request)
    {
        $contact_primary_tel = $request->customer_primary_tel;

        $contact_information_1 = substr($contact_primary_tel, 0, 1);
        $contact_information_2 = substr($contact_primary_tel, 0, 2);

        if (in_array($contact_information_1, ['1', '2', '3', '7', '8']) || $contact_information_2 === '44') {

            if (in_array($contact_information_1, ['1', '2', '3', '7', '8'])) {
                $contact_primary_tel = "0{$contact_primary_tel}";
            }

            $contact_prefix = substr($contact_primary_tel, 0, in_array($contact_primary_tel[1], ['4']) ? 3 : 2);
            $contact_length = strlen($contact_primary_tel);

            if (
                (in_array($contact_prefix, ['01', '02', '03', '07', '08']) || in_array($contact_prefix, ['441', '442', '443', '447', '448']))
                && in_array($contact_length, [10, 11, 12])
            ) {
                $request->customer_primary_tel = $contact_primary_tel;
                return true;
            }
        }

        return false;
    }

    public function getClient($request)
    {
        return Client::find($request->client_id);
    }

    public function getInstaller($request)
    {
        return Installer::find($request->installer_id);
    }

    public function getScheme($request)
    {
        return Scheme::find($request->scheme_id);
    }

    public function getMeasure($measure)
    {
        return Measure::where('measure_cat', $measure['measure_cat'])->first();
    }
}