<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    protected $table = 'vehicle_categories';
    protected $primaryKey = 'id_category';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_category', 'kategori', 'kategori'];

    // RELASI KE VEHICLE
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id_kategori', 'id_category');
    }
}
