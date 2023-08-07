<?php


class CertificateUtility
{
    public static function generate_certificate($K7, $N9, $K0)
    {
        $Oo = openssl_pkey_new();
        $Ov = openssl_csr_new($K7, $Oo, $N9);
        $WY = openssl_csr_sign($Ov, null, $Oo, $K0, $N9, time());
        openssl_csr_export($Ov, $FK);
        openssl_x509_export($WY, $wI);
        openssl_pkey_export($Oo, $mk);
        JP:
        if (!(($aW = openssl_error_string()) !== false)) {
            goto ew;
        }
        error_log("\x43\145\162\x74\x69\146\151\143\141\x74\145\125\x74\x69\154\x69\x74\171\72\40\x45\x72\x72\157\x72\40\x67\145\x6e\145\x72\x61\x74\151\156\x67\x20\x63\x65\162\x74\151\146\x69\x63\141\x74\x65\x2e\40" . $aW);
        goto JP;
        ew:
        $UH = array("\x70\x75\x62\154\x69\x63\137\153\145\171" => $wI, "\x70\162\x69\166\x61\164\145\137\x6b\145\x79" => $mk);
        return $UH;
    }
}
