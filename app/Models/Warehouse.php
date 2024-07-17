<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size_cubic_meters',
        'latitude',
        'longitude',
        'admin_id',
        'current_capacity',
        'location'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot(['real_qty','min_qty','available_qty']);
    }
}
