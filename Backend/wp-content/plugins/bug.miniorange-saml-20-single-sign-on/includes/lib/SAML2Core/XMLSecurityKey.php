<?php


namespace RobRichards\XMLSecLibs;

use DOMElement;
use Exception;
class XMLSecurityKey
{
    const TRIPLEDES_CBC = "\x68\164\x74\160\x3a\57\57\167\167\167\56\167\63\x2e\x6f\162\x67\57\x32\x30\x30\61\x2f\x30\64\x2f\x78\x6d\x6c\145\156\143\43\x74\x72\151\x70\154\x65\x64\145\x73\x2d\143\142\x63";
    const AES128_CBC = "\150\x74\164\x70\72\57\57\167\x77\x77\x2e\x77\x33\x2e\x6f\162\x67\x2f\x32\60\60\x31\x2f\60\x34\57\x78\155\x6c\145\156\x63\x23\x61\145\163\x31\x32\70\55\x63\x62\x63";
    const AES192_CBC = "\150\x74\164\160\72\x2f\x2f\x77\167\167\56\x77\x33\56\157\162\147\57\62\60\60\61\57\x30\64\57\170\x6d\154\x65\156\143\43\141\x65\x73\61\x39\x32\55\x63\x62\143";
    const AES256_CBC = "\150\x74\164\160\72\57\x2f\x77\167\x77\x2e\167\63\56\157\x72\x67\57\x32\60\60\61\x2f\60\64\57\x78\155\x6c\145\x6e\x63\43\141\x65\x73\x32\x35\x36\x2d\143\x62\143";
    const RSA_1_5 = "\x68\x74\x74\160\x3a\x2f\57\x77\167\x77\x2e\167\63\x2e\157\162\x67\57\x32\x30\x30\61\x2f\60\64\57\x78\x6d\x6c\x65\x6e\x63\x23\162\163\x61\55\61\x5f\x35";
    const RSA_OAEP_MGF1P = "\x68\x74\x74\x70\72\57\57\167\x77\x77\x2e\167\63\56\157\x72\x67\57\x32\60\x30\61\57\x30\x34\57\170\155\154\x65\x6e\143\43\x72\x73\x61\55\157\141\x65\160\x2d\x6d\x67\146\x31\160";
    const DSA_SHA1 = "\x68\164\164\160\x3a\57\57\x77\167\167\56\167\x33\56\157\x72\x67\x2f\62\60\60\x30\57\60\71\x2f\x78\155\x6c\144\163\x69\147\43\144\163\x61\55\x73\x68\x61\61";
    const RSA_SHA1 = "\x68\x74\164\160\72\x2f\57\x77\167\x77\56\167\63\56\x6f\162\x67\x2f\62\x30\60\60\57\x30\71\57\x78\155\154\x64\163\x69\x67\x23\x72\163\141\x2d\x73\x68\x61\x31";
    const RSA_SHA256 = "\x68\164\164\160\x3a\x2f\57\x77\x77\167\x2e\167\x33\56\157\162\x67\57\x32\60\60\61\x2f\60\64\x2f\170\155\x6c\144\163\x69\147\x2d\155\x6f\162\x65\x23\162\163\x61\x2d\x73\150\x61\62\x35\66";
    const RSA_SHA384 = "\150\x74\164\x70\x3a\57\57\167\167\x77\x2e\167\x33\x2e\157\162\x67\x2f\62\60\60\x31\x2f\x30\x34\57\x78\x6d\154\x64\x73\x69\147\55\x6d\x6f\162\145\43\x72\163\x61\x2d\x73\x68\x61\63\x38\x34";
    const RSA_SHA512 = "\x68\164\164\x70\72\x2f\x2f\167\167\167\56\167\63\56\x6f\x72\x67\57\x32\60\x30\x31\57\x30\x34\57\170\x6d\x6c\144\x73\x69\x67\x2d\x6d\x6f\162\145\43\x72\x73\x61\x2d\x73\x68\x61\x35\61\62";
    const HMAC_SHA1 = "\x68\164\x74\x70\x3a\x2f\57\x77\167\167\x2e\167\63\56\x6f\162\x67\57\x32\60\60\60\x2f\60\71\57\170\155\x6c\x64\x73\x69\x67\x23\150\x6d\x61\143\x2d\163\x68\x61\x31";
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
    public function __construct($Si, $yT = null)
    {
        switch ($Si) {
            case self::TRIPLEDES_CBC:
                $this->cryptParams["\x6c\x69\x62\162\141\x72\171"] = "\157\160\x65\x6e\163\163\154";
                $this->cryptParams["\143\x69\160\150\x65\x72"] = "\x64\145\163\x2d\x65\x64\x65\x33\55\x63\142\x63";
                $this->cryptParams["\164\x79\x70\145"] = "\x73\x79\x6d\x6d\x65\164\x72\x69\143";
                $this->cryptParams["\155\145\164\150\x6f\x64"] = "\x68\164\164\x70\x3a\57\x2f\x77\x77\x77\56\167\x33\56\x6f\162\x67\57\62\60\60\x31\57\x30\x34\57\x78\155\x6c\x65\x6e\x63\43\x74\162\x69\160\x6c\x65\144\x65\163\55\143\142\x63";
                $this->cryptParams["\153\145\x79\x73\x69\x7a\x65"] = 24;
                $this->cryptParams["\142\x6c\x6f\x63\153\x73\151\x7a\145"] = 8;
                goto l3;
            case self::AES128_CBC:
                $this->cryptParams["\x6c\151\142\162\x61\x72\171"] = "\157\160\145\x6e\x73\x73\x6c";
                $this->cryptParams["\x63\x69\160\x68\145\x72"] = "\x61\x65\x73\x2d\x31\62\x38\55\x63\142\x63";
                $this->cryptParams["\x74\171\x70\145"] = "\163\x79\x6d\155\x65\x74\162\151\143";
                $this->cryptParams["\155\x65\x74\150\157\x64"] = "\x68\x74\x74\160\72\57\x2f\167\167\x77\56\167\63\56\157\x72\x67\57\x32\60\x30\61\x2f\x30\64\57\x78\155\154\x65\156\143\x23\141\x65\x73\x31\x32\x38\55\143\142\x63";
                $this->cryptParams["\x6b\145\x79\163\151\x7a\145"] = 16;
                $this->cryptParams["\142\154\157\143\x6b\x73\151\172\x65"] = 16;
                goto l3;
            case self::AES192_CBC:
                $this->cryptParams["\154\151\142\162\x61\x72\171"] = "\157\x70\145\156\163\163\154";
                $this->cryptParams["\x63\151\160\x68\x65\162"] = "\141\x65\x73\55\x31\71\62\55\143\x62\x63";
                $this->cryptParams["\x74\171\160\x65"] = "\163\x79\x6d\x6d\145\164\x72\151\143";
                $this->cryptParams["\155\x65\x74\150\x6f\x64"] = "\x68\164\x74\x70\72\x2f\57\167\x77\167\x2e\x77\x33\x2e\x6f\x72\147\57\62\x30\60\61\57\60\64\x2f\170\155\154\x65\x6e\143\43\x61\x65\x73\61\x39\x32\55\x63\x62\x63";
                $this->cryptParams["\153\145\171\163\x69\172\x65"] = 24;
                $this->cryptParams["\142\154\157\143\x6b\x73\x69\x7a\x65"] = 16;
                goto l3;
            case self::AES256_CBC:
                $this->cryptParams["\x6c\151\142\162\x61\162\x79"] = "\x6f\160\x65\156\163\x73\x6c";
                $this->cryptParams["\x63\x69\x70\150\x65\162"] = "\x61\x65\163\55\62\x35\x36\x2d\x63\142\143";
                $this->cryptParams["\x74\171\x70\x65"] = "\163\x79\155\155\145\164\x72\x69\x63";
                $this->cryptParams["\155\145\164\150\157\144"] = "\x68\164\164\x70\x3a\57\x2f\x77\x77\167\x2e\167\63\56\157\162\147\x2f\x32\x30\60\61\x2f\60\64\57\170\155\154\x65\x6e\x63\x23\x61\x65\163\62\x35\x36\55\143\142\143";
                $this->cryptParams["\x6b\x65\171\163\x69\x7a\x65"] = 32;
                $this->cryptParams["\142\x6c\x6f\x63\x6b\163\x69\x7a\x65"] = 16;
                goto l3;
            case self::RSA_1_5:
                $this->cryptParams["\154\151\x62\x72\141\162\x79"] = "\157\160\145\156\x73\163\154";
                $this->cryptParams["\160\x61\144\x64\x69\x6e\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\155\x65\x74\x68\x6f\x64"] = "\150\164\x74\x70\x3a\x2f\57\x77\167\167\56\167\x33\56\x6f\x72\x67\x2f\x32\x30\x30\61\x2f\x30\64\57\x78\155\154\x65\156\143\43\162\x73\141\x2d\61\137\x35";
                if (!(is_array($yT) && !empty($yT["\x74\171\160\x65"]))) {
                    goto Yy;
                }
                if (!($yT["\x74\x79\160\x65"] == "\160\165\x62\x6c\151\x63" || $yT["\x74\x79\160\145"] == "\x70\x72\x69\166\x61\164\x65")) {
                    goto cr;
                }
                $this->cryptParams["\164\171\160\x65"] = $yT["\x74\171\x70\145"];
                goto l3;
                cr:
                Yy:
                throw new Exception("\103\145\162\164\151\146\151\143\141\x74\145\40\42\x74\171\160\145\x22\40\x28\x70\x72\151\166\x61\164\145\x2f\x70\165\x62\x6c\x69\x63\x29\x20\155\x75\x73\x74\40\x62\145\40\160\x61\163\163\145\x64\x20\166\x69\x61\x20\x70\x61\x72\141\155\145\x74\145\162\x73");
            case self::RSA_OAEP_MGF1P:
                $this->cryptParams["\154\x69\142\162\141\162\171"] = "\x6f\x70\x65\156\163\x73\x6c";
                $this->cryptParams["\x70\141\x64\144\151\x6e\147"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\155\x65\164\150\157\144"] = "\x68\x74\x74\160\72\x2f\x2f\x77\167\167\x2e\167\x33\x2e\x6f\x72\147\57\x32\x30\x30\x31\x2f\x30\x34\x2f\170\x6d\x6c\145\x6e\x63\43\162\x73\141\x2d\157\x61\145\160\55\155\147\146\x31\x70";
                $this->cryptParams["\x68\141\x73\150"] = null;
                if (!(is_array($yT) && !empty($yT["\164\171\x70\145"]))) {
                    goto Z6;
                }
                if (!($yT["\x74\x79\160\x65"] == "\160\x75\x62\154\151\143" || $yT["\164\171\x70\x65"] == "\160\162\x69\166\x61\x74\x65")) {
                    goto lx;
                }
                $this->cryptParams["\164\x79\x70\145"] = $yT["\164\171\x70\x65"];
                goto l3;
                lx:
                Z6:
                throw new Exception("\103\145\162\x74\151\146\151\x63\141\x74\145\40\42\x74\x79\x70\x65\x22\x20\x28\x70\x72\x69\166\x61\164\x65\57\x70\165\x62\154\151\x63\x29\40\x6d\x75\x73\164\40\x62\x65\40\x70\141\x73\x73\x65\x64\x20\166\151\x61\x20\x70\x61\x72\x61\155\145\x74\145\x72\163");
            case self::RSA_SHA1:
                $this->cryptParams["\x6c\151\x62\x72\x61\162\171"] = "\x6f\x70\x65\x6e\x73\163\154";
                $this->cryptParams["\155\x65\x74\x68\x6f\x64"] = "\150\x74\164\x70\x3a\57\57\167\167\167\56\167\x33\x2e\x6f\162\147\x2f\x32\60\x30\x30\57\x30\x39\x2f\170\x6d\x6c\144\163\151\x67\x23\x72\x73\x61\55\x73\150\141\61";
                $this->cryptParams["\x70\x61\x64\x64\151\x6e\x67"] = OPENSSL_PKCS1_PADDING;
                if (!(is_array($yT) && !empty($yT["\x74\x79\160\145"]))) {
                    goto gc;
                }
                if (!($yT["\164\x79\160\145"] == "\x70\x75\x62\x6c\151\x63" || $yT["\x74\171\x70\x65"] == "\x70\162\151\166\x61\164\x65")) {
                    goto rV;
                }
                $this->cryptParams["\x74\x79\x70\x65"] = $yT["\x74\x79\x70\x65"];
                goto l3;
                rV:
                gc:
                throw new Exception("\103\x65\x72\x74\x69\146\x69\x63\141\x74\145\40\x22\x74\171\160\x65\x22\40\x28\x70\162\x69\x76\x61\x74\145\57\160\165\142\x6c\x69\x63\51\40\155\165\x73\164\40\142\145\40\160\x61\x73\163\x65\144\x20\x76\151\141\40\160\x61\162\141\155\145\164\x65\x72\163");
            case self::RSA_SHA256:
                $this->cryptParams["\154\x69\142\162\141\162\171"] = "\157\160\x65\x6e\163\x73\x6c";
                $this->cryptParams["\x6d\145\x74\150\157\144"] = "\150\x74\x74\160\x3a\x2f\x2f\x77\x77\x77\x2e\167\63\56\x6f\162\x67\x2f\x32\60\x30\x31\57\60\x34\57\x78\x6d\154\144\x73\151\x67\55\x6d\x6f\162\x65\43\162\163\141\x2d\163\x68\141\62\65\66";
                $this->cryptParams["\160\141\144\x64\151\156\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\151\147\145\x73\x74"] = "\x53\110\101\x32\x35\66";
                if (!(is_array($yT) && !empty($yT["\x74\x79\160\x65"]))) {
                    goto Zg;
                }
                if (!($yT["\164\171\x70\x65"] == "\160\x75\142\154\x69\143" || $yT["\x74\171\x70\x65"] == "\160\x72\x69\166\x61\x74\145")) {
                    goto mk;
                }
                $this->cryptParams["\164\171\x70\145"] = $yT["\164\x79\160\x65"];
                goto l3;
                mk:
                Zg:
                throw new Exception("\103\145\x72\x74\x69\146\x69\143\x61\164\x65\x20\x22\164\x79\x70\145\42\x20\50\160\x72\x69\166\141\x74\145\57\x70\x75\x62\x6c\151\143\51\40\155\x75\x73\164\40\x62\145\x20\160\x61\163\x73\145\144\40\166\x69\141\40\160\141\162\x61\x6d\x65\164\x65\162\163");
            case self::RSA_SHA384:
                $this->cryptParams["\154\151\x62\x72\x61\162\x79"] = "\x6f\x70\145\x6e\163\x73\x6c";
                $this->cryptParams["\155\145\x74\150\x6f\144"] = "\x68\x74\x74\160\72\x2f\x2f\167\x77\x77\x2e\x77\x33\56\x6f\162\x67\57\62\60\x30\61\x2f\60\x34\x2f\x78\x6d\154\x64\x73\151\x67\x2d\155\x6f\x72\145\43\162\163\x61\x2d\x73\x68\x61\x33\x38\64";
                $this->cryptParams["\160\x61\144\x64\x69\x6e\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\151\147\145\163\164"] = "\x53\x48\x41\63\x38\64";
                if (!(is_array($yT) && !empty($yT["\164\x79\160\x65"]))) {
                    goto Sq;
                }
                if (!($yT["\x74\x79\160\x65"] == "\160\165\x62\154\151\x63" || $yT["\x74\x79\160\145"] == "\x70\162\x69\166\x61\x74\x65")) {
                    goto zc;
                }
                $this->cryptParams["\164\x79\160\x65"] = $yT["\x74\171\160\x65"];
                goto l3;
                zc:
                Sq:
                throw new Exception("\x43\x65\162\164\151\146\x69\x63\x61\x74\145\40\x22\x74\171\160\145\42\x20\x28\x70\x72\151\x76\x61\164\145\57\160\165\x62\154\151\143\51\x20\x6d\x75\163\x74\x20\x62\x65\40\160\141\163\x73\x65\x64\40\x76\151\141\x20\x70\141\x72\141\155\x65\164\145\162\x73");
            case self::RSA_SHA512:
                $this->cryptParams["\x6c\151\142\162\x61\x72\171"] = "\x6f\160\145\x6e\x73\163\154";
                $this->cryptParams["\155\145\164\150\157\x64"] = "\150\164\x74\x70\x3a\57\x2f\167\x77\167\56\167\63\x2e\157\x72\147\x2f\x32\60\60\61\57\x30\x34\x2f\170\155\154\x64\163\x69\x67\x2d\x6d\x6f\162\x65\x23\162\163\141\x2d\163\x68\x61\65\61\62";
                $this->cryptParams["\x70\141\x64\x64\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\151\147\x65\x73\164"] = "\x53\110\101\x35\61\x32";
                if (!(is_array($yT) && !empty($yT["\164\x79\x70\x65"]))) {
                    goto bb;
                }
                if (!($yT["\164\171\160\145"] == "\160\x75\x62\x6c\151\x63" || $yT["\x74\171\160\x65"] == "\x70\162\x69\166\x61\164\x65")) {
                    goto h0;
                }
                $this->cryptParams["\164\x79\x70\145"] = $yT["\164\x79\x70\x65"];
                goto l3;
                h0:
                bb:
                throw new Exception("\103\145\x72\164\151\x66\x69\143\141\164\x65\x20\x22\164\171\x70\145\42\40\50\x70\x72\151\166\141\164\x65\57\x70\165\x62\154\x69\143\x29\x20\155\165\x73\164\40\x62\145\40\160\x61\163\163\x65\144\x20\x76\x69\141\40\160\141\x72\141\155\145\164\x65\162\x73");
            case self::HMAC_SHA1:
                $this->cryptParams["\154\x69\142\x72\x61\162\x79"] = $Si;
                $this->cryptParams["\x6d\x65\164\150\157\144"] = "\x68\x74\x74\160\72\x2f\57\x77\167\167\56\x77\x33\56\x6f\x72\x67\x2f\62\60\60\x30\57\x30\x39\x2f\x78\x6d\x6c\x64\163\x69\147\43\x68\155\x61\143\55\x73\x68\141\61";
                goto l3;
            default:
                throw new Exception("\111\x6e\166\x61\154\151\144\40\113\x65\x79\40\124\171\160\x65");
        }
        eW:
        l3:
        $this->type = $Si;
    }
    public function getSymmetricKeySize()
    {
        if (isset($this->cryptParams["\153\145\x79\163\151\172\x65"])) {
            goto s9;
        }
        return null;
        s9:
        return $this->cryptParams["\153\x65\x79\x73\x69\172\x65"];
    }
    public function generateSessionKey()
    {
        if (isset($this->cryptParams["\x6b\145\x79\x73\x69\x7a\x65"])) {
            goto yM;
        }
        throw new Exception("\x55\x6e\153\x6e\157\x77\x6e\x20\153\x65\171\40\x73\x69\172\145\x20\146\157\162\40\164\x79\160\x65\40\x22" . $this->type . "\x22\x2e");
        yM:
        $Vx = $this->cryptParams["\x6b\x65\171\x73\x69\172\x65"];
        $ez = openssl_random_pseudo_bytes($Vx);
        if (!($this->type === self::TRIPLEDES_CBC)) {
            goto fz;
        }
        $fD = 0;
        X5:
        if (!($fD < strlen($ez))) {
            goto NP;
        }
        $iG = ord($ez[$fD]) & 0xfe;
        $cl = 1;
        $Ez = 1;
        O1:
        if (!($Ez < 8)) {
            goto iu;
        }
        $cl ^= $iG >> $Ez & 1;
        oz:
        $Ez++;
        goto O1;
        iu:
        $iG |= $cl;
        $ez[$fD] = chr($iG);
        Me:
        $fD++;
        goto X5;
        NP:
        fz:
        $this->key = $ez;
        return $ez;
    }
    public static function getRawThumbprint($Xf)
    {
        $rS = explode("\xa", $Xf);
        $wN = '';
        $Um = false;
        foreach ($rS as $gp) {
            if (!$Um) {
                goto cZ;
            }
            if (!(strncmp($gp, "\55\55\55\x2d\55\x45\116\104\x20\x43\x45\122\x54\111\106\x49\x43\x41\124\105", 20) == 0)) {
                goto V6;
            }
            goto J6;
            V6:
            $wN .= trim($gp);
            goto U9;
            cZ:
            if (!(strncmp($gp, "\x2d\55\55\55\55\x42\105\107\111\x4e\40\103\105\122\x54\x49\x46\x49\x43\x41\124\x45", 22) == 0)) {
                goto ZM;
            }
            $Um = true;
            ZM:
            U9:
            hH:
        }
        J6:
        if (empty($wN)) {
            goto K2;
        }
        return strtolower(sha1(base64_decode($wN)));
        K2:
        return null;
    }
    public function loadKey($ez, $UL = false, $QC = false)
    {
        if ($UL) {
            goto QH;
        }
        $this->key = $ez;
        goto K6;
        QH:
        $this->key = file_get_contents($ez);
        K6:
        if ($QC) {
            goto LQ;
        }
        $this->x509Certificate = null;
        goto uU;
        LQ:
        $this->key = openssl_x509_read($this->key);
        openssl_x509_export($this->key, $vU);
        $this->x509Certificate = $vU;
        $this->key = $vU;
        uU:
        if (!($this->cryptParams["\x6c\x69\142\162\141\x72\171"] == "\157\x70\x65\156\x73\x73\154")) {
            goto c2;
        }
        switch ($this->cryptParams["\164\171\160\145"]) {
            case "\160\165\x62\154\151\x63":
                if (!$QC) {
                    goto aE;
                }
                $this->X509Thumbprint = self::getRawThumbprint($this->key);
                aE:
                $this->key = openssl_get_publickey($this->key);
                if ($this->key) {
                    goto j4;
                }
                throw new Exception("\x55\x6e\x61\142\x6c\x65\40\x74\x6f\40\145\x78\164\162\x61\143\x74\40\x70\165\142\154\151\x63\x20\x6b\x65\171");
                j4:
                goto yp;
            case "\x70\x72\151\166\x61\x74\x65":
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
                goto yp;
            case "\x73\x79\x6d\x6d\x65\x74\162\151\x63":
                if (!(strlen($this->key) < $this->cryptParams["\x6b\x65\171\163\151\172\145"])) {
                    goto WA;
                }
                throw new Exception("\x4b\x65\x79\x20\155\165\163\x74\40\143\157\x6e\x74\x61\151\x6e\40\141\x74\x20\x6c\x65\x61\163\x74\x20\x32\x35\x20\143\x68\x61\x72\141\143\x74\x65\162\x73\x20\146\157\x72\x20\164\150\151\163\x20\x63\x69\x70\150\145\162");
                WA:
                goto yp;
            default:
                throw new Exception("\x55\156\153\156\x6f\x77\156\x20\x74\x79\160\x65");
        }
        wo:
        yp:
        c2:
    }
    private function padISO10126($wN, $sZ)
    {
        if (!($sZ > 256)) {
            goto KC;
        }
        throw new Exception("\102\154\157\143\x6b\40\x73\x69\x7a\145\40\150\x69\147\x68\145\x72\40\164\x68\141\x6e\40\x32\x35\x36\40\156\157\x74\40\x61\154\x6c\157\x77\145\x64");
        KC:
        $uN = $sZ - strlen($wN) % $sZ;
        $zQ = chr($uN);
        return $wN . str_repeat($zQ, $uN);
    }
    private function unpadISO10126($wN)
    {
        $uN = substr($wN, -1);
        $DQ = ord($uN);
        return substr($wN, 0, -$DQ);
    }
    private function encryptSymmetric($wN)
    {
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptParams["\x63\151\x70\x68\145\x72"]));
        $wN = $this->padISO10126($wN, $this->cryptParams["\x62\x6c\x6f\x63\153\163\x69\x7a\145"]);
        $TD = openssl_encrypt($wN, $this->cryptParams["\143\x69\160\x68\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $TD)) {
            goto wB;
        }
        throw new Exception("\x46\141\x69\154\x75\x72\145\40\x65\156\x63\162\x79\160\x74\151\156\x67\40\x44\141\x74\x61\40\50\x6f\x70\145\156\163\163\x6c\x20\163\171\155\x6d\x65\164\162\x69\x63\51\40\x2d\40" . openssl_error_string());
        wB:
        return $this->iv . $TD;
    }
    private function decryptSymmetric($wN)
    {
        $up = openssl_cipher_iv_length($this->cryptParams["\143\151\160\x68\145\162"]);
        $this->iv = substr($wN, 0, $up);
        $wN = substr($wN, $up);
        $cN = openssl_decrypt($wN, $this->cryptParams["\x63\x69\x70\150\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $cN)) {
            goto jU;
        }
        throw new Exception("\x46\x61\151\154\x75\x72\x65\x20\x64\x65\x63\x72\x79\160\x74\151\156\x67\x20\104\x61\164\x61\40\x28\x6f\x70\145\x6e\x73\x73\x6c\x20\x73\x79\155\x6d\x65\x74\x72\151\143\51\x20\55\40" . openssl_error_string());
        jU:
        return $this->unpadISO10126($cN);
    }
    private function encryptPublic($wN)
    {
        if (openssl_public_encrypt($wN, $TD, $this->key, $this->cryptParams["\x70\141\x64\x64\x69\x6e\147"])) {
            goto uW;
        }
        throw new Exception("\106\141\x69\154\x75\x72\145\40\145\156\x63\162\171\x70\x74\x69\x6e\x67\x20\104\141\x74\x61\x20\50\x6f\160\x65\156\x73\163\154\40\x70\165\142\154\x69\143\x29\x20\x2d\x20" . openssl_error_string());
        uW:
        return $TD;
    }
    private function decryptPublic($wN)
    {
        if (openssl_public_decrypt($wN, $cN, $this->key, $this->cryptParams["\160\x61\x64\x64\x69\x6e\x67"])) {
            goto CD;
        }
        throw new Exception("\x46\x61\151\x6c\165\x72\x65\x20\x64\145\143\162\x79\x70\x74\151\x6e\x67\x20\x44\141\x74\141\40\x28\157\160\145\x6e\163\163\x6c\x20\160\165\x62\x6c\x69\x63\x29\40\x2d\40" . openssl_error_string());
        CD:
        return $cN;
    }
    private function encryptPrivate($wN)
    {
        if (openssl_private_encrypt($wN, $TD, $this->key, $this->cryptParams["\x70\x61\144\144\x69\x6e\x67"])) {
            goto i3;
        }
        throw new Exception("\x46\x61\x69\154\x75\x72\x65\40\145\156\143\162\171\160\164\x69\156\147\x20\x44\141\164\141\40\x28\x6f\160\x65\156\x73\163\154\40\x70\x72\151\x76\141\164\x65\51\40\x2d\x20" . openssl_error_string());
        i3:
        return $TD;
    }
    private function decryptPrivate($wN)
    {
        if (openssl_private_decrypt($wN, $cN, $this->key, $this->cryptParams["\160\141\x64\x64\151\x6e\147"])) {
            goto x4;
        }
        throw new Exception("\106\141\151\154\x75\x72\x65\x20\144\x65\x63\162\x79\160\164\151\x6e\147\40\104\x61\164\x61\x20\x28\157\160\x65\156\163\x73\154\x20\160\162\x69\x76\x61\x74\x65\51\x20\55\x20" . openssl_error_string());
        x4:
        return $cN;
    }
    private function signOpenSSL($wN)
    {
        $Wd = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\x64\x69\x67\145\x73\x74"])) {
            goto pl;
        }
        $Wd = $this->cryptParams["\144\x69\147\145\163\164"];
        pl:
        if (openssl_sign($wN, $AF, $this->key, $Wd)) {
            goto Nv;
        }
        throw new Exception("\106\141\151\x6c\165\162\145\x20\x53\151\x67\x6e\x69\x6e\x67\40\104\141\164\141\72\x20" . openssl_error_string() . "\40\55\40" . $Wd);
        Nv:
        return $AF;
    }
    private function verifyOpenSSL($wN, $AF)
    {
        $Wd = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\x64\x69\147\145\x73\164"])) {
            goto iE;
        }
        $Wd = $this->cryptParams["\x64\x69\147\145\163\x74"];
        iE:
        return openssl_verify($wN, $AF, $this->key, $Wd);
    }
    public function encryptData($wN)
    {
        if (!($this->cryptParams["\154\x69\142\162\141\x72\x79"] === "\157\160\145\156\x73\163\154")) {
            goto I1;
        }
        switch ($this->cryptParams["\164\171\x70\x65"]) {
            case "\x73\x79\155\x6d\x65\x74\162\151\143":
                return $this->encryptSymmetric($wN);
            case "\x70\x75\x62\x6c\x69\x63":
                return $this->encryptPublic($wN);
            case "\x70\162\x69\166\141\164\x65":
                return $this->encryptPrivate($wN);
        }
        gm:
        U7:
        I1:
    }
    public function decryptData($wN)
    {
        if (!($this->cryptParams["\x6c\x69\142\162\x61\162\171"] === "\157\160\145\x6e\x73\x73\154")) {
            goto Sg;
        }
        switch ($this->cryptParams["\x74\171\x70\x65"]) {
            case "\x73\171\155\155\145\x74\x72\x69\143":
                return $this->decryptSymmetric($wN);
            case "\160\165\x62\154\x69\x63":
                return $this->decryptPublic($wN);
            case "\160\x72\x69\x76\141\x74\145":
                return $this->decryptPrivate($wN);
        }
        Gc:
        j6:
        Sg:
    }
    public function signData($wN)
    {
        switch ($this->cryptParams["\154\151\142\x72\x61\162\171"]) {
            case "\157\160\145\156\x73\x73\x6c":
                return $this->signOpenSSL($wN);
            case self::HMAC_SHA1:
                return hash_hmac("\163\150\x61\x31", $wN, $this->key, true);
        }
        Xr:
        hB:
    }
    public function verifySignature($wN, $AF)
    {
        switch ($this->cryptParams["\154\151\142\162\x61\162\x79"]) {
            case "\157\160\145\156\163\x73\154":
                return $this->verifyOpenSSL($wN, $AF);
            case self::HMAC_SHA1:
                $rk = hash_hmac("\163\150\141\x31", $wN, $this->key, true);
                return strcmp($AF, $rk) == 0;
        }
        PM:
        hK:
    }
    public function getAlgorith()
    {
        return $this->getAlgorithm();
    }
    public function getAlgorithm()
    {
        return $this->cryptParams["\x6d\x65\164\x68\x6f\144"];
    }
    public static function makeAsnSegment($Si, $ok)
    {
        switch ($Si) {
            case 0x2:
                if (!(ord($ok) > 0x7f)) {
                    goto J0;
                }
                $ok = chr(0) . $ok;
                J0:
                goto RX;
            case 0x3:
                $ok = chr(0) . $ok;
                goto RX;
        }
        a8:
        RX:
        $ey = strlen($ok);
        if ($ey < 128) {
            goto aD;
        }
        if ($ey < 0x100) {
            goto vS;
        }
        if ($ey < 0x10000) {
            goto je;
        }
        $SP = null;
        goto pv;
        je:
        $SP = sprintf("\45\143\x25\143\45\x63\45\143\45\x73", $Si, 0x82, $ey / 0x100, $ey % 0x100, $ok);
        pv:
        goto IU;
        vS:
        $SP = sprintf("\45\x63\x25\143\x25\143\x25\x73", $Si, 0x81, $ey, $ok);
        IU:
        goto yy;
        aD:
        $SP = sprintf("\45\x63\x25\x63\45\163", $Si, $ey, $ok);
        yy:
        return $SP;
    }
    public static function convertRSA($IB, $Lq)
    {
        $fL = self::makeAsnSegment(0x2, $Lq);
        $XW = self::makeAsnSegment(0x2, $IB);
        $Fi = self::makeAsnSegment(0x30, $XW . $fL);
        $d2 = self::makeAsnSegment(0x3, $Fi);
        $x8 = pack("\110\x2a", "\x33\x30\x30\x44\60\66\x30\71\x32\x41\70\66\64\x38\70\x36\x46\x37\60\x44\x30\x31\x30\61\60\x31\60\x35\60\x30");
        $VI = self::makeAsnSegment(0x30, $x8 . $d2);
        $h5 = base64_encode($VI);
        $GR = "\x2d\x2d\55\x2d\55\102\x45\107\x49\116\40\x50\125\x42\114\111\x43\x20\x4b\105\131\55\x2d\55\x2d\55\xa";
        $Cb = 0;
        nX:
        if (!($aL = substr($h5, $Cb, 64))) {
            goto F0;
        }
        $GR = $GR . $aL . "\xa";
        $Cb += 64;
        goto nX;
        F0:
        return $GR . "\x2d\55\55\55\x2d\105\x4e\x44\x20\x50\125\x42\x4c\111\103\40\113\105\131\55\55\x2d\55\x2d\12";
    }
    public function serializeKey($zy)
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
    public static function fromEncryptedKeyElement(DOMElement $GN)
    {
        $Gd = new XMLSecEnc();
        $Gd->setNode($GN);
        if ($RX = $Gd->locateKey()) {
            goto Q2;
        }
        throw new Exception("\125\x6e\x61\142\x6c\145\x20\164\x6f\x20\x6c\157\143\141\164\145\40\141\x6c\147\x6f\162\151\164\150\155\40\x66\157\x72\40\164\x68\x69\163\40\x45\156\x63\x72\171\x70\164\x65\x64\x20\113\145\x79");
        Q2:
        $RX->isEncrypted = true;
        $RX->encryptedCtx = $Gd;
        XMLSecEnc::staticLocateKeyInfo($RX, $GN);
        return $RX;
    }
}
