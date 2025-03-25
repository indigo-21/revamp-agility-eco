<?php

namespace Database\Seeders;

use App\Models\JobStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'status' => 'job_booked',
                'description' => 'Job Booked',
                'generic_state' => 'BOOKED',
            ],
            [
                'status' => 'job_booked_notuploaded',
                'description' => 'Job Booked Not Uploaded',
                'generic_state' => 'BOOKED',
            ],
            [
                'status' => 'job_complete_pass',
                'description' => 'Job Complete Pass',
                'generic_state' => 'COMPLETED',
            ],
            [
                'status' => 'job_complete_pass_invoiced',
                'description' => 'Job Complete Pass Invoiced',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_data_invalid_already_sent',
                'description' => 'Job already sent',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_data_invalid_duplicate',
                'description' => 'Job Duplicate',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_data_invalid_newInstaller',
                'description' => 'Invalid Installer',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_data_invalid_newMeasure',
                'description' => 'Invalid Measure',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_data_invalid_newScheme',
                'description' => 'Invalid Scheme',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_data_invalid_postcode',
                'description' => 'Invalid Postcode',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_data_invalid_primary_contact',
                'description' => 'Invalid Primary Contact',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_dataValid',
                'description' => 'Job Valid',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_decideFirmPI',
                'description' => 'Decide PI',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_fail_appeal_invoiced',
                'description' => 'Job Appeal Invoiced',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_fail_customer_refused',
                'description' => 'Job Fail Customer Refused',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_fail_nc',
                'description' => 'Job Fail',
                'generic_state' => 'APPEAL',
            ],
            [
                'status' => 'job_fail_remediation_invoiced',
                'description' => 'Job Fail Remediation Invoiced',
                'generic_state' => 'CLOSED',
            ],
            [
                'status' => 'job_import_fail_clientInactive',
                'description' => 'Client Inactive',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_import_fail_unspecified',
                'description' => 'Fail Unspecified',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_imported',
                'description' => 'Imported',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_need_firm_pi_none_available',
                'description' => 'Need Firm PI',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_no_pi_available',
                'description' => 'No PI Available',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_rebook_customer',
                'description' => 'Rebook Customer',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_rebook_surveyor',
                'description' => 'Rebook Surveyor',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_unbooked',
                'description' => 'Job Unbooked',
                'generic_state' => 'UNBOOKED',
            ],
            [
                'status' => 'job_rebook_reinspect',
                'description' => 'Rebook Resinpect',
                'generic_state' => 'UNBOOKED',
            ],
            
        );

        foreach ($values as $value) {
            JobStatus::create([
                'status' => $value['status'],
                'description' => $value['description'],
                'generic_state' => $value['generic_state'],
            ]);
        }
    }
}
