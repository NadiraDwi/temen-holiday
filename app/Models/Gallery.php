<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';
    protected $primaryKey = 'id_galeri';
    public $incrementing = false; // karena UUID
    protected $keyType = 'string';

    protected $fillable = [
        'judul',
        'gambar',
        'created_by'
    ];

    /**
     * Auto generate UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_galeri) {
                $model->id_galeri = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
