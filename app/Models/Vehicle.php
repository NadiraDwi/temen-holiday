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
        'contact_id',
        'updated_by'
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

    // RELASI
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id_contact');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
