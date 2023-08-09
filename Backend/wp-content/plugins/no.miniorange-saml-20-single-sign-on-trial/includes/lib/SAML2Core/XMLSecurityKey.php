<?php


namespace RobRichards\XMLSecLibs;

use DOMElement;
use Exception;
class XMLSecurityKey
{
    const TRIPLEDES_CBC = "\x68\x74\x74\160\72\x2f\x2f\x77\167\x77\56\167\x33\56\157\x72\x67\x2f\x32\x30\x30\x31\x2f\60\64\x2f\x78\155\154\x65\x6e\x63\x23\x74\x72\151\160\x6c\145\144\145\x73\55\x63\142\143";
    const AES128_CBC = "\x68\x74\x74\x70\72\57\57\167\167\167\x2e\x77\x33\56\x6f\162\x67\57\62\x30\x30\61\57\x30\x34\57\170\x6d\x6c\x65\156\143\43\141\145\x73\x31\x32\70\55\x63\x62\143";
    const AES192_CBC = "\x68\164\164\160\72\57\x2f\167\167\x77\56\x77\x33\56\157\162\x67\x2f\62\x30\60\61\57\x30\x34\57\170\155\x6c\x65\156\x63\43\141\145\x73\61\71\62\55\x63\142\x63";
    const AES256_CBC = "\150\x74\164\160\x3a\x2f\x2f\x77\x77\x77\56\x77\x33\x2e\x6f\162\x67\x2f\x32\60\x30\x31\x2f\x30\x34\x2f\170\155\x6c\145\156\x63\43\x61\145\x73\x32\x35\66\x2d\x63\x62\143";
    const RSA_1_5 = "\x68\164\x74\x70\72\57\57\167\167\x77\x2e\167\x33\x2e\x6f\x72\x67\x2f\x32\60\60\x31\x2f\x30\x34\57\170\155\x6c\x65\x6e\143\x23\x72\163\x61\55\61\137\x35";
    const RSA_OAEP_MGF1P = "\x68\164\x74\160\72\57\57\167\167\x77\x2e\167\63\56\x6f\162\x67\57\62\x30\60\x31\x2f\x30\64\x2f\x78\155\x6c\145\156\x63\43\x72\163\141\x2d\x6f\141\x65\160\55\x6d\147\x66\61\x70";
    const DSA_SHA1 = "\150\x74\x74\x70\72\57\57\167\x77\167\56\x77\x33\56\x6f\162\147\57\x32\x30\x30\60\57\x30\71\x2f\170\x6d\154\144\163\x69\x67\43\144\x73\x61\55\163\150\x61\61";
    const RSA_SHA1 = "\150\164\164\160\72\x2f\57\x77\167\x77\56\167\63\x2e\157\x72\x67\x2f\x32\x30\x30\x30\57\60\x39\57\170\155\154\x64\163\151\147\x23\x72\x73\141\x2d\x73\x68\141\61";
    const RSA_SHA256 = "\150\x74\164\x70\72\57\57\167\x77\167\x2e\167\x33\56\x6f\x72\x67\57\62\x30\x30\x31\57\60\64\x2f\170\155\154\x64\x73\x69\147\55\x6d\157\x72\x65\43\x72\x73\141\x2d\163\150\x61\x32\x35\66";
    const RSA_SHA384 = "\150\164\164\160\x3a\x2f\57\167\x77\x77\56\x77\63\x2e\157\162\x67\x2f\x32\60\x30\x31\x2f\x30\x34\57\x78\x6d\x6c\x64\x73\151\x67\55\155\x6f\x72\x65\43\x72\163\x61\x2d\163\x68\141\63\x38\x34";
    const RSA_SHA512 = "\x68\x74\x74\160\72\x2f\57\x77\167\167\x2e\167\x33\x2e\157\x72\147\57\62\x30\60\61\57\60\64\x2f\170\x6d\154\144\x73\151\x67\x2d\x6d\x6f\x72\x65\43\x72\x73\141\x2d\163\150\141\65\61\x32";
    const HMAC_SHA1 = "\150\x74\x74\160\72\x2f\57\x77\x77\167\x2e\x77\x33\56\x6f\162\147\x2f\x32\x30\60\x30\57\x30\x39\57\170\155\154\x64\163\151\x67\43\150\x6d\141\143\55\163\x68\x61\x31";
    private $cryptParams = array();
    public $type = 0;
    public $key = null;
    public $passphrase = '';
    public $iv = null;
    public $name = null;
    public $keyChain = null;
    public $isEncrypted = false;
    public $encryptedCtx = null;
    public $guid = null;
    private $x509Certificate = null;
    private $X509Thumbprint = null;
    public function __construct($WK, $Vl = null)
    {
        switch ($WK) {
            case self::TRIPLEDES_CBC:
                $this->cryptParams["\x6c\x69\142\162\x61\162\x79"] = "\157\x70\145\x6e\163\x73\154";
                $this->cryptParams["\x63\x69\160\x68\x65\162"] = "\144\x65\163\55\x65\144\145\x33\55\143\x62\x63";
                $this->cryptParams["\164\x79\160\145"] = "\163\x79\155\x6d\x65\x74\x72\x69\143";
                $this->cryptParams["\155\x65\x74\150\157\144"] = "\150\x74\164\160\72\57\x2f\167\167\167\x2e\x77\63\56\x6f\x72\x67\x2f\62\60\x30\61\57\x30\64\57\x78\155\x6c\145\x6e\x63\43\x74\162\151\x70\154\x65\x64\145\163\x2d\143\x62\x63";
                $this->cryptParams["\x6b\145\171\163\151\x7a\145"] = 24;
                $this->cryptParams["\x62\x6c\157\x63\x6b\163\x69\172\x65"] = 8;
                goto K8;
            case self::AES128_CBC:
                $this->cryptParams["\154\151\x62\162\141\162\171"] = "\x6f\160\145\x6e\x73\x73\154";
                $this->cryptParams["\143\x69\160\x68\145\x72"] = "\x61\145\163\55\x31\x32\70\x2d\143\142\143";
                $this->cryptParams["\164\x79\160\145"] = "\x73\x79\155\155\145\164\162\151\x63";
                $this->cryptParams["\x6d\145\x74\150\157\x64"] = "\x68\164\164\160\72\57\x2f\167\x77\167\56\167\x33\x2e\x6f\x72\147\x2f\x32\60\x30\61\x2f\x30\64\57\170\155\154\x65\x6e\143\43\x61\145\x73\x31\x32\70\55\x63\142\143";
                $this->cryptParams["\x6b\145\x79\x73\x69\172\x65"] = 16;
                $this->cryptParams["\x62\x6c\157\143\x6b\x73\151\x7a\x65"] = 16;
                goto K8;
            case self::AES192_CBC:
                $this->cryptParams["\154\151\x62\162\x61\x72\171"] = "\x6f\160\145\x6e\163\163\x6c";
                $this->cryptParams["\143\151\160\150\x65\162"] = "\141\x65\x73\55\61\71\62\x2d\143\142\x63";
                $this->cryptParams["\x74\x79\x70\145"] = "\163\x79\155\x6d\x65\164\162\x69\x63";
                $this->cryptParams["\155\145\x74\150\x6f\144"] = "\150\164\x74\x70\72\57\x2f\x77\x77\167\x2e\x77\63\x2e\x6f\162\147\x2f\x32\x30\60\x31\57\60\64\x2f\x78\155\154\x65\156\143\x23\x61\x65\x73\x31\x39\62\55\x63\142\x63";
                $this->cryptParams["\x6b\x65\x79\163\x69\x7a\145"] = 24;
                $this->cryptParams["\142\x6c\x6f\143\x6b\x73\x69\x7a\145"] = 16;
                goto K8;
            case self::AES256_CBC:
                $this->cryptParams["\154\151\x62\x72\141\162\171"] = "\x6f\x70\145\156\163\163\154";
                $this->cryptParams["\x63\151\160\150\145\162"] = "\141\x65\x73\55\62\65\66\x2d\x63\142\143";
                $this->cryptParams["\x74\171\x70\145"] = "\163\x79\155\155\145\x74\x72\151\x63";
                $this->cryptParams["\155\x65\x74\x68\x6f\x64"] = "\x68\x74\164\160\x3a\57\57\167\x77\x77\56\167\x33\x2e\x6f\x72\x67\57\62\60\x30\x31\x2f\60\64\x2f\x78\155\x6c\x65\x6e\x63\x23\141\145\163\x32\65\66\55\x63\x62\x63";
                $this->cryptParams["\x6b\145\171\163\151\x7a\145"] = 32;
                $this->cryptParams["\142\x6c\x6f\x63\x6b\163\151\x7a\x65"] = 16;
                goto K8;
            case self::RSA_1_5:
                $this->cryptParams["\154\x69\x62\162\x61\162\171"] = "\157\x70\145\156\163\x73\154";
                $this->cryptParams["\160\x61\x64\x64\151\156\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x6d\x65\x74\150\x6f\144"] = "\150\164\x74\x70\x3a\57\x2f\167\167\x77\56\167\63\x2e\157\x72\147\x2f\62\60\60\61\57\x30\x34\x2f\x78\155\154\145\156\x63\x23\x72\163\141\55\x31\137\x35";
                if (!(is_array($Vl) && !empty($Vl["\x74\171\x70\145"]))) {
                    goto T7;
                }
                if (!($Vl["\164\x79\x70\145"] == "\x70\x75\x62\154\151\x63" || $Vl["\x74\171\160\x65"] == "\160\x72\151\166\141\164\145")) {
                    goto KZ;
                }
                $this->cryptParams["\x74\x79\x70\145"] = $Vl["\164\x79\160\145"];
                goto K8;
                KZ:
                T7:
                throw new Exception("\103\145\162\x74\151\146\151\x63\x61\x74\145\x20\x22\x74\x79\160\x65\x22\40\50\160\162\x69\166\x61\164\x65\57\160\x75\142\x6c\x69\143\x29\40\155\x75\163\164\x20\142\145\x20\x70\x61\x73\x73\x65\144\40\x76\x69\141\x20\x70\x61\162\x61\x6d\145\164\x65\x72\163");
            case self::RSA_OAEP_MGF1P:
                $this->cryptParams["\154\x69\x62\162\141\x72\x79"] = "\157\160\145\x6e\163\x73\x6c";
                $this->cryptParams["\x70\x61\144\x64\151\x6e\x67"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\x6d\145\x74\x68\157\x64"] = "\150\164\164\x70\x3a\x2f\57\167\x77\167\56\167\x33\56\x6f\x72\147\x2f\62\x30\60\61\57\x30\x34\57\170\155\x6c\145\156\x63\43\x72\x73\141\55\157\141\x65\x70\55\x6d\147\x66\x31\160";
                $this->cryptParams["\x68\x61\163\150"] = null;
                if (!(is_array($Vl) && !empty($Vl["\164\171\160\145"]))) {
                    goto gt;
                }
                if (!($Vl["\x74\171\x70\145"] == "\160\165\x62\x6c\151\x63" || $Vl["\x74\171\x70\x65"] == "\x70\162\x69\x76\x61\164\x65")) {
                    goto jC;
                }
                $this->cryptParams["\x74\171\x70\145"] = $Vl["\x74\x79\160\145"];
                goto K8;
                jC:
                gt:
                throw new Exception("\103\145\x72\x74\x69\146\151\143\141\164\x65\x20\x22\x74\171\x70\x65\42\x20\50\160\162\x69\x76\x61\164\x65\57\x70\165\x62\x6c\151\x63\51\x20\x6d\165\163\164\x20\x62\x65\x20\160\x61\163\x73\x65\x64\x20\x76\151\x61\40\160\141\162\x61\x6d\145\164\145\x72\163");
            case self::RSA_SHA1:
                $this->cryptParams["\154\151\x62\x72\x61\162\x79"] = "\157\160\145\156\163\163\154";
                $this->cryptParams["\155\x65\164\150\x6f\x64"] = "\150\164\164\160\x3a\x2f\57\167\167\167\x2e\167\x33\x2e\157\x72\147\x2f\62\x30\x30\x30\57\x30\x39\x2f\x78\x6d\x6c\144\x73\x69\x67\x23\x72\x73\x61\55\x73\x68\141\x31";
                $this->cryptParams["\x70\141\x64\x64\151\x6e\x67"] = OPENSSL_PKCS1_PADDING;
                if (!(is_array($Vl) && !empty($Vl["\164\x79\x70\145"]))) {
                    goto OH;
                }
                if (!($Vl["\x74\x79\x70\145"] == "\x70\165\142\x6c\151\143" || $Vl["\x74\x79\160\145"] == "\x70\162\151\x76\141\164\145")) {
                    goto gG;
                }
                $this->cryptParams["\164\171\x70\x65"] = $Vl["\x74\171\160\x65"];
                goto K8;
                gG:
                OH:
                throw new Exception("\103\x65\162\164\x69\x66\151\x63\x61\x74\x65\x20\42\x74\171\160\x65\x22\40\50\160\162\151\166\141\164\x65\57\x70\165\142\x6c\x69\143\51\x20\155\x75\163\164\x20\142\145\x20\x70\x61\x73\163\145\144\x20\x76\151\x61\x20\x70\x61\162\141\155\145\164\x65\162\x73");
            case self::RSA_SHA256:
                $this->cryptParams["\x6c\x69\142\162\x61\162\x79"] = "\157\x70\x65\156\x73\163\154";
                $this->cryptParams["\x6d\x65\164\150\x6f\144"] = "\x68\164\x74\160\72\57\57\167\167\167\56\x77\x33\56\x6f\162\147\57\x32\60\x30\x31\x2f\60\x34\x2f\170\155\x6c\x64\163\x69\147\55\x6d\x6f\x72\145\x23\x72\x73\x61\55\x73\x68\141\62\x35\x36";
                $this->cryptParams["\x70\x61\144\x64\151\156\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\x69\x67\x65\163\164"] = "\123\110\x41\x32\65\x36";
                if (!(is_array($Vl) && !empty($Vl["\x74\171\160\x65"]))) {
                    goto Rm;
                }
                if (!($Vl["\x74\171\160\145"] == "\x70\165\142\x6c\x69\143" || $Vl["\x74\171\x70\145"] == "\160\x72\151\x76\x61\x74\145")) {
                    goto WY;
                }
                $this->cryptParams["\x74\171\x70\x65"] = $Vl["\x74\x79\160\x65"];
                goto K8;
                WY:
                Rm:
                throw new Exception("\x43\145\162\164\151\146\151\143\x61\164\145\x20\x22\164\x79\x70\145\x22\x20\x28\x70\x72\x69\166\x61\x74\x65\x2f\x70\x75\x62\x6c\x69\143\x29\x20\x6d\165\163\x74\40\x62\145\40\x70\x61\163\163\145\144\x20\166\x69\x61\40\x70\141\x72\141\155\145\x74\145\162\x73");
            case self::RSA_SHA384:
                $this->cryptParams["\x6c\151\x62\162\x61\x72\x79"] = "\157\160\145\156\163\x73\154";
                $this->cryptParams["\155\145\x74\150\x6f\144"] = "\x68\164\164\160\72\57\x2f\167\x77\167\x2e\x77\63\x2e\157\162\x67\57\62\60\x30\x31\x2f\60\x34\57\170\x6d\154\144\x73\x69\147\55\155\157\162\x65\43\x72\163\x61\x2d\163\x68\x61\x33\x38\x34";
                $this->cryptParams["\160\141\144\x64\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\x69\147\x65\163\x74"] = "\123\110\101\63\70\64";
                if (!(is_array($Vl) && !empty($Vl["\x74\x79\160\x65"]))) {
                    goto WQ;
                }
                if (!($Vl["\164\x79\x70\x65"] == "\160\x75\x62\154\151\x63" || $Vl["\x74\x79\x70\x65"] == "\160\x72\x69\166\141\164\145")) {
                    goto nb;
                }
                $this->cryptParams["\164\x79\x70\x65"] = $Vl["\164\x79\160\x65"];
                goto K8;
                nb:
                WQ:
                throw new Exception("\x43\x65\162\x74\x69\x66\x69\143\141\164\145\40\42\x74\171\x70\x65\42\x20\50\x70\x72\151\166\141\x74\x65\57\160\x75\x62\154\x69\143\51\40\x6d\x75\163\164\40\x62\145\40\160\x61\163\163\145\144\40\x76\151\x61\40\x70\x61\162\x61\155\145\164\x65\x72\163");
            case self::RSA_SHA512:
                $this->cryptParams["\154\x69\142\162\x61\162\x79"] = "\x6f\160\x65\x6e\163\x73\x6c";
                $this->cryptParams["\155\x65\164\x68\157\x64"] = "\150\x74\164\x70\72\57\x2f\167\167\x77\56\x77\x33\56\x6f\162\x67\x2f\x32\60\60\61\57\60\x34\57\x78\155\154\x64\163\151\x67\55\x6d\x6f\x72\145\43\x72\x73\141\x2d\x73\150\x61\65\61\62";
                $this->cryptParams["\160\141\144\x64\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\151\147\145\163\x74"] = "\123\x48\x41\65\x31\62";
                if (!(is_array($Vl) && !empty($Vl["\164\x79\160\145"]))) {
                    goto Si;
                }
                if (!($Vl["\x74\171\x70\x65"] == "\x70\x75\x62\x6c\x69\x63" || $Vl["\164\171\x70\x65"] == "\x70\x72\x69\x76\141\x74\145")) {
                    goto Ha;
                }
                $this->cryptParams["\x74\171\x70\145"] = $Vl["\164\171\160\x65"];
                goto K8;
                Ha:
                Si:
                throw new Exception("\103\145\x72\x74\x69\146\x69\143\141\164\x65\40\42\164\x79\x70\145\42\x20\x28\160\x72\151\166\141\164\x65\x2f\160\165\x62\x6c\151\x63\x29\40\155\x75\163\164\x20\x62\145\40\160\x61\x73\x73\145\x64\x20\166\151\x61\40\160\x61\x72\x61\155\x65\164\x65\x72\x73");
            case self::HMAC_SHA1:
                $this->cryptParams["\x6c\151\142\162\141\x72\x79"] = $WK;
                $this->cryptParams["\x6d\x65\164\x68\157\x64"] = "\x68\x74\x74\x70\72\x2f\57\167\167\167\x2e\167\63\56\x6f\162\147\x2f\62\60\x30\60\x2f\x30\x39\x2f\170\155\154\144\x73\151\147\x23\x68\x6d\141\143\55\163\x68\x61\61";
                goto K8;
            default:
                throw new Exception("\x49\x6e\x76\x61\x6c\151\x64\x20\x4b\145\171\40\124\x79\160\145");
        }
        Mn:
        K8:
        $this->type = $WK;
    }
    public function getSymmetricKeySize()
    {
        if (isset($this->cryptParams["\153\145\171\163\x69\x7a\x65"])) {
            goto Uu;
        }
        return null;
        Uu:
        return $this->cryptParams["\x6b\x65\171\163\151\172\x65"];
    }
    public function generateSessionKey()
    {
        if (isset($this->cryptParams["\153\x65\171\x73\151\x7a\145"])) {
            goto uC;
        }
        throw new Exception("\125\156\153\x6e\157\x77\x6e\40\153\145\x79\40\x73\x69\172\x65\40\x66\x6f\162\40\x74\x79\x70\x65\40\42" . $this->type . "\x22\56");
        uC:
        $tS = $this->cryptParams["\x6b\145\171\163\x69\x7a\145"];
        $FE = openssl_random_pseudo_bytes($tS);
        if (!($this->type === self::TRIPLEDES_CBC)) {
            goto W1;
        }
        $Sg = 0;
        Yg:
        if (!($Sg < strlen($FE))) {
            goto bD;
        }
        $Zb = ord($FE[$Sg]) & 0xfe;
        $Yw = 1;
        $LF = 1;
        Lk:
        if (!($LF < 8)) {
            goto HT;
        }
        $Yw ^= $Zb >> $LF & 1;
        aY:
        $LF++;
        goto Lk;
        HT:
        $Zb |= $Yw;
        $FE[$Sg] = chr($Zb);
        Ji:
        $Sg++;
        goto Yg;
        bD:
        W1:
        $this->key = $FE;
        return $FE;
    }
    public static function getRawThumbprint($N1)
    {
        $ZC = explode("\xa", $N1);
        $xr = '';
        $PI = false;
        foreach ($ZC as $CW) {
            if (!$PI) {
                goto IM;
            }
            if (!(strncmp($CW, "\55\55\55\x2d\55\x45\x4e\x44\40\103\105\x52\x54\111\x46\x49\103\x41\x54\x45", 20) == 0)) {
                goto NR;
            }
            goto iw;
            NR:
            $xr .= trim($CW);
            goto Ae;
            IM:
            if (!(strncmp($CW, "\x2d\55\x2d\x2d\x2d\x42\105\107\x49\116\40\103\x45\122\124\x49\106\x49\103\x41\x54\105", 22) == 0)) {
                goto e7;
            }
            $PI = true;
            e7:
            Ae:
            Lh:
        }
        iw:
        if (empty($xr)) {
            goto aw;
        }
        return strtolower(sha1(base64_decode($xr)));
        aw:
        return null;
    }
    public function loadKey($FE, $Qc = false, $xg = false)
    {
        if ($Qc) {
            goto pW;
        }
        $this->key = $FE;
        goto O1;
        pW:
        $this->key = file_get_contents($FE);
        O1:
        if ($xg) {
            goto OD;
        }
        $this->x509Certificate = null;
        goto I5;
        OD:
        $this->key = openssl_x509_read($this->key);
        openssl_x509_export($this->key, $z8);
        $this->x509Certificate = $z8;
        $this->key = $z8;
        I5:
        if (!($this->cryptParams["\x6c\x69\142\162\x61\162\171"] == "\x6f\x70\x65\x6e\163\163\154")) {
            goto sr;
        }
        switch ($this->cryptParams["\x74\x79\160\x65"]) {
            case "\160\x75\142\154\151\143":
                if (!$xg) {
                    goto hX;
                }
                $this->X509Thumbprint = self::getRawThumbprint($this->key);
                hX:
                $this->key = openssl_get_publickey($this->key);
                if ($this->key) {
                    goto Nx;
                }
                throw new Exception("\x55\x6e\x61\142\x6c\x65\x20\164\x6f\40\145\x78\164\x72\x61\143\164\x20\160\x75\142\154\x69\143\40\153\145\171");
                Nx:
                goto xT;
            case "\x70\x72\x69\x76\141\x74\145":
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
                goto xT;
            case "\163\171\155\155\x65\164\162\151\143":
                if (!(strlen($this->key) < $this->cryptParams["\x6b\x65\x79\x73\x69\172\145"])) {
                    goto Le;
                }
                throw new Exception("\x4b\145\x79\x20\155\x75\163\164\x20\143\157\156\164\141\151\156\x20\x61\x74\40\154\x65\x61\163\x74\x20\62\x35\40\x63\x68\x61\x72\141\x63\x74\x65\162\163\40\146\x6f\x72\40\164\x68\x69\x73\x20\x63\151\x70\150\x65\x72");
                Le:
                goto xT;
            default:
                throw new Exception("\125\x6e\x6b\156\x6f\167\x6e\x20\164\x79\160\x65");
        }
        OX:
        xT:
        sr:
    }
    private function padISO10126($xr, $Ce)
    {
        if (!($Ce > 256)) {
            goto GS;
        }
        throw new Exception("\102\x6c\157\143\x6b\40\x73\151\x7a\x65\40\150\151\x67\150\145\162\x20\x74\x68\141\x6e\x20\62\65\x36\40\156\x6f\x74\x20\x61\154\x6c\157\167\x65\x64");
        GS:
        $LV = $Ce - strlen($xr) % $Ce;
        $Ay = chr($LV);
        return $xr . str_repeat($Ay, $LV);
    }
    private function unpadISO10126($xr)
    {
        $LV = substr($xr, -1);
        $A1 = ord($LV);
        return substr($xr, 0, -$A1);
    }
    private function encryptSymmetric($xr)
    {
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptParams["\x63\x69\x70\x68\x65\162"]));
        $xr = $this->padISO10126($xr, $this->cryptParams["\142\x6c\x6f\143\x6b\163\151\x7a\x65"]);
        $LM = openssl_encrypt($xr, $this->cryptParams["\x63\x69\160\150\145\162"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $LM)) {
            goto v0;
        }
        throw new Exception("\106\x61\x69\154\x75\162\145\40\145\156\x63\162\x79\x70\164\x69\x6e\147\x20\104\141\164\x61\x20\50\x6f\x70\x65\156\x73\x73\x6c\x20\163\x79\x6d\x6d\145\164\x72\151\143\51\x20\55\x20" . openssl_error_string());
        v0:
        return $this->iv . $LM;
    }
    private function decryptSymmetric($xr)
    {
        $EX = openssl_cipher_iv_length($this->cryptParams["\143\151\160\150\145\x72"]);
        $this->iv = substr($xr, 0, $EX);
        $xr = substr($xr, $EX);
        $Xl = openssl_decrypt($xr, $this->cryptParams["\x63\151\160\150\145\162"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $Xl)) {
            goto WH;
        }
        throw new Exception("\x46\141\x69\154\165\x72\x65\x20\144\145\143\162\171\x70\164\x69\x6e\147\40\x44\x61\164\x61\x20\50\157\x70\145\x6e\163\163\x6c\x20\x73\171\x6d\155\145\x74\x72\151\143\51\x20\55\40" . openssl_error_string());
        WH:
        return $this->unpadISO10126($Xl);
    }
    private function encryptPublic($xr)
    {
        if (openssl_public_encrypt($xr, $LM, $this->key, $this->cryptParams["\x70\141\x64\144\x69\x6e\147"])) {
            goto KG;
        }
        throw new Exception("\106\x61\x69\x6c\x75\162\x65\40\x65\156\x63\162\171\160\x74\151\156\x67\40\x44\x61\164\x61\40\50\157\x70\x65\156\x73\x73\x6c\40\x70\x75\142\x6c\151\x63\x29\40\x2d\40" . openssl_error_string());
        KG:
        return $LM;
    }
    private function decryptPublic($xr)
    {
        if (openssl_public_decrypt($xr, $Xl, $this->key, $this->cryptParams["\x70\141\x64\x64\x69\x6e\x67"])) {
            goto y6;
        }
        throw new Exception("\x46\141\151\x6c\165\x72\x65\x20\x64\145\143\162\x79\x70\164\151\156\147\x20\104\141\x74\x61\40\x28\157\x70\145\156\x73\163\x6c\40\160\165\x62\154\151\x63\51\x20\x2d\x20" . openssl_error_string());
        y6:
        return $Xl;
    }
    private function encryptPrivate($xr)
    {
        if (openssl_private_encrypt($xr, $LM, $this->key, $this->cryptParams["\x70\141\144\x64\x69\x6e\x67"])) {
            goto lD;
        }
        throw new Exception("\106\x61\151\x6c\x75\x72\145\x20\x65\156\x63\162\x79\x70\164\x69\x6e\x67\40\x44\x61\164\141\x20\x28\157\160\x65\156\x73\x73\154\x20\160\x72\x69\x76\141\x74\x65\x29\40\x2d\x20" . openssl_error_string());
        lD:
        return $LM;
    }
    private function decryptPrivate($xr)
    {
        if (openssl_private_decrypt($xr, $Xl, $this->key, $this->cryptParams["\160\141\x64\144\x69\156\147"])) {
            goto f2;
        }
        throw new Exception("\x46\x61\x69\154\x75\x72\x65\x20\x64\145\x63\162\171\x70\x74\x69\x6e\147\40\104\x61\x74\x61\x20\x28\157\x70\145\x6e\163\x73\154\40\x70\162\x69\166\x61\164\145\51\x20\55\x20" . openssl_error_string());
        f2:
        return $Xl;
    }
    private function signOpenSSL($xr)
    {
        $Hu = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\144\x69\147\x65\163\164"])) {
            goto rN;
        }
        $Hu = $this->cryptParams["\144\x69\147\x65\163\164"];
        rN:
        if (openssl_sign($xr, $PN, $this->key, $Hu)) {
            goto pQ;
        }
        throw new Exception("\x46\x61\151\154\x75\162\x65\x20\x53\151\x67\156\151\156\x67\x20\x44\141\164\x61\x3a\40" . openssl_error_string() . "\40\55\x20" . $Hu);
        pQ:
        return $PN;
    }
    private function verifyOpenSSL($xr, $PN)
    {
        $Hu = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\144\151\147\x65\x73\164"])) {
            goto sR;
        }
        $Hu = $this->cryptParams["\144\x69\147\145\163\164"];
        sR:
        return openssl_verify($xr, $PN, $this->key, $Hu);
    }
    public function encryptData($xr)
    {
        if (!($this->cryptParams["\x6c\x69\142\162\141\162\x79"] === "\157\x70\145\156\x73\163\x6c")) {
            goto Q1;
        }
        switch ($this->cryptParams["\164\x79\160\145"]) {
            case "\x73\x79\155\155\145\164\162\151\143":
                return $this->encryptSymmetric($xr);
            case "\x70\x75\x62\x6c\151\x63":
                return $this->encryptPublic($xr);
            case "\x70\x72\151\x76\141\x74\145":
                return $this->encryptPrivate($xr);
        }
        IC:
        j5:
        Q1:
    }
    public function decryptData($xr)
    {
        if (!($this->cryptParams["\x6c\x69\142\x72\141\162\x79"] === "\157\160\145\156\x73\x73\x6c")) {
            goto lr;
        }
        switch ($this->cryptParams["\x74\171\x70\x65"]) {
            case "\163\171\155\155\145\164\x72\x69\143":
                return $this->decryptSymmetric($xr);
            case "\160\165\x62\x6c\x69\143":
                return $this->decryptPublic($xr);
            case "\x70\x72\x69\166\x61\x74\145":
                return $this->decryptPrivate($xr);
        }
        DQ:
        C1:
        lr:
    }
    public function signData($xr)
    {
        switch ($this->cryptParams["\x6c\x69\x62\x72\141\x72\171"]) {
            case "\x6f\x70\x65\x6e\163\163\154":
                return $this->signOpenSSL($xr);
            case self::HMAC_SHA1:
                return hash_hmac("\163\150\141\61", $xr, $this->key, true);
        }
        R1:
        f0:
    }
    public function verifySignature($xr, $PN)
    {
        switch ($this->cryptParams["\x6c\x69\x62\x72\x61\162\x79"]) {
            case "\x6f\x70\x65\x6e\163\163\154":
                return $this->verifyOpenSSL($xr, $PN);
            case self::HMAC_SHA1:
                $C8 = hash_hmac("\163\x68\141\x31", $xr, $this->key, true);
                return strcmp($PN, $C8) == 0;
        }
        wY:
        rM:
    }
    public function getAlgorith()
    {
        return $this->getAlgorithm();
    }
    public function getAlgorithm()
    {
        return $this->cryptParams["\x6d\145\x74\150\157\x64"];
    }
    public static function makeAsnSegment($WK, $WG)
    {
        switch ($WK) {
            case 0x2:
                if (!(ord($WG) > 0x7f)) {
                    goto Co;
                }
                $WG = chr(0) . $WG;
                Co:
                goto QO;
            case 0x3:
                $WG = chr(0) . $WG;
                goto QO;
        }
        Uk:
        QO:
        $aw = strlen($WG);
        if ($aw < 128) {
            goto pr;
        }
        if ($aw < 0x100) {
            goto AH;
        }
        if ($aw < 0x10000) {
            goto Fc;
        }
        $OM = null;
        goto VZ;
        Fc:
        $OM = sprintf("\x25\143\x25\143\45\x63\45\x63\x25\163", $WK, 0x82, $aw / 0x100, $aw % 0x100, $WG);
        VZ:
        goto uf;
        AH:
        $OM = sprintf("\x25\x63\45\x63\x25\x63\45\163", $WK, 0x81, $aw, $WG);
        uf:
        goto Od;
        pr:
        $OM = sprintf("\45\x63\x25\x63\x25\163", $WK, $aw, $WG);
        Od:
        return $OM;
    }
    public static function convertRSA($uI, $LK)
    {
        $Hf = self::makeAsnSegment(0x2, $LK);
        $ri = self::makeAsnSegment(0x2, $uI);
        $e9 = self::makeAsnSegment(0x30, $ri . $Hf);
        $A8 = self::makeAsnSegment(0x3, $e9);
        $bf = pack("\110\x2a", "\x33\x30\60\x44\60\x36\60\x39\x32\101\70\66\x34\70\x38\x36\x46\x37\60\104\x30\61\x30\61\x30\x31\60\x35\x30\x30");
        $LD = self::makeAsnSegment(0x30, $bf . $A8);
        $W3 = base64_encode($LD);
        $I8 = "\55\55\55\x2d\x2d\x42\105\107\111\116\x20\x50\x55\x42\114\111\103\40\113\x45\x59\55\55\55\55\x2d\xa";
        $u3 = 0;
        dR:
        if (!($vW = substr($W3, $u3, 64))) {
            goto SU;
        }
        $I8 = $I8 . $vW . "\12";
        $u3 += 64;
        goto dR;
        SU:
        return $I8 . "\x2d\x2d\x2d\x2d\x2d\x45\x4e\x44\x20\x50\x55\102\x4c\111\x43\40\x4b\105\131\55\x2d\55\55\x2d\xa";
    }
    public function serializeKey($mn)
    {
    }
    public function getX509Certificate()
    {
        return $this->x509Certificate;
    }
    public function getX509Thumbprint()
    {
        return $this->X509Thumbprint;
    }
    public static function fromEncryptedKeyElement(DOMElement $YD)
    {
        $NY = new XMLSecEnc();
        $NY->setNode($YD);
        if ($zX = $NY->locateKey()) {
            goto vg;
        }
        throw new Exception("\125\156\141\142\x6c\x65\40\164\x6f\40\154\x6f\x63\x61\164\145\40\x61\154\x67\157\x72\x69\164\x68\x6d\40\146\x6f\x72\x20\164\x68\151\163\x20\105\x6e\x63\x72\171\x70\x74\x65\144\40\x4b\145\171");
        vg:
        $zX->isEncrypted = true;
        $zX->encryptedCtx = $NY;
        XMLSecEnc::staticLocateKeyInfo($zX, $YD);
        return $zX;
    }
}
