<?php

namespace App\Enums;

enum SellOrderEnum :string
{
    case PENDING  = 'pending';
    case PREPARATION  = 'preparation';
    case SENDING = 'sending';
    case RECEIVED = 'received';
    case RETURNED = 'returned';


    public static function getStatus(): array
    {
        return [
            self::PENDING->value,
            self::SENDING->value,
            self::PREPARATION->value,
        ];
    }
}
