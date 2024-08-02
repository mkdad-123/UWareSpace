<?php

if(! function_exists('calculate_capacity_warehouse'))
{

    function calculate_capacity($size , $itemSize , $itemQty): float
    {
            $maxLoadFromItem = (double) ($size / $itemSize);

            $percent = ($itemQty / $maxLoadFromItem) *  100;

        return round($percent,2);
    }
}
