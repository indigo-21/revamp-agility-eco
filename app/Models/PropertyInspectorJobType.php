<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInspectorJobType extends Model
{
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}
