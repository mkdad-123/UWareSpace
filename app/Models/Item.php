<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
      'SKU',
      'name',
      'sell_price',
      'pur_price',
      'size_cubic_meters',
      'weight',
      'str_price',
      'total_qty',
      'photo',
      'unit'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class)->withPivot(['real_qty','min_qty','available_qty']);
    }
}
