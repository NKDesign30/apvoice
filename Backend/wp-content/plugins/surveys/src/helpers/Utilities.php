<?php

namespace svy\helpers;

class Utilities
{

    public static function isPostRequest()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function sanitizePost()
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public static function hasDoubleEntrys($names)
    {
        if (sizeof(array_map('mb_StrToLower', $names)) !=
            sizeof(array_unique(array_map('mb_StrToLower', $names)))) {
            return true;
        }
        return false;
    }
	
}