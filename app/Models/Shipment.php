<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shipment) {
            $shipment->tracking_number = (string) Str::uuid();
        });
    }
}
