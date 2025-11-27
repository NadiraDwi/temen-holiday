<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTripItineraryItem extends Model
{
    protected $fillable = ['itinerary_id', 'time', 'activity'];

    public function itinerary()
    {
        return $this->belongsTo(OpenTripItinerary::class, 'itinerary_id');
    }
}

