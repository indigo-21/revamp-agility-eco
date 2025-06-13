<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Navigation extends Model
{
    protected $casts = [
        'has_dropdown' => 'boolean',
    ];

    public function userNavigations(): HasMany
    {
        return $this->hasMany(UserNavigation::class);
    }
}
