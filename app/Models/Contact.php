<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'id_contact';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_contact',
        'nama',
        'no_hp',
    ];

    // Generate UUID automatically when creating
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id_contact)) {
                $model->id_contact = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Vehicle
     * Satu kontak bisa digunakan oleh banyak vehicle
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id_contact', 'id_contact');
    }
}
