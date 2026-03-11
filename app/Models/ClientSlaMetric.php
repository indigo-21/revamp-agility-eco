<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSlaMetric extends Model
{
    protected $fillable = [
        'client_id',
        'client_maximum_retries',
        'maximum_booking_attempts',
        'maximum_remediation_attempts',
        'maximum_no_show',
        'maximum_number_appeals',
        'job_deadline',
        'cat1_remediate_notify',
        'cat1_remediate_notify_duration_unit',
        'cat1_remediate_complete',
        'cat1_remediate_complete_duration_unit',
        'cat1_reinspect_remediation',
        'cat1_reinspect_remediation_duration_unit',
        'cat1_challenge',
        'cat1_challenge_duration_unit',
        'cat1_remediate_no_access',
        'cat1_remediate_no_access_duration_unit',
        'cat1_unremediated',
        'cat1_unremediated_duration_unit',
        'nc_remediate_notify',
        'nc_remediate_notify_duration_unit',
        'nc_remediate_complete',
        'nc_remediate_complete_duration_unit',
        'nc_reinspect_remediation',
        'nc_reinspect_remediation_duration_unit',
        'nc_challenge',
        'nc_challenge_duration_unit',
        'nc_remediate_no_access',
        'nc_remediate_no_access_duration_unit',
        'nc_unremediated',
        'nc_unremediated_duration_unit',
    ];
}
