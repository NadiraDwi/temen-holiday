<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTripItinerary extends Model
{
    protected $fillable = ['open_trip_id', 'day_title'];

    public function items()
    {
        return $this->hasMany(OpenTripItineraryItem::class, 'itinerary_id');
    }

    public function trip()
    {
        return $this->belongsTo(OpenTrip::class, 'open_trip_id');
    }
}
