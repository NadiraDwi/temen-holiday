<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VehicleCategory extends Model
{
    protected $table = 'vehicle_categories';
    protected $primaryKey = 'id_category';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kategori'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id_category) {
                $model->id_category = Str::uuid()->toString();
            }
        });
    }
}
