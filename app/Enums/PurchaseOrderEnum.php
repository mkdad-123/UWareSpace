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
