<?php
namespace App\Enums;

class RoleEnum
{
    const ADMIN = 1;
    const CUSTOMER = 2;

    public static function getConstants(): array
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }


    public static function getRoleName(int $roleValue): ?string
    {
        switch ($roleValue) {
            case self::ADMIN:
                return 'Admin';
            case self::CUSTOMER:
                return 'Customer';
            default:
                return null;
        }
    }

    /**
     * Get an array where role names are keys and role values are values.
     *
     * @return array
     */
    public static function getRoleArray(): array
    {
        $constants = self::getConstants();
        $roleArray = [];

        foreach ($constants as $roleValue) {
            $roleArray[self::getRoleName($roleValue)] = $roleValue;
        }

        return $roleArray;
    }


}
