<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property int $admin_id
 * @property string $SKU
 * @property string $name
 * @property string $sell_price
 * @property string $pur_price
 * @property string|null $size_cubic_meters
 * @property string|null $weight
 * @property string|null $str_price
 * @property int $total_qty
 * @property string|null $photo
 * @property string $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Warehouse> $warehouses
 * @property-read int|null $warehouses_count
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePurPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSizeCubicMeters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereStrPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereTotalQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereWeight($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
      'admin_id' ,
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
        return $this->belongsToMany(Warehouse::class , 'warehouse_item')
            ->withPivot(['real_qty','min_qty','available_qty']);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
