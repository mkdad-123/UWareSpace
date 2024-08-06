<?php

namespace App\filters;

use App\Enums\SellOrderEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class SellOrderFilter
{

    public static function filter($id): array
    {

        return [

            AllowedFilter::callback('order', function (Builder $query, $value) use ($id) {

                $query->where('status', 'like', "%{$value}%")
                    ->sellOrder()

                    ->orwhereHas('order' , function (Builder $query) use ($value , $id){

                        $query->where('payment_type', 'like', "%{$value}%")

                            ->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                                $query->where('name', 'like', "%{$value}%");

                            });

                    })->sellOrder()

                    ->orWhereHas('client',function (Builder $query) use ($value , $id) {

                        $query->where('name', 'like', "%{$value}%");

                    })->sellOrder()

                    ->orWhereHas('shipment', function (Builder $query) use ($value, $id) {

                        $query->where('tracking_number', 'like', "%{$value}%");

                    })->sellOrder();
            })
        ];
    }


    public static function filterSells($id): array
    {

        return [

            AllowedFilter::callback('sell', function (Builder $query, $value) use ($id) {

                $query->where('status', 'like', "%{$value}%")
                    ->sell()

                    ->orwhereHas('order' , function (Builder $query) use ($value , $id){

                        $query->where('payment_type', 'like', "%{$value}%")

                            ->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                                $query->where('name', 'like', "%{$value}%");

                            });

                    })->sell()

                    ->orWhereHas('client',function (Builder $query) use ($value , $id) {

                        $query->where('name', 'like', "%{$value}%");

                        })->sell()

                        ->orWhereHas('shipment', function (Builder $query) use ($value, $id) {

                                $query->where('tracking_number', 'like', "%{$value}%");

                        })->sell();
            })
        ];
    }
}
