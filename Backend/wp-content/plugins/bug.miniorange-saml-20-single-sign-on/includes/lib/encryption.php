<?php


class AESEncryption
{
    public static function encrypt_data($wN, $ez)
    {
        $ez = openssl_digest($ez, "\163\150\141\x32\x35\66");
        $Ft = "\x61\145\163\55\x31\62\x38\x2d\x65\x63\142";
        $Ln = openssl_encrypt($wN, $Ft, $ez, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING);
        return base64_encode($Ln);
    }
    public static function decrypt_data($wN, $ez)
    {
        $ao = base64_decode($wN);
        $ez = openssl_digest($ez, "\x73\x68\x61\x32\x35\66");
        $Ft = "\x41\x45\x53\55\61\x32\x38\55\105\103\x42";
        $px = openssl_cipher_iv_length($Ft);
        $pW = substr($ao, 0, $px);
        $wN = substr($ao, $px);
        $Z9 = openssl_decrypt($wN, $Ft, $ez, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $pW);
        return $Z9;
    }
}
