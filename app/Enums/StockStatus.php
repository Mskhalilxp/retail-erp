<?php
namespace App\Enums;

enum StockStatus:int{
    case not_delivered = 1;
    case delivered = 2;

    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
