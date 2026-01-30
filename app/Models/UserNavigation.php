<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNavigation extends Model
{
    protected $fillable = [
        'account_level_id',
        'navigation_id',
        'permission',
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
