<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientInstaller extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function installer()
    {
        return $this->belongsTo(Installer::class);
    }
}
