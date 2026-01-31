<?php

namespace App\Services;

use App\Models\JobType;
use App\Models\Measure;
use App\Models\PropertyInspector;
use App\Models\PropertyInspectorJobType;
use App\Models\PropertyInspectorMeasure;
use App\Models\PropertyInspectorPostcode;
use App\Models\PropertyInspectorQualification;

class PropertyInspectorService
{
    public function store($request, $user_id, $pi_id = null)
    {

        if ($pi_id) {
            $property_inspector = PropertyInspector::find($pi_id);
        } else {
            $property_inspector = new PropertyInspector();
            $property_inspector->user_id = $user_id;
        }

        $id_badge = (new StoreImage)->store($request, 'id_badge', 'id_badge');

        if ($id_badge) {
            $property_inspector->id_badge = $id_badge;
        }

        $property_inspector->is_active = $request->is_active;
        $property_inspector->can_book_jobs = $request->can_book_jobs;
        $property_inspector->pi_employer = $request->pi_employer;
        $property_inspector->photo_expiry = $request->photo_expiry;
        $property_inspector->id_issued = $request->id_issued;
        $property_inspector->id_expiry = $request->id_expiry;
        $property_inspector->id_revision = $request->id_revision;
        $property_inspector->id_location = $request->id_location;
        $property_inspector->id_return = $request->id_return;
        $property_inspector->address1 = $request->address1;
        $property_inspector->address2 = $request->address2;
        $property_inspector->address3 = $request->address3;
        $property_inspector->city = $request->city;
        $property_inspector->county = $request->county;
        $property_inspector->postcode = $request->postcode;
        $property_inspector->charging_scheme_id = $request->charging_scheme_id;
        $property_inspector->property_visit_fee = $request->property_visit_fee;
        $property_inspector->property_fee_currency = $request->property_fee_currency;
        $property_inspector->payment_terms = $request->payment_terms;
        $property_inspector->vat = $request->vat;
        $property_inspector->vat_no = $request->vat_no;
        $property_inspector->registered_id_number = $request->registered_id_number;
        $property_inspector->audit_jobs = $request->audit_jobs;
        $property_inspector->hours_spent = $request->hours_spent;
        $property_inspector->work_sat = $request->work_sat;
        $property_inspector->work_sun = $request->work_sun;


        // Save the data to the database
        $property_inspector->save();

        self::storePIPostcode($property_inspector->id, $request);
        self::storePIJobType($property_inspector->id, $request);
        self::storePIMeasures($property_inspector->id, $request);
        self::storePIQualifications($property_inspector->id, $request);

        return $property_inspector->id;
    }

    public function storePIPostcode($pi_id, $request)
    {

        PropertyInspectorPostcode::whereNotIn('outward_postcode_id', $request->outward_postcode_id)
            ->where('property_inspector_id', $pi_id)
            ->delete();

        foreach ($request->outward_postcode_id as $postcode) {

            $property_inspector_postcode = PropertyInspectorPostcode::where('outward_postcode_id', $postcode)
                ->where('property_inspector_id', $pi_id)
                ->first();

            if ($property_inspector_postcode) {
                continue;
            } else {
                $property_inspector_postcode = new PropertyInspectorPostcode();

                $property_inspector_postcode->outward_postcode_id = $postcode;
                $property_inspector_postcode->property_inspector_id = $pi_id;

                $property_inspector_postcode->save();
            }
        }
    }

    public function storePIJobType($pi_id, $request)
    {

        $job_types = JobType::all();

        foreach ($job_types as $job_type) {

            if ($request[$job_type->type] == 1) {

                $exists = PropertyInspectorJobType::where('job_type_id', $job_type->id)
                    ->where('property_inspector_id', $pi_id)
                    ->exists();

                if (!$exists) {
                    $property_inspector_job_type = new PropertyInspectorJobType;

                    $property_inspector_job_type->property_inspector_id = $pi_id;
                    $property_inspector_job_type->job_type_id = $job_type->id;
                    $property_inspector_job_type->rating = $request["{$job_type->type}_rating"];

                    $property_inspector_job_type->save();
                } else {
                    $property_inspector_job_type = PropertyInspectorJobType::where('job_type_id', $job_type->id)
                        ->where('property_inspector_id', $pi_id)
                        ->first();

                    $property_inspector_job_type->rating = $request["{$job_type->type}_rating"];

                    $property_inspector_job_type->save();
                }
            } else {
                $property_inspector_job_type = PropertyInspectorJobType::where('job_type_id', $job_type->id)
                    ->where('property_inspector_id', $pi_id)
                    ->delete();
            }

        }
    }

    public function storePIMeasures($pi_id, $request)
    {
        $measures = $request->measures ?? [];

        $existingIds = collect($measures)
            ->pluck('pi_measure_id')
            ->filter()
            ->values()
            ->all();

        $deleteQuery = PropertyInspectorMeasure::where('property_inspector_id', $pi_id);
        if (!empty($existingIds)) {
            $deleteQuery->whereNotIn('id', $existingIds);
        }
        $deleteQuery->delete();

        foreach ($measures as $index => $measure) {
            $measureId = $measure['measure_id'] ?? null;
            if (!$measureId && !empty($measure['measure_cat'])) {
                $measureData = Measure::where('measure_cat', $measure['measure_cat'])->first();
                $measureId = $measureData?->id;
            }

            if (!$measureId) {
                continue;
            }

            $property_inspector_measure = null;
            if (!empty($measure['pi_measure_id'])) {
                $property_inspector_measure = PropertyInspectorMeasure::where('id', $measure['pi_measure_id'])
                    ->where('property_inspector_id', $pi_id)
                    ->first();
            }

            if (!$property_inspector_measure) {
                $property_inspector_measure = new PropertyInspectorMeasure;
                $property_inspector_measure->property_inspector_id = $pi_id;
            }

            $measure_certificate = (new StoreImage)->store($request, "measures.$index.measure_certificate", 'measure_certificate');

            $property_inspector_measure->measure_id = $measureId;
            $property_inspector_measure->fee_value = $measure['measure_fee_value'] ?? null;
            $property_inspector_measure->fee_currency = $measure['measure_fee_currency'] ?? null;
            $property_inspector_measure->expiry = $measure['measure_expiry_date'] ?? null;

            if ($measure_certificate) {
                $property_inspector_measure->cert = $measure_certificate;
            }

            if ($property_inspector_measure->exists || $measure_certificate) {
                $property_inspector_measure->save();
            }
        }

    }

    public function storePIQualifications($pi_id, $request)
    {
        $qualifications = $request->qualifications ?? [];

        $existingIds = collect($qualifications)
            ->pluck('pi_qualification_id')
            ->filter()
            ->values()
            ->all();

        $deleteQuery = PropertyInspectorQualification::where('property_inspector_id', $pi_id);
        if (!empty($existingIds)) {
            $deleteQuery->whereNotIn('id', $existingIds);
        }
        $deleteQuery->delete();

        foreach ($qualifications as $index => $qualification) {
            $property_inspector_qualification = null;
            if (!empty($qualification['pi_qualification_id'])) {
                $property_inspector_qualification = PropertyInspectorQualification::where('id', $qualification['pi_qualification_id'])
                    ->where('property_inspector_id', $pi_id)
                    ->first();
            }

            if (!$property_inspector_qualification) {
                $property_inspector_qualification = new PropertyInspectorQualification;
                $property_inspector_qualification->property_inspector_id = $pi_id;
            }

            $qualification_certificate = (new StoreImage)->store($request, "qualifications.$index.qualification_certificate", 'qualification_certificate');

            $property_inspector_qualification->name = $qualification['qualification_name'] ?? null;
            $property_inspector_qualification->issue_date = $qualification['qualification_issue_date'] ?? null;
            $property_inspector_qualification->expiry_date = $qualification['qualification_expiry_date'] ?? null;
            $property_inspector_qualification->qualification_issue = $qualification['qualification_issue'] ?? null;

            if ($qualification_certificate) {
                $property_inspector_qualification->certificate = $qualification_certificate;
            }

            if ($property_inspector_qualification->exists || $qualification_certificate) {
                $property_inspector_qualification->save();
            }
        }
    }
}