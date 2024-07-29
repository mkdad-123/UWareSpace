<?php

namespace App\Enums;

enum VehicleEnum : string
{
    case UN_ACTIVE = 'un_active';
    case ACTIVE = 'active';
    case ON_ROAD = 'on the road';

    public static function getStatuses(): array
    {
        return [
          self::UN_ACTIVE->value,
          self::ACTIVE->value,
          self::ON_ROAD->value
        ];
    }
}
