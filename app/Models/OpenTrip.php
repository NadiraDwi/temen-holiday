<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'meeting_point',
        'id_contact',
        'description',
        'price',
        'price_label',
        'include',
        'images',
    ];

    // ✅ Casting boolean biar hasilnya true/false
    protected $casts = [
        'images' => 'array',
    ];

    // RELATIONSHIP
    public function destinations()
    {
        return $this->hasMany(OpenTripDestination::class);
    }

    public function schedules()
    {
        return $this->hasMany(OpenTripSchedule::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'id_contact');
    }

    public function itineraries()
    {
        return $this->hasMany(OpenTripItinerary::class);
    }

}
