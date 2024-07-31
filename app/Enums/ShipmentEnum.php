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
}
