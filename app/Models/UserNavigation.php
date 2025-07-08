<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNavigation extends Model
{
    protected $fillable = [
        'account_level_id',
        'navigation_id',
        'accessed',
        'job_status_id',
    ];

    public function accountLevel()
    {
        return $this->belongsTo(AccountLevel::class);
    }

    public function navigation()
    {
        return $this->belongsTo(Navigation::class);
    }
}
