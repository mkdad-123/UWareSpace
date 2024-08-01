<?php

if(! function_exists('calculate_capacity_warehouse'))
{

    function calculate_capacity($size , $items): float
    {
        $totalPercent = 0.0;

        foreach ($items as $item)
        {

            $maxLoadFromItem = (double) ($size / $item->size_cubic_meters);

            $percent = ($item->pivot->real_qty / $maxLoadFromItem) *  100;

            $totalPercent += $percent;
        }

        return round($totalPercent,2);
    }
}
