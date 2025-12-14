<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'licenseplate_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function licenseplate()
    {
        return $this->belongsTo(Kenteken::class);
    }

    public function kenteken()
    {
        return $this->licenseplate();
    }
}
