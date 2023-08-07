<?php


abstract class BasicEnum
{
    private static $constCacheArray = NULL;
    public static function getConstants()
    {
        if (!(self::$constCacheArray == NULL)) {
            goto sI;
        }
        self::$constCacheArray = array();
        sI:
        $dX = get_called_class();
        if (array_key_exists($dX, self::$constCacheArray)) {
            goto B7;
        }
        $Vf = new ReflectionClass($dX);
        self::$constCacheArray[$dX] = $Vf->getConstants();
        B7:
        return self::$constCacheArray[$dX];
    }
    public static function isValidName($Ex, $Tt = false)
    {
        $Jp = self::getConstants();
        if (!$Tt) {
            goto ba;
        }
        return array_key_exists($Ex, $Jp);
        ba:
        $b3 = array_map("\163\x74\x72\x74\157\154\157\x77\x65\x72", array_keys($Jp));
        return in_array(strtolower($Ex), $b3);
    }
    public static function isValidValue($Ng, $Tt = true)
    {
        $ga = array_values(self::getConstants());
        return in_array($Ng, $ga, $Tt);
    }
}
