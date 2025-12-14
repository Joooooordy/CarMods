<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kenteken extends Model
{
    protected $fillable = [
        'licenseplate',
        'formatted_licenseplate',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
