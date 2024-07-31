<?php

namespace App\filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ItemFilter
{
    public static function filter(): array
    {
        return [

            AllowedFilter::callback('item', function (Builder $query, $value) {

                $query->where('SKU' , 'like' , "%{$value}%")
                    ->orWhere('name' , 'like' , "%{$value}%")
                    ->orWhere('sell_price' , 'like' , "%{$value}%")
                    ->orWhere('pur_price' , 'like' , "%{$value}%")
                    ->orWhere('size_cubic_meters' , 'like' , "%{$value}%")
                    ->orWhere('unit' , 'like' , "%{$value}%");
            })
        ];
    }
}
