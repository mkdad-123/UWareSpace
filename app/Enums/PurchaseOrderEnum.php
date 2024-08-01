<?php

namespace App\Enums;

enum PurchaseOrderEnum : string
{
    case PENDING  = 'pending';
    case SENDING = 'sending';
    case RECEIVED = 'received';

    public static function getStatus(): array
    {
        return [
            self::PENDING->value,
            self::SENDING->value,
            self::RECEIVED->value
        ];
    }
}
