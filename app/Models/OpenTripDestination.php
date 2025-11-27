<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTripDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'open_trip_id',
        'name',
        'category',
    ];

    public function trip()
    {
        return $this->belongsTo(OpenTrip::class, 'open_trip_id');
    }
}
