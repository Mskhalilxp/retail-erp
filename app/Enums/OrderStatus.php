<?php
namespace App\Enums;

enum OrderStatus:int{
    case created = 1;
    case prepared = 2;
    case delivered = 3;
    case returned = 4;
    case client_contacted = 5;
    case finished = 6;

    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
