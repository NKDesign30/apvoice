<?php


namespace RobRichards\XMLSecLibs\Utils;

class XPath
{
    const ALPHANUMERIC = "\134\167\x5c\x64";
    const NUMERIC = "\x5c\144";
    const LETTERS = "\134\x77";
    const EXTENDED_ALPHANUMERIC = "\134\x77\134\x64\x5c\x73\x5c\55\x5f\x3a\x5c\x2e";
    const SINGLE_QUOTE = "\x27";
    const DOUBLE_QUOTE = "\42";
    const ALL_QUOTES = "\x5b\x27\42\x5d";
    public static function filterAttrValue($T5, $oo = self::ALL_QUOTES)
    {
        return preg_replace("\x23" . $oo . "\x23", '', $T5);
    }
    public static function filterAttrName($BT, $Hk = self::EXTENDED_ALPHANUMERIC)
    {
        return preg_replace("\43\x5b\x5e" . $Hk . "\135\x23", '', $BT);
    }
}
