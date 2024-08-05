<?php

namespace App\Models;

use App\Enums\ShipmentEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * 
 *
 * @property int $id
 * @property int $warehouse_id
 * @property int $employee_id
 * @property int $vehicle_id
 * @property string $tracking_number
 * @property string $current_capacity
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCurrentCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereWarehouseId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellOrder> $SellOrders
 * @property-read int|null $sell_orders_count
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Vehicle $vehicle
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Database\Factories\ShipmentFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'vehicle_id',
        'employee_id',
        'current_capacity',
        'tracking_number',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shipment) {
            $shipment->tracking_number = (string) Str::uuid();
            $shipment->status = ShipmentEnum::PREPARATION;
        });
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function SellOrders(): HasMany
    {
        return $this->hasMany(SellOrder::class);
    }
}
