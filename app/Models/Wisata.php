<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'wisata';

    protected $fillable = [
        'title',
        'description',
        'price',
        'price_label',
        'include',
        'images',
        'id_contact',
        'map_url'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    // relasi yang benar
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'id_contact');
    }
}
