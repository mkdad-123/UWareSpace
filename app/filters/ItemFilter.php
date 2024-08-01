<?php

namespace App\filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ItemFilter
{
    public static function filter($id): array
    {

        return [

            AllowedFilter::callback('item', function (Builder $query, $value) use ($id){

                $query->where('SKU' , 'like' , "%{$value}%")

                    ->Orwhere('name' , 'like' , "%{$value}%")

                    ->where('admin_id' , $id)->orWhere('sell_price' , 'like' , "%{$value}%")

                    ->where('admin_id' , $id)->orWhere('pur_price' , 'like' , "%{$value}%")

                    ->where('admin_id' , $id)->orWhere('size_cubic_meters' , 'like' , "%{$value}%")

                    ->where('admin_id' , $id) ->orWhere('unit' , 'like' , "%{$value}%")

                    ->where('admin_id' , $id);
            })
        ];
    }
}
