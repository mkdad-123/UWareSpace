<?php

namespace App\filters;

use App\Enums\PurchaseOrderEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class PurchaseOrderFilter
{


    public static function filter($id): array
    {

        return [

            AllowedFilter::callback('order', function (Builder $query, $value) use ($id) {

                $query->where('payment_type', 'like', "%{$value}%")

                    ->where('admin_id', $id)

                    ->orwhereHas('purchase_order' , function (Builder $query) use ($value , $id){

                        $query->where('status', 'like', "%{$value}%")->whereIn('status' , PurchaseOrderEnum::getStatus())

                            ->where('admin_id', $id)

                            ->orWhereHas('supplier',function (Builder $query) use ($value , $id){

                                $query->where('name', 'like', "%{$value}%")->whereIn('status' , PurchaseOrderEnum::getStatus())

                                    ->where('admin_id', $id);
                            });
                    })->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                        $query->where('name', 'like', "%{$value}%");

                    })->whereHas('purchase_order' , function (Builder $query) use ($value){

                        $query->whereIn('status' , PurchaseOrderEnum::getStatus());

                    })->where('admin_id', $id);
            })
        ];
    }



    public static function filterPurchase($id): array
    {

        return [

            AllowedFilter::callback('order', function (Builder $query, $value) use ($id) {

                $query->where('payment_type', 'like', "%{$value}%")

                    ->where('admin_id', $id)

                    ->orwhereHas('purchase_order' , function (Builder $query) use ($value , $id){

                        $query->where('status', 'like', "%{$value}%")->where('status' , PurchaseOrderEnum::RECEIVED)

                            ->where('admin_id', $id)

                            ->orWhereHas('supplier',function (Builder $query) use ($value , $id){

                                $query->where('name', 'like', "%{$value}%")->where('status' , PurchaseOrderEnum::RECEIVED)

                                    ->where('admin_id', $id);
                            });
                    })->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                        $query->where('name', 'like', "%{$value}%");

                    })->whereHas('purchase_order' , function (Builder $query) use ($value){

                    $query->where('status' , PurchaseOrderEnum::RECEIVED);

                        })->where('admin_id', $id);
            })
        ];
    }
}
