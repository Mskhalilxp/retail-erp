<?php
namespace App\Enums;

enum Status:int{
    case new = 1;
    case status2 = 2;

    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
