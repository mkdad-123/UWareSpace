<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $order_id
 * @property int $supplier_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase_Order whereUpdatedAt($value)
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Supplier $supplier
 * @method static \Database\Factories\Purchase_OrderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Purchase_Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'supplier_id',
        'status'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

}
