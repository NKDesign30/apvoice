<?php


abstract class BasicEnum
{
    private static $constCacheArray = NULL;
    public static function getConstants()
    {
        if (!(self::$constCacheArray == NULL)) {
            goto EZ;
        }
        self::$constCacheArray = array();
        EZ:
        $Zb = get_called_class();
        if (array_key_exists($Zb, self::$constCacheArray)) {
            goto Am;
        }
        $vl = new ReflectionClass($Zb);
        self::$constCacheArray[$Zb] = $vl->getConstants();
        Am:
        return self::$constCacheArray[$Zb];
    }
    public static function isValidName($BT, $qq = false)
    {
        $Bj = self::getConstants();
        if (!$qq) {
            goto G2;
        }
        return array_key_exists($BT, $Bj);
        G2:
        $KE = array_map("\x73\x74\x72\164\157\x6c\157\x77\x65\162", array_keys($Bj));
        return in_array(strtolower($BT), $KE);
    }
    public static function isValidValue($T5, $qq = true)
    {
        $Sr = array_values(self::getConstants());
        return in_array($T5, $Sr, $qq);
    }
}
