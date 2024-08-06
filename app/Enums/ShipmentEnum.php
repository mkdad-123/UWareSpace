<?php

namespace App\Enums;

enum ShipmentEnum : string
{

     case PREPARATION  = 'preparation';
     case SENDING = 'sending';
     case RECEIVED = 'received';

     public static function getStatus(): array
     {
         return [
             self::PREPARATION->value,
             self::SENDING->value,
         ];
     }

    public static function getStatusForChange(): array
    {
        return [
            self::RECEIVED->value,
            self::SENDING->value,
        ];
    }

}
