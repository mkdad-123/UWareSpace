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

                $query->where('status', 'like', "%{$value}%")
                    ->purchaseOrder()

                    ->orwhereHas('order' , function (Builder $query) use ($value , $id){

                        $query->where('payment_type', 'like', "%{$value}%")

                            ->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                                $query->where('name', 'like', "%{$value}%");

                            });

                    })->purchaseOrder()

                    ->orWhereHas('supplier',function (Builder $query) use ($value , $id) {

                        $query->where('name', 'like', "%{$value}%");

                    })->purchaseOrder();
            })
        ];
    }



    public static function filterPurchase($id): array
    {

        return [

            AllowedFilter::callback('order', function (Builder $query, $value) use ($id) {

                $query->where('status', 'like', "%{$value}%")
                    ->purchase()

                    ->orwhereHas('order' , function (Builder $query) use ($value , $id){

                        $query->where('payment_type', 'like', "%{$value}%")

                            ->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                                $query->where('name', 'like', "%{$value}%");

                            });

                    })->purchase()

                    ->orWhereHas('supplier',function (Builder $query) use ($value , $id) {

                        $query->where('name', 'like', "%{$value}%");

                    })->purchase();
            })
        ];

    }
}
