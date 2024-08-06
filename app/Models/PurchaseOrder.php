<?php

namespace App\Models;

use App\Enums\PurchaseOrderEnum;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereUpdatedAt($value)
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Supplier $supplier
 * @method static \Database\Factories\Purchase_OrderFactory factory($count = null, $state = [])
 * @method static Builder|PurchaseOrder purchase()
 * @method static Builder|PurchaseOrder purchaseOrder()
 * @property int $isInventoried
 * @method static Builder|PurchaseOrder nonInventoried()
 * @method static Builder|PurchaseOrder purchaseDebt()
 * @method static Builder|PurchaseOrder whereIsInventoried($value)
 * @mixin \Eloquent
 */
class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'supplier_id',
        'status',
        'isInventoried'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopePurchase(Builder $query): Builder
    {
        return $query->where('status' , PurchaseOrderEnum::RECEIVED)

            ->whereHas('order' , function ($query){
                return $query->where('payment_type' , 'cash');
            });

    }

    public function scopePurchaseOrder(Builder $query): Builder
    {
        return $query->whereIn('status' , PurchaseOrderEnum::getStatus());
    }

    public function scopePurchaseDebt(Builder $query): Builder
    {
        return $query->where('status' , PurchaseOrderEnum::RECEIVED)

            ->whereHas('order' , function ($query){
                return $query->where('payment_type' , 'debt');
            });
    }

    public function scopeNonInventoried(Builder $query): Builder
    {
        return $query->where('isInventoried' , 0);
    }


}
