<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PropertyInspector extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function propertyInspectorPostcodes()
    {
        return $this->hasMany(PropertyInspectorPostcode::class);
    }
    public function propertyInspectorJobTypes()
    {
        return $this->hasMany(PropertyInspectorJobType::class);
    }
    public function propertyInspectorMeasures()
    {
        return $this->hasMany(PropertyInspectorMeasure::class);
    }
    public function propertyInspectorQualifications()
    {
        return $this->hasMany(PropertyInspectorQualification::class);
    }
}
