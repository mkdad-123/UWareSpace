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

                $query->where('payment_type', 'like', "%{$value}%")

                    ->where('admin_id', $id)

                    ->orwhereHas('SellOrder' , function (Builder $query) use ($value , $id){

                        $query->where('status', 'like', "%{$value}%")->whereIn('status' , SellOrderEnum::getStatus())

                            ->where('admin_id', $id)

                            ->orWhereHas('client',function (Builder $query) use ($value , $id) {

                                $query->where('name', 'like', "%{$value}%")->whereIn('status', SellOrderEnum::getStatus())
                                    ->where('admin_id', $id);

                            })

                            ->orWhereHas('shipment', function (Builder $query) use ($value, $id) {

                                $query->where('tracking_number', 'like', "%{$value}%")->whereIn('status', SellOrderEnum::getStatus())
                                    ->where('admin_id', $id);
                            });

                    })->orWhereHas('warehouse' ,function (Builder $query) use ($value){

                        $query->where('name', 'like', "%{$value}%");

                    })->whereHas('SellOrder' , function (Builder $query) use ($value){

                        $query->whereIn('status' , SellOrderEnum::getStatus());

                    })->where('admin_id', $id);
            })
        ];
    }
}
