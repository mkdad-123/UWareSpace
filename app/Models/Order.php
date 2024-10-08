<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 *
 *
 * @property int $id
 * @property int $warehouse_id
 * @property string $payment_type
 * @property string|null $payment_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWarehouseId($value)
 * @property-read int|null $order_items_count
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read \App\Models\PurchaseOrder|null $purchaseOrder
 * @property-read \App\Models\SellOrder|null $sellOrder
 * @property string $price
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @mixin \Eloquent
 */
class Order extends Model
{

    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'price',
        'payment_type',
        'payment_at',
        'invoice_number'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->invoice_number = (string) Str::uuid();
        });
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchaseOrder(): HasOne
    {
        return $this->hasOne(PurchaseOrder::class);
    }

    public function sellOrder(): HasOne
    {
        return $this->hasOne(SellOrder::class);
    }
}
