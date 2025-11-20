<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id_vehicle';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kendaraan',
        'kapasitas',
        'fasilitas',
        'harga',
        'gambar',
        'id_contact',
        'updated_by',
        'id_kategori'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_vehicle)) {
                $model->id_vehicle = (string) Str::uuid();
            }
        });
    }

    // RELASI KE KATEGORI
    public function kategori()
    {
        return $this->belongsTo(VehicleCategory::class, 'id_kategori', 'id_category');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'id_contact');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'updated_by', 'id');
    }
}
