<?php
namespace App\Enums;

enum EmployeeRole:int{
    case super_admin = 1;
    case social_media = 2;
    case warehouse = 3;

    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
