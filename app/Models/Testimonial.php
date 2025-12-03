<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id_testimoni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_user',
        'pesan',
        'rating_fasilitas',
        'rating_harga',
        'reply_admin',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_testimoni)) {
                $model->id_testimoni = (string) Str::uuid();
            }
        });
    }
}
