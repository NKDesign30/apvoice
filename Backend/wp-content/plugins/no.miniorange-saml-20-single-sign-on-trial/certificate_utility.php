<?php


class CertificateUtility
{
    public static function generate_certificate($ah, $QH, $ix)
    {
        $sB = openssl_pkey_new();
        $Gr = openssl_csr_new($ah, $sB, $QH);
        $Kb = openssl_csr_sign($Gr, null, $sB, $ix, $QH, time());
        openssl_csr_export($Gr, $BV);
        openssl_x509_export($Kb, $bA);
        openssl_pkey_export($sB, $CK);
        lX:
        if (!(($Tn = openssl_error_string()) !== false)) {
            goto IK;
        }
        error_log("\x43\145\162\164\x69\x66\x69\x63\141\164\x65\125\164\151\154\x69\x74\x79\x3a\x20\105\x72\162\x6f\x72\x20\x67\145\x6e\x65\x72\x61\x74\151\156\147\40\x63\x65\x72\x74\151\146\151\x63\x61\164\x65\x2e\40" . $Tn);
        goto lX;
        IK:
        $V_ = array("\x70\165\x62\154\151\x63\x5f\153\145\171" => $bA, "\x70\162\151\x76\141\x74\x65\137\153\x65\x79" => $CK);
        return $V_;
    }
}
