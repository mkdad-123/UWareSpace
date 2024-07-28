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
 * @property string $name
 * @property string $size_cubic_meters
 * @property string $current_capacity
 * @property string|null $location
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @method static \Database\Factories\WarehouseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCurrentCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereSizeCubicMeters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @mixin \Eloquent
 */
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
        return $this->belongsToMany(Item::class , 'warehouse_item')
            ->withPivot(['real_qty','min_qty','available_qty']);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
