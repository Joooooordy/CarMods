<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kenteken extends Model
{
    protected $fillable = ['licenseplate', 'formatted_licenseplate', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
