<?php


class AESEncryption
{
    public static function encrypt_data($xr, $FE)
    {
        $FE = openssl_digest($FE, "\163\x68\x61\62\x35\66");
        $Sa = "\141\145\163\55\x31\x32\70\55\145\143\142";
        $fP = openssl_encrypt($xr, $Sa, $FE, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING);
        return base64_encode($fP);
    }
    public static function decrypt_data($xr, $FE)
    {
        $lm = base64_decode($xr);
        $FE = openssl_digest($FE, "\163\x68\x61\62\x35\x36");
        $Sa = "\101\105\123\x2d\61\x32\x38\x2d\x45\103\x42";
        $BY = openssl_cipher_iv_length($Sa);
        $ly = substr($lm, 0, $BY);
        $xr = substr($lm, $BY);
        $D4 = openssl_decrypt($xr, $Sa, $FE, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $ly);
        return $D4;
    }
}
