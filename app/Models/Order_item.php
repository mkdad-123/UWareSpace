<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item query()
 * @property int $id
 * @property int $order_id
 * @property int $item_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $Order
 * @property-read \App\Models\Item $item
 * @method static \Database\Factories\Order_itemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order_item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
