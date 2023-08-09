<?php


namespace RobRichards\XMLSecLibs\Utils;

class XPath
{
    const ALPHANUMERIC = "\134\x77\x5c\144";
    const NUMERIC = "\x5c\144";
    const LETTERS = "\134\167";
    const EXTENDED_ALPHANUMERIC = "\x5c\167\134\x64\134\x73\x5c\55\137\x3a\134\56";
    const SINGLE_QUOTE = "\47";
    const DOUBLE_QUOTE = "\42";
    const ALL_QUOTES = "\x5b\x27\42\135";
    public static function filterAttrValue($Ng, $vQ = self::ALL_QUOTES)
    {
        return preg_replace("\43" . $vQ . "\43", '', $Ng);
    }
    public static function filterAttrName($Ex, $iP = self::EXTENDED_ALPHANUMERIC)
    {
        return preg_replace("\x23\133\x5e" . $iP . "\135\x23", '', $Ex);
    }
}
