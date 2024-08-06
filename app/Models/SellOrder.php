<?php

namespace App\Models;

use App\Enums\SellOrderEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $order_id
 * @property int $client_id
 * @property int $shipment_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereShipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellOrder whereUpdatedAt($value)
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Shipment $shipment
 * @method static \Database\Factories\SellOrderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class SellOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'client_id',
        'shipment_id',
        'status'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function scopeSell(Builder $query): Builder
    {
        return $query->where('status' , SellOrderEnum::RECEIVED)

            ->whereHas('order' , function ($query){
                return $query->where('payment_type' , 'cash');
            });
    }

    public function scopeSellOrder(Builder $query): Builder
    {
        return $query->whereIn('status' , SellOrderEnum::getStatus());

    }

    public function scopeSellDebt(Builder $query): Builder
    {
        return $query->where('status' , SellOrderEnum::RECEIVED)

            ->whereHas('order' , function ($query){
                return $query->where('payment_type' , 'debt');
            });
    }
}
