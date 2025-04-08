<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInspectorMeasure extends Model
{
    public function propertyInspector()
    {
        return $this->belongsTo(PropertyInspector::class);
    }
    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }
}
