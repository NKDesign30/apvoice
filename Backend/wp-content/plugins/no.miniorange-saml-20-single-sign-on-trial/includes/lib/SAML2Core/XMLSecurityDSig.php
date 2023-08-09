<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath as XPath;
class XMLSecurityDSig
{
    const XMLDSIGNS = "\x68\x74\x74\160\72\57\57\x77\x77\167\56\x77\x33\x2e\x6f\162\147\x2f\62\60\60\60\57\60\x39\57\170\x6d\154\144\x73\x69\147\43";
    const SHA1 = "\x68\x74\x74\x70\72\57\57\167\x77\167\x2e\x77\63\56\157\x72\x67\57\x32\x30\60\60\x2f\x30\x39\x2f\170\155\x6c\144\163\151\147\x23\x73\150\141\x31";
    const SHA256 = "\150\164\164\x70\72\57\x2f\x77\x77\x77\56\x77\63\x2e\x6f\162\x67\x2f\62\x30\60\61\57\60\64\57\x78\155\x6c\x65\x6e\143\43\163\150\x61\x32\65\x36";
    const SHA384 = "\150\x74\164\x70\x3a\57\57\x77\167\167\x2e\167\x33\x2e\x6f\x72\147\57\62\60\x30\x31\x2f\60\x34\x2f\x78\155\154\x64\x73\151\x67\x2d\x6d\157\x72\145\x23\163\x68\141\63\70\x34";
    const SHA512 = "\x68\164\164\x70\72\57\57\167\167\167\56\x77\63\x2e\157\x72\x67\x2f\62\60\60\61\x2f\60\64\x2f\x78\155\x6c\145\156\143\43\163\x68\141\65\61\x32";
    const RIPEMD160 = "\150\164\x74\x70\x3a\x2f\x2f\x77\167\167\x2e\167\63\56\x6f\x72\147\57\x32\60\60\61\x2f\x30\64\x2f\170\x6d\x6c\x65\x6e\143\x23\162\151\160\x65\x6d\x64\61\66\60";
    const C14N = "\150\164\x74\x70\x3a\57\57\x77\x77\167\56\167\63\56\x6f\x72\x67\57\x54\122\x2f\x32\60\x30\61\57\x52\105\103\x2d\170\x6d\154\x2d\x63\x31\x34\x6e\55\62\x30\x30\x31\60\x33\61\65";
    const C14N_COMMENTS = "\150\164\164\160\72\57\57\167\167\x77\x2e\x77\63\56\x6f\162\x67\x2f\124\x52\x2f\x32\x30\x30\x31\x2f\x52\x45\x43\x2d\170\x6d\154\x2d\x63\61\x34\156\x2d\x32\60\x30\x31\60\x33\x31\x35\43\x57\x69\164\x68\103\x6f\x6d\x6d\145\156\164\163";
    const EXC_C14N = "\150\x74\x74\160\72\x2f\x2f\x77\x77\167\56\x77\x33\x2e\157\x72\147\57\x32\60\x30\61\x2f\x31\60\57\170\x6d\x6c\x2d\x65\170\143\x2d\143\x31\64\156\43";
    const EXC_C14N_COMMENTS = "\x68\x74\164\160\72\57\x2f\x77\167\167\56\x77\x33\x2e\157\162\147\x2f\x32\x30\x30\61\57\61\x30\x2f\170\155\x6c\55\x65\x78\x63\x2d\x63\x31\64\156\43\127\x69\x74\150\103\x6f\x6d\x6d\x65\x6e\x74\163";
    const template = "\74\144\x73\x3a\x53\x69\x67\156\141\x74\165\162\x65\x20\170\x6d\154\156\163\72\x64\x73\75\42\150\x74\x74\x70\72\57\x2f\167\x77\x77\56\x77\63\56\157\162\147\57\62\60\x30\60\x2f\60\x39\x2f\170\155\154\x64\163\151\147\43\42\x3e\xd\12\40\x20\74\x64\163\x3a\x53\151\x67\x6e\145\144\111\156\146\157\x3e\15\xa\40\x20\x20\x20\x3c\144\x73\x3a\x53\151\x67\x6e\141\x74\165\x72\145\x4d\145\164\x68\x6f\x64\x20\x2f\x3e\xd\12\40\40\x3c\x2f\x64\x73\72\x53\151\147\156\x65\x64\111\x6e\146\157\76\xd\xa\x3c\x2f\x64\163\72\123\151\x67\156\x61\164\165\x72\x65\76";
    const BASE_TEMPLATE = "\x3c\123\151\x67\156\141\164\165\162\x65\x20\170\155\x6c\x6e\x73\x3d\42\150\164\164\160\x3a\x2f\x2f\x77\167\167\x2e\167\x33\x2e\x6f\x72\x67\57\x32\60\x30\60\x2f\60\x39\x2f\x78\155\x6c\144\163\x69\147\43\x22\x3e\15\12\x20\40\x3c\123\151\147\156\145\144\x49\x6e\146\x6f\x3e\15\xa\x20\40\40\40\74\x53\x69\x67\156\x61\164\x75\162\x65\115\145\164\x68\157\x64\x20\x2f\76\15\xa\x20\x20\x3c\57\123\151\x67\156\x65\x64\111\x6e\146\x6f\76\15\12\x3c\57\x53\x69\x67\x6e\141\x74\x75\x72\x65\76";
    public $sigNode = null;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = null;
    private $xPathCtx = null;
    private $canonicalMethod = null;
    private $prefix = '';
    private $searchpfx = "\163\145\143\144\163\x69\x67";
    private $validatedNodes = null;
    public function __construct($o1 = "\144\163")
    {
        $fI = self::BASE_TEMPLATE;
        if (empty($o1)) {
            goto uH;
        }
        $this->prefix = $o1 . "\72";
        $QT = array("\x3c\x53", "\x3c\57\123", "\170\155\154\156\163\75");
        $B4 = array("\x3c{$o1}\x3a\123", "\74\57{$o1}\x3a\x53", "\170\x6d\x6c\156\163\72{$o1}\75");
        $fI = str_replace($QT, $B4, $fI);
        uH:
        $TH = new DOMDocument();
        $TH->loadXML($fI);
        $this->sigNode = $TH->documentElement;
    }
    private function resetXPathObj()
    {
        $this->xPathCtx = null;
    }
    private function getXPathObj()
    {
        if (!(empty($this->xPathCtx) && !empty($this->sigNode))) {
            goto jk;
        }
        $P3 = new DOMXPath($this->sigNode->ownerDocument);
        $P3->registerNamespace("\163\x65\x63\x64\163\x69\147", self::XMLDSIGNS);
        $this->xPathCtx = $P3;
        jk:
        return $this->xPathCtx;
    }
    public static function generateGUID($o1 = "\160\146\170")
    {
        $PT = md5(uniqid(mt_rand(), true));
        $aj = $o1 . substr($PT, 0, 8) . "\55" . substr($PT, 8, 4) . "\x2d" . substr($PT, 12, 4) . "\x2d" . substr($PT, 16, 4) . "\55" . substr($PT, 20, 12);
        return $aj;
    }
    public static function generate_GUID($o1 = "\x70\x66\x78")
    {
        return self::generateGUID($o1);
    }
    public function locateSignature($j0, $XU = 0)
    {
        if ($j0 instanceof DOMDocument) {
            goto qw;
        }
        $ta = $j0->ownerDocument;
        goto ti;
        qw:
        $ta = $j0;
        ti:
        if (!$ta) {
            goto jS;
        }
        $P3 = new DOMXPath($ta);
        $P3->registerNamespace("\x73\145\x63\144\x73\x69\x67", self::XMLDSIGNS);
        $FB = "\x2e\57\57\163\x65\x63\x64\x73\151\x67\x3a\123\151\x67\x6e\141\x74\165\162\145";
        $KK = $P3->query($FB, $j0);
        $this->sigNode = $KK->item($XU);
        return $this->sigNode;
        jS:
        return null;
    }
    public function createNewSignNode($Ex, $Ng = null)
    {
        $ta = $this->sigNode->ownerDocument;
        if (!is_null($Ng)) {
            goto qf;
        }
        $xi = $ta->createElementNS(self::XMLDSIGNS, $this->prefix . $Ex);
        goto z1;
        qf:
        $xi = $ta->createElementNS(self::XMLDSIGNS, $this->prefix . $Ex, $Ng);
        z1:
        return $xi;
    }
    public function setCanonicalMethod($Sa)
    {
        switch ($Sa) {
            case "\x68\x74\164\x70\72\57\x2f\x77\x77\167\x2e\x77\63\56\x6f\x72\147\57\124\x52\57\62\x30\60\61\x2f\x52\x45\x43\x2d\170\155\x6c\55\143\x31\64\x6e\55\x32\x30\60\x31\x30\x33\x31\65":
            case "\150\x74\x74\x70\72\x2f\57\167\x77\167\56\x77\63\56\x6f\x72\x67\57\x54\122\57\62\60\60\61\x2f\x52\x45\x43\x2d\x78\155\x6c\55\x63\61\64\156\55\62\x30\x30\61\60\x33\x31\65\x23\127\151\x74\x68\x43\x6f\155\x6d\145\x6e\x74\163":
            case "\150\164\x74\160\x3a\x2f\57\167\167\167\x2e\x77\x33\x2e\x6f\x72\x67\x2f\62\60\60\61\x2f\x31\x30\x2f\x78\155\154\55\x65\x78\143\55\143\61\x34\156\43":
            case "\150\164\x74\160\72\57\57\x77\167\x77\x2e\167\x33\56\157\x72\147\x2f\62\60\x30\x31\57\61\x30\x2f\x78\155\154\55\145\x78\143\55\x63\x31\x34\x6e\43\x57\x69\164\150\x43\157\x6d\x6d\145\156\x74\163":
                $this->canonicalMethod = $Sa;
                goto XA;
            default:
                throw new Exception("\111\156\166\141\x6c\151\144\x20\x43\141\x6e\157\x6e\151\143\x61\x6c\x20\x4d\x65\164\x68\157\144");
        }
        FX:
        XA:
        if (!($P3 = $this->getXPathObj())) {
            goto y7;
        }
        $FB = "\x2e\x2f" . $this->searchpfx . "\72\123\x69\147\x6e\x65\x64\x49\x6e\x66\x6f";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($DU = $KK->item(0))) {
            goto wc;
        }
        $FB = "\x2e\57" . $this->searchpfx . "\x43\x61\156\x6f\x6e\x69\143\141\154\151\172\141\164\x69\x6f\156\x4d\x65\164\x68\x6f\144";
        $KK = $P3->query($FB, $DU);
        if ($i5 = $KK->item(0)) {
            goto sT;
        }
        $i5 = $this->createNewSignNode("\x43\141\x6e\x6f\x6e\151\x63\141\x6c\x69\172\x61\x74\151\157\156\115\x65\x74\x68\x6f\x64");
        $DU->insertBefore($i5, $DU->firstChild);
        sT:
        $i5->setAttribute("\x41\154\x67\x6f\162\x69\x74\x68\155", $this->canonicalMethod);
        wc:
        y7:
    }
    private function canonicalizeData($xi, $p2, $DJ = null, $zJ = null)
    {
        $hF = false;
        $Qs = false;
        switch ($p2) {
            case "\150\164\164\x70\72\57\57\167\x77\167\x2e\167\x33\56\x6f\x72\147\x2f\x54\x52\57\62\60\x30\61\x2f\122\x45\103\x2d\x78\155\154\55\x63\x31\64\156\55\x32\60\60\61\x30\x33\x31\65":
                $hF = false;
                $Qs = false;
                goto Te;
            case "\x68\x74\164\x70\x3a\x2f\57\167\167\x77\x2e\x77\63\x2e\157\162\x67\57\124\122\x2f\62\60\60\61\57\x52\105\103\55\170\x6d\154\x2d\143\61\64\x6e\55\x32\x30\x30\61\x30\63\61\x35\43\x57\151\x74\150\x43\157\x6d\x6d\x65\x6e\164\163":
                $Qs = true;
                goto Te;
            case "\150\164\x74\160\72\x2f\57\167\x77\167\56\x77\x33\x2e\157\162\x67\57\x32\60\60\61\57\61\x30\57\x78\155\x6c\x2d\145\170\x63\x2d\143\x31\64\x6e\43":
                $hF = true;
                goto Te;
            case "\x68\x74\164\x70\x3a\57\57\167\x77\167\56\167\63\x2e\157\162\x67\x2f\x32\60\60\61\x2f\61\x30\57\x78\x6d\x6c\55\145\170\143\55\x63\x31\64\x6e\43\x57\151\x74\x68\103\x6f\155\x6d\x65\x6e\164\163":
                $hF = true;
                $Qs = true;
                goto Te;
        }
        Bm:
        Te:
        if (!(is_null($DJ) && $xi instanceof DOMNode && $xi->ownerDocument !== null && $xi->isSameNode($xi->ownerDocument->documentElement))) {
            goto ax;
        }
        $YD = $xi;
        hz:
        if (!($WM = $YD->previousSibling)) {
            goto iu;
        }
        if (!($WM->nodeType == XML_PI_NODE || $WM->nodeType == XML_COMMENT_NODE && $Qs)) {
            goto QT;
        }
        goto iu;
        QT:
        $YD = $WM;
        goto hz;
        iu:
        if (!($WM == null)) {
            goto u8;
        }
        $xi = $xi->ownerDocument;
        u8:
        ax:
        return $xi->C14N($hF, $Qs, $DJ, $zJ);
    }
    public function canonicalizeSignedInfo()
    {
        $ta = $this->sigNode->ownerDocument;
        $p2 = null;
        if (!$ta) {
            goto J6;
        }
        $P3 = $this->getXPathObj();
        $FB = "\x2e\x2f\163\145\143\x64\163\x69\147\x3a\123\151\147\x6e\145\144\111\156\x66\x6f";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($qs = $KK->item(0))) {
            goto g2;
        }
        $FB = "\56\x2f\x73\x65\143\144\x73\x69\x67\72\103\x61\156\x6f\156\x69\x63\x61\154\151\x7a\x61\164\151\x6f\156\115\x65\x74\150\157\x64";
        $KK = $P3->query($FB, $qs);
        if (!($i5 = $KK->item(0))) {
            goto aa;
        }
        $p2 = $i5->getAttribute("\101\x6c\147\157\x72\x69\x74\x68\x6d");
        aa:
        $this->signedInfo = $this->canonicalizeData($qs, $p2);
        return $this->signedInfo;
        g2:
        J6:
        return null;
    }
    public function calculateDigest($FM, $xr, $VK = true)
    {
        switch ($FM) {
            case self::SHA1:
                $gf = "\x73\150\x61\61";
                goto M2;
            case self::SHA256:
                $gf = "\x73\x68\x61\x32\65\66";
                goto M2;
            case self::SHA384:
                $gf = "\163\150\x61\63\x38\x34";
                goto M2;
            case self::SHA512:
                $gf = "\163\x68\x61\x35\x31\x32";
                goto M2;
            case self::RIPEMD160:
                $gf = "\x72\151\x70\x65\x6d\x64\x31\x36\x30";
                goto M2;
            default:
                throw new Exception("\x43\141\156\156\x6f\164\x20\x76\141\x6c\x69\144\x61\x74\x65\x20\144\x69\147\x65\x73\x74\x3a\40\125\156\163\x75\x70\x70\157\162\164\145\x64\x20\x41\x6c\x67\x6f\162\x69\x74\150\x6d\40\x3c{$FM}\x3e");
        }
        rz:
        M2:
        $t3 = hash($gf, $xr, true);
        if (!$VK) {
            goto z4;
        }
        $t3 = base64_encode($t3);
        z4:
        return $t3;
    }
    public function validateDigest($xb, $xr)
    {
        $P3 = new DOMXPath($xb->ownerDocument);
        $P3->registerNamespace("\163\x65\x63\x64\163\151\x67", self::XMLDSIGNS);
        $FB = "\x73\x74\x72\x69\156\x67\x28\56\57\x73\x65\x63\144\163\151\147\72\104\151\x67\145\163\x74\x4d\x65\x74\x68\x6f\144\x2f\x40\101\154\147\157\162\151\164\x68\x6d\x29";
        $FM = $P3->evaluate($FB, $xb);
        $Cg = $this->calculateDigest($FM, $xr, false);
        $FB = "\x73\164\162\151\156\x67\x28\x2e\x2f\163\145\143\144\x73\x69\x67\x3a\x44\151\x67\145\163\164\126\x61\x6c\165\145\51";
        $al = $P3->evaluate($FB, $xb);
        return $Cg === base64_decode($al);
    }
    public function processTransforms($xb, $tr, $x9 = true)
    {
        $xr = $tr;
        $P3 = new DOMXPath($xb->ownerDocument);
        $P3->registerNamespace("\x73\145\143\x64\163\x69\147", self::XMLDSIGNS);
        $FB = "\56\57\x73\145\143\144\x73\151\147\x3a\x54\162\141\x6e\163\146\157\162\x6d\x73\x2f\x73\x65\143\144\163\x69\147\72\x54\162\x61\x6e\x73\x66\157\162\x6d";
        $eQ = $P3->query($FB, $xb);
        $GM = "\x68\164\x74\x70\72\57\x2f\167\167\x77\56\x77\x33\56\x6f\x72\147\x2f\x54\x52\x2f\62\x30\60\61\57\122\105\103\x2d\x78\x6d\x6c\55\143\61\64\156\55\62\x30\60\61\x30\63\x31\65";
        $DJ = null;
        $zJ = null;
        foreach ($eQ as $z1) {
            $mz = $z1->getAttribute("\101\x6c\147\157\x72\x69\164\x68\155");
            switch ($mz) {
                case "\150\164\x74\160\72\x2f\x2f\167\x77\167\56\167\x33\x2e\157\162\x67\57\x32\60\x30\x31\x2f\x31\x30\x2f\170\155\x6c\55\x65\x78\x63\x2d\143\61\64\x6e\43":
                case "\150\164\x74\x70\x3a\x2f\x2f\x77\167\x77\x2e\167\63\x2e\x6f\x72\147\x2f\x32\x30\60\61\x2f\x31\60\57\x78\x6d\x6c\x2d\x65\170\143\x2d\x63\x31\x34\156\43\x57\151\x74\150\x43\x6f\x6d\x6d\x65\x6e\x74\163":
                    if (!$x9) {
                        goto Qf;
                    }
                    $GM = $mz;
                    goto CA;
                    Qf:
                    $GM = "\150\x74\x74\160\x3a\57\57\x77\x77\167\56\167\x33\x2e\157\x72\x67\x2f\62\x30\60\61\x2f\x31\x30\x2f\170\x6d\x6c\x2d\x65\170\x63\x2d\x63\x31\x34\156\x23";
                    CA:
                    $xi = $z1->firstChild;
                    O7:
                    if (!$xi) {
                        goto IN;
                    }
                    if (!($xi->localName == "\x49\x6e\143\x6c\165\163\151\x76\145\116\x61\155\145\163\160\x61\143\x65\x73")) {
                        goto nA;
                    }
                    if (!($qL = $xi->getAttribute("\120\x72\x65\146\x69\x78\114\x69\163\164"))) {
                        goto Ov;
                    }
                    $ym = array();
                    $Kr = explode("\x20", $qL);
                    foreach ($Kr as $qL) {
                        $AE = trim($qL);
                        if (empty($AE)) {
                            goto Zf;
                        }
                        $ym[] = $AE;
                        Zf:
                        Eh:
                    }
                    nw:
                    if (!(count($ym) > 0)) {
                        goto XL;
                    }
                    $zJ = $ym;
                    XL:
                    Ov:
                    goto IN;
                    nA:
                    $xi = $xi->nextSibling;
                    goto O7;
                    IN:
                    goto ub;
                case "\x68\x74\x74\160\x3a\x2f\x2f\167\167\167\56\167\63\56\157\x72\x67\x2f\x54\122\57\62\60\x30\61\x2f\122\105\103\55\170\155\154\x2d\x63\61\x34\x6e\x2d\62\60\x30\x31\x30\x33\x31\65":
                case "\x68\164\x74\x70\72\x2f\57\167\x77\x77\x2e\x77\63\56\x6f\x72\x67\57\x54\122\x2f\x32\x30\60\x31\x2f\x52\105\x43\x2d\x78\x6d\154\x2d\143\x31\64\156\55\62\60\60\x31\60\63\x31\x35\43\127\x69\164\x68\103\157\x6d\x6d\145\x6e\164\163":
                    if (!$x9) {
                        goto P0;
                    }
                    $GM = $mz;
                    goto X5;
                    P0:
                    $GM = "\150\x74\164\160\x3a\x2f\57\x77\167\x77\56\167\63\x2e\157\x72\x67\x2f\x54\x52\x2f\x32\x30\x30\x31\x2f\122\105\103\55\170\x6d\x6c\55\x63\61\64\156\55\62\60\60\61\60\63\61\x35";
                    X5:
                    goto ub;
                case "\x68\x74\x74\x70\72\57\57\x77\167\x77\x2e\167\63\x2e\x6f\x72\147\57\x54\x52\x2f\61\x39\x39\71\57\122\105\x43\55\170\160\x61\164\150\x2d\x31\71\x39\71\61\61\x31\x36":
                    $xi = $z1->firstChild;
                    xc:
                    if (!$xi) {
                        goto Zy;
                    }
                    if (!($xi->localName == "\x58\x50\x61\164\150")) {
                        goto eQ;
                    }
                    $DJ = array();
                    $DJ["\x71\x75\145\x72\x79"] = "\50\x2e\57\x2f\56\40\174\40\x2e\x2f\x2f\x40\52\x20\174\x20\x2e\57\x2f\156\141\155\145\x73\160\141\x63\x65\72\x3a\x2a\x29\x5b" . $xi->nodeValue . "\135";
                    $va["\156\141\x6d\x65\163\160\x61\x63\x65\163"] = array();
                    $rh = $P3->query("\56\x2f\x6e\x61\155\x65\163\160\141\x63\145\x3a\x3a\52", $xi);
                    foreach ($rh as $j_) {
                        if (!($j_->localName != "\x78\155\154")) {
                            goto Xz;
                        }
                        $DJ["\x6e\x61\155\145\163\160\x61\143\x65\163"][$j_->localName] = $j_->nodeValue;
                        Xz:
                        Qa:
                    }
                    Ed:
                    goto Zy;
                    eQ:
                    $xi = $xi->nextSibling;
                    goto xc;
                    Zy:
                    goto ub;
            }
            Ls:
            ub:
            U_:
        }
        D6:
        if (!$xr instanceof DOMNode) {
            goto Gv;
        }
        $xr = $this->canonicalizeData($tr, $GM, $DJ, $zJ);
        Gv:
        return $xr;
    }
    public function processRefNode($xb)
    {
        $jV = null;
        $x9 = true;
        if ($av = $xb->getAttribute("\x55\122\x49")) {
            goto Pv;
        }
        $x9 = false;
        $jV = $xb->ownerDocument;
        goto GP;
        Pv:
        $Lj = parse_url($av);
        if (!empty($Lj["\x70\x61\164\x68"])) {
            goto sa;
        }
        if ($Uh = $Lj["\x66\x72\141\x67\155\x65\156\x74"]) {
            goto i3;
        }
        $jV = $xb->ownerDocument;
        goto M6;
        i3:
        $x9 = false;
        $b5 = new DOMXPath($xb->ownerDocument);
        if (!($this->idNS && is_array($this->idNS))) {
            goto K1;
        }
        foreach ($this->idNS as $JK => $Qd) {
            $b5->registerNamespace($JK, $Qd);
            MJ:
        }
        Km:
        K1:
        $Dz = "\x40\111\144\75\x22" . XPath::filterAttrValue($Uh, XPath::DOUBLE_QUOTE) . "\x22";
        if (!is_array($this->idKeys)) {
            goto kM;
        }
        foreach ($this->idKeys as $XD) {
            $Dz .= "\40\x6f\x72\40\100" . XPath::filterAttrName($XD) . "\75\x22" . XPath::filterAttrValue($Uh, XPath::DOUBLE_QUOTE) . "\42";
            vR:
        }
        ez:
        kM:
        $FB = "\x2f\57\52\x5b" . $Dz . "\135";
        $jV = $b5->query($FB)->item(0);
        M6:
        sa:
        GP:
        $xr = $this->processTransforms($xb, $jV, $x9);
        if ($this->validateDigest($xb, $xr)) {
            goto wJ;
        }
        return false;
        wJ:
        if (!$jV instanceof DOMNode) {
            goto Nj;
        }
        if (!empty($Uh)) {
            goto zr;
        }
        $this->validatedNodes[] = $jV;
        goto Sj;
        zr:
        $this->validatedNodes[$Uh] = $jV;
        Sj:
        Nj:
        return true;
    }
    public function getRefNodeID($xb)
    {
        if (!($av = $xb->getAttribute("\x55\122\x49"))) {
            goto Q5;
        }
        $Lj = parse_url($av);
        if (!empty($Lj["\x70\x61\164\x68"])) {
            goto tx;
        }
        if (!($Uh = $Lj["\146\x72\x61\147\x6d\x65\156\164"])) {
            goto Me;
        }
        return $Uh;
        Me:
        tx:
        Q5:
        return null;
    }
    public function getRefIDs()
    {
        $mA = array();
        $P3 = $this->getXPathObj();
        $FB = "\56\57\163\145\143\144\x73\x69\147\x3a\123\151\x67\156\145\x64\x49\x6e\x66\x6f\x2f\163\x65\x63\x64\163\151\x67\x3a\122\x65\146\145\x72\x65\156\143\145";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($KK->length == 0)) {
            goto gj;
        }
        throw new Exception("\x52\145\x66\145\x72\x65\156\143\145\x20\156\x6f\x64\x65\x73\x20\x6e\x6f\164\40\146\157\165\x6e\x64");
        gj:
        foreach ($KK as $xb) {
            $mA[] = $this->getRefNodeID($xb);
            RS:
        }
        Er:
        return $mA;
    }
    public function validateReference()
    {
        $iS = $this->sigNode->ownerDocument->documentElement;
        if ($iS->isSameNode($this->sigNode)) {
            goto Y2;
        }
        if (!($this->sigNode->parentNode != null)) {
            goto L8;
        }
        $this->sigNode->parentNode->removeChild($this->sigNode);
        L8:
        Y2:
        $P3 = $this->getXPathObj();
        $FB = "\x2e\57\x73\x65\143\144\163\151\147\x3a\x53\151\147\x6e\145\x64\111\x6e\146\x6f\x2f\163\x65\x63\144\x73\151\147\72\122\x65\146\145\x72\145\156\x63\x65";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($KK->length == 0)) {
            goto F0;
        }
        throw new Exception("\122\145\x66\x65\x72\145\156\143\x65\40\x6e\157\x64\x65\163\x20\x6e\x6f\164\x20\x66\157\x75\156\x64");
        F0:
        $this->validatedNodes = array();
        foreach ($KK as $xb) {
            if ($this->processRefNode($xb)) {
                goto bi;
            }
            $this->validatedNodes = null;
            throw new Exception("\x52\x65\146\145\x72\145\x6e\x63\145\x20\x76\x61\154\151\144\x61\x74\151\157\x6e\x20\x66\141\151\154\145\x64");
            bi:
            Zi:
        }
        gm:
        return true;
    }
    private function addRefInternal($eq, $xi, $mz, $N7 = null, $Pg = null)
    {
        $o1 = null;
        $Gb = null;
        $AX = "\111\144";
        $f6 = true;
        $Hx = false;
        if (!is_array($Pg)) {
            goto NE;
        }
        $o1 = empty($Pg["\x70\x72\x65\x66\151\x78"]) ? null : $Pg["\160\162\145\146\151\170"];
        $Gb = empty($Pg["\160\x72\145\x66\x69\x78\137\156\163"]) ? null : $Pg["\160\162\145\x66\151\x78\137\x6e\x73"];
        $AX = empty($Pg["\x69\x64\x5f\156\x61\155\x65"]) ? "\x49\144" : $Pg["\151\x64\x5f\156\x61\155\145"];
        $f6 = !isset($Pg["\x6f\x76\145\162\x77\x72\151\164\x65"]) ? true : (bool) $Pg["\157\x76\145\162\167\162\151\164\x65"];
        $Hx = !isset($Pg["\146\157\x72\143\145\137\165\162\x69"]) ? false : (bool) $Pg["\x66\x6f\x72\143\145\x5f\165\x72\151"];
        NE:
        $sL = $AX;
        if (empty($o1)) {
            goto ul;
        }
        $sL = $o1 . "\72" . $sL;
        ul:
        $xb = $this->createNewSignNode("\122\x65\x66\145\x72\145\x6e\143\x65");
        $eq->appendChild($xb);
        if (!$xi instanceof DOMDocument) {
            goto Mv;
        }
        if ($Hx) {
            goto E2;
        }
        goto Eg;
        Mv:
        $av = null;
        if ($f6) {
            goto VD;
        }
        $av = $Gb ? $xi->getAttributeNS($Gb, $AX) : $xi->getAttribute($AX);
        VD:
        if (!empty($av)) {
            goto n4;
        }
        $av = self::generateGUID();
        $xi->setAttributeNS($Gb, $sL, $av);
        n4:
        $xb->setAttribute("\125\122\x49", "\43" . $av);
        goto Eg;
        E2:
        $xb->setAttribute("\x55\122\111", '');
        Eg:
        $XT = $this->createNewSignNode("\124\x72\x61\156\x73\146\157\162\x6d\x73");
        $xb->appendChild($XT);
        if (is_array($N7)) {
            goto Zs;
        }
        if (!empty($this->canonicalMethod)) {
            goto Oe;
        }
        goto Cy;
        Zs:
        foreach ($N7 as $z1) {
            $z2 = $this->createNewSignNode("\x54\162\x61\156\x73\146\157\x72\155");
            $XT->appendChild($z2);
            if (is_array($z1) && !empty($z1["\x68\x74\164\x70\72\x2f\57\167\x77\167\56\167\63\56\x6f\162\147\x2f\124\x52\x2f\x31\x39\71\x39\x2f\x52\105\103\55\x78\160\x61\164\150\x2d\x31\x39\x39\71\x31\61\61\x36"]) && !empty($z1["\150\164\x74\160\72\x2f\57\x77\x77\x77\x2e\x77\x33\56\x6f\162\147\x2f\124\122\x2f\61\x39\71\71\x2f\x52\x45\103\x2d\170\160\141\164\150\x2d\61\71\71\x39\61\x31\x31\66"]["\161\165\145\162\x79"])) {
                goto NB;
            }
            $z2->setAttribute("\x41\154\147\x6f\162\x69\x74\x68\155", $z1);
            goto HE;
            NB:
            $z2->setAttribute("\101\154\x67\157\162\x69\x74\150\155", "\150\x74\x74\160\72\x2f\x2f\x77\167\167\x2e\167\x33\56\157\162\x67\x2f\x54\122\x2f\61\71\71\71\x2f\x52\105\x43\55\x78\160\x61\x74\150\55\x31\x39\71\71\61\61\61\66");
            $Li = $this->createNewSignNode("\130\x50\x61\164\x68", $z1["\150\164\x74\160\x3a\x2f\57\167\167\167\x2e\167\63\56\x6f\162\x67\57\x54\122\x2f\61\71\x39\x39\x2f\x52\105\x43\55\170\160\x61\164\x68\x2d\61\71\71\71\61\61\61\x36"]["\161\165\145\162\171"]);
            $z2->appendChild($Li);
            if (empty($z1["\x68\x74\x74\160\x3a\x2f\x2f\167\x77\x77\56\167\63\x2e\x6f\x72\x67\57\x54\122\x2f\61\x39\x39\x39\x2f\x52\105\103\x2d\170\160\x61\x74\150\x2d\x31\x39\x39\71\61\x31\x31\x36"]["\156\141\155\145\x73\160\141\143\x65\x73"])) {
                goto a8;
            }
            foreach ($z1["\x68\x74\164\160\72\57\57\167\167\x77\56\x77\x33\56\157\x72\x67\x2f\124\122\x2f\61\x39\71\71\57\x52\x45\x43\x2d\x78\x70\141\x74\150\x2d\x31\x39\71\x39\x31\61\61\66"]["\156\141\x6d\145\163\160\x61\x63\x65\x73"] as $o1 => $NR) {
                $Li->setAttributeNS("\x68\164\164\x70\72\57\57\167\167\167\x2e\x77\x33\x2e\x6f\x72\147\57\62\x30\60\60\57\x78\x6d\154\156\163\x2f", "\170\x6d\154\x6e\x73\72{$o1}", $NR);
                G3:
            }
            v2:
            a8:
            HE:
            wg:
        }
        EP:
        goto Cy;
        Oe:
        $z2 = $this->createNewSignNode("\124\x72\x61\156\x73\146\x6f\162\x6d");
        $XT->appendChild($z2);
        $z2->setAttribute("\101\154\x67\x6f\x72\151\x74\150\x6d", $this->canonicalMethod);
        Cy:
        $ba = $this->processTransforms($xb, $xi);
        $Cg = $this->calculateDigest($mz, $ba);
        $Q1 = $this->createNewSignNode("\x44\151\x67\145\163\164\x4d\x65\164\x68\x6f\144");
        $xb->appendChild($Q1);
        $Q1->setAttribute("\101\x6c\147\x6f\162\151\164\150\155", $mz);
        $al = $this->createNewSignNode("\x44\151\x67\145\x73\164\x56\x61\x6c\x75\x65", $Cg);
        $xb->appendChild($al);
    }
    public function addReference($xi, $mz, $N7 = null, $Pg = null)
    {
        if (!($P3 = $this->getXPathObj())) {
            goto XJ;
        }
        $FB = "\56\x2f\163\145\x63\x64\163\151\x67\x3a\123\x69\x67\156\x65\144\x49\156\146\x6f";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($wZ = $KK->item(0))) {
            goto yV;
        }
        $this->addRefInternal($wZ, $xi, $mz, $N7, $Pg);
        yV:
        XJ:
    }
    public function addReferenceList($kJ, $mz, $N7 = null, $Pg = null)
    {
        if (!($P3 = $this->getXPathObj())) {
            goto ok;
        }
        $FB = "\x2e\57\x73\145\143\144\163\151\x67\x3a\123\x69\147\156\145\144\111\x6e\x66\x6f";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($wZ = $KK->item(0))) {
            goto EN;
        }
        foreach ($kJ as $xi) {
            $this->addRefInternal($wZ, $xi, $mz, $N7, $Pg);
            Pz:
        }
        dz:
        EN:
        ok:
    }
    public function addObject($xr, $Al = null, $I8 = null)
    {
        $mS = $this->createNewSignNode("\x4f\142\152\145\143\x74");
        $this->sigNode->appendChild($mS);
        if (empty($Al)) {
            goto Jj;
        }
        $mS->setAttribute("\115\x69\155\x65\x54\171\x70\145", $Al);
        Jj:
        if (empty($I8)) {
            goto gQ;
        }
        $mS->setAttribute("\x45\x6e\x63\157\x64\151\x6e\147", $I8);
        gQ:
        if ($xr instanceof DOMElement) {
            goto Hn;
        }
        $Yn = $this->sigNode->ownerDocument->createTextNode($xr);
        goto jx;
        Hn:
        $Yn = $this->sigNode->ownerDocument->importNode($xr, true);
        jx:
        $mS->appendChild($Yn);
        return $mS;
    }
    public function locateKey($xi = null)
    {
        if (!empty($xi)) {
            goto aA;
        }
        $xi = $this->sigNode;
        aA:
        if ($xi instanceof DOMNode) {
            goto dl;
        }
        return null;
        dl:
        if (!($ta = $xi->ownerDocument)) {
            goto Ii;
        }
        $P3 = new DOMXPath($ta);
        $P3->registerNamespace("\x73\145\143\144\x73\151\x67", self::XMLDSIGNS);
        $FB = "\163\164\x72\151\156\x67\x28\x2e\x2f\x73\x65\x63\144\163\151\147\72\x53\x69\147\156\145\x64\x49\x6e\146\x6f\57\163\145\143\144\x73\x69\x67\72\x53\x69\147\x6e\141\x74\x75\162\x65\115\x65\x74\x68\157\x64\x2f\x40\101\154\147\157\162\x69\164\x68\155\51";
        $mz = $P3->evaluate($FB, $xi);
        if (!$mz) {
            goto JM;
        }
        try {
            $zX = new XMLSecurityKey($mz, array("\164\x79\x70\145" => "\160\x75\142\154\151\x63"));
        } catch (Exception $Tn) {
            return null;
        }
        return $zX;
        JM:
        Ii:
        return null;
    }
    public function verify($zX)
    {
        $ta = $this->sigNode->ownerDocument;
        $P3 = new DOMXPath($ta);
        $P3->registerNamespace("\x73\x65\143\144\163\151\147", self::XMLDSIGNS);
        $FB = "\x73\164\x72\151\x6e\147\50\56\57\163\x65\x63\x64\163\x69\147\x3a\123\151\147\156\141\164\165\x72\145\x56\141\154\165\145\51";
        $Ch = $P3->evaluate($FB, $this->sigNode);
        if (!empty($Ch)) {
            goto fu;
        }
        throw new Exception("\x55\x6e\x61\142\154\x65\40\x74\x6f\40\x6c\157\x63\x61\164\x65\40\x53\x69\x67\x6e\141\164\x75\162\145\126\x61\154\165\145");
        fu:
        return $zX->verifySignature($this->signedInfo, base64_decode($Ch));
    }
    public function signData($zX, $xr)
    {
        return $zX->signData($xr);
    }
    public function sign($zX, $hk = null)
    {
        if (!($hk != null)) {
            goto zA;
        }
        $this->resetXPathObj();
        $this->appendSignature($hk);
        $this->sigNode = $hk->lastChild;
        zA:
        if (!($P3 = $this->getXPathObj())) {
            goto BS;
        }
        $FB = "\56\57\x73\145\143\x64\x73\x69\x67\72\x53\151\x67\156\x65\x64\111\156\146\x6f";
        $KK = $P3->query($FB, $this->sigNode);
        if (!($wZ = $KK->item(0))) {
            goto sz;
        }
        $FB = "\x2e\x2f\x73\x65\x63\144\x73\x69\147\x3a\123\151\147\x6e\x61\x74\x75\x72\x65\x4d\x65\x74\x68\157\x64";
        $KK = $P3->query($FB, $wZ);
        $aI = $KK->item(0);
        $aI->setAttribute("\x41\x6c\147\x6f\x72\151\x74\x68\x6d", $zX->type);
        $xr = $this->canonicalizeData($wZ, $this->canonicalMethod);
        $Ch = base64_encode($this->signData($zX, $xr));
        $EI = $this->createNewSignNode("\x53\x69\147\156\x61\164\x75\x72\x65\x56\141\x6c\165\145", $Ch);
        if ($A4 = $wZ->nextSibling) {
            goto Qj;
        }
        $this->sigNode->appendChild($EI);
        goto r0;
        Qj:
        $A4->parentNode->insertBefore($EI, $A4);
        r0:
        sz:
        BS:
    }
    public function appendCert()
    {
    }
    public function appendKey($zX, $mn = null)
    {
        $zX->serializeKey($mn);
    }
    public function insertSignature($xi, $wM = null)
    {
        $Mo = $xi->ownerDocument;
        $Ka = $Mo->importNode($this->sigNode, true);
        if ($wM == null) {
            goto R2;
        }
        return $xi->insertBefore($Ka, $wM);
        goto PN;
        R2:
        return $xi->insertBefore($Ka);
        PN:
    }
    public function appendSignature($d4, $TD = false)
    {
        $wM = $TD ? $d4->firstChild : null;
        return $this->insertSignature($d4, $wM);
    }
    public static function get509XCert($N1, $Dn = true)
    {
        $xW = self::staticGet509XCerts($N1, $Dn);
        if (empty($xW)) {
            goto U9;
        }
        return $xW[0];
        U9:
        return '';
    }
    public static function staticGet509XCerts($xW, $Dn = true)
    {
        if ($Dn) {
            goto q2;
        }
        return array($xW);
        goto Vu;
        q2:
        $xr = '';
        $Zv = array();
        $ZC = explode("\12", $xW);
        $PI = false;
        foreach ($ZC as $CW) {
            if (!$PI) {
                goto xS;
            }
            if (!(strncmp($CW, "\x2d\55\55\55\x2d\x45\116\104\x20\x43\105\x52\124\111\x46\x49\103\x41\124\x45", 20) == 0)) {
                goto Ng;
            }
            $PI = false;
            $Zv[] = $xr;
            $xr = '';
            goto AV;
            Ng:
            $xr .= trim($CW);
            goto KP;
            xS:
            if (!(strncmp($CW, "\x2d\x2d\55\55\x2d\102\x45\107\111\x4e\x20\103\105\x52\x54\111\106\x49\x43\x41\124\x45", 22) == 0)) {
                goto vw;
            }
            $PI = true;
            vw:
            KP:
            AV:
        }
        jB:
        return $Zv;
        Vu:
    }
    public static function staticAdd509Cert($bw, $N1, $Dn = true, $NJ = false, $P3 = null, $Pg = null)
    {
        if (!$NJ) {
            goto Zm;
        }
        $N1 = file_get_contents($N1);
        Zm:
        if ($bw instanceof DOMElement) {
            goto lM;
        }
        throw new Exception("\x49\x6e\x76\141\x6c\x69\x64\40\x70\x61\x72\x65\156\x74\40\x4e\x6f\144\145\x20\x70\x61\162\141\155\x65\x74\x65\162");
        lM:
        $w3 = $bw->ownerDocument;
        if (!empty($P3)) {
            goto du;
        }
        $P3 = new DOMXPath($bw->ownerDocument);
        $P3->registerNamespace("\163\x65\x63\x64\x73\151\147", self::XMLDSIGNS);
        du:
        $FB = "\56\57\x73\145\x63\144\163\x69\x67\x3a\113\x65\171\111\x6e\x66\x6f";
        $KK = $P3->query($FB, $bw);
        $yF = $KK->item(0);
        $nc = '';
        if (!$yF) {
            goto Pk;
        }
        $qL = $yF->lookupPrefix(self::XMLDSIGNS);
        if (empty($qL)) {
            goto xB;
        }
        $nc = $qL . "\72";
        xB:
        goto Ag;
        Pk:
        $qL = $bw->lookupPrefix(self::XMLDSIGNS);
        if (empty($qL)) {
            goto eR;
        }
        $nc = $qL . "\72";
        eR:
        $DF = false;
        $yF = $w3->createElementNS(self::XMLDSIGNS, $nc . "\x4b\x65\171\x49\x6e\146\157");
        $FB = "\x2e\57\x73\145\x63\144\x73\151\147\72\x4f\x62\x6a\145\143\x74";
        $KK = $P3->query($FB, $bw);
        if (!($kC = $KK->item(0))) {
            goto lB;
        }
        $kC->parentNode->insertBefore($yF, $kC);
        $DF = true;
        lB:
        if ($DF) {
            goto ls;
        }
        $bw->appendChild($yF);
        ls:
        Ag:
        $xW = self::staticGet509XCerts($N1, $Dn);
        $Hj = $w3->createElementNS(self::XMLDSIGNS, $nc . "\x58\65\60\71\x44\141\x74\141");
        $yF->appendChild($Hj);
        $Tl = false;
        $xv = false;
        if (!is_array($Pg)) {
            goto qr;
        }
        if (empty($Pg["\151\x73\163\165\x65\162\x53\x65\x72\x69\141\154"])) {
            goto V3;
        }
        $Tl = true;
        V3:
        if (empty($Pg["\x73\x75\x62\x6a\145\143\x74\x4e\x61\x6d\145"])) {
            goto CF;
        }
        $xv = true;
        CF:
        qr:
        foreach ($xW as $Rv) {
            if (!($Tl || $xv)) {
                goto d3;
            }
            if (!($tT = openssl_x509_parse("\55\x2d\x2d\x2d\x2d\102\x45\x47\x49\116\x20\x43\105\x52\124\111\x46\x49\103\101\124\105\55\55\x2d\55\x2d\xa" . chunk_split($Rv, 64, "\xa") . "\x2d\55\x2d\x2d\55\105\x4e\x44\40\x43\x45\122\124\x49\106\x49\x43\x41\x54\x45\x2d\x2d\55\x2d\55\xa"))) {
                goto rJ;
            }
            if (!($xv && !empty($tT["\x73\165\x62\x6a\x65\143\164"]))) {
                goto FP;
            }
            if (is_array($tT["\163\x75\x62\152\x65\143\x74"])) {
                goto sn;
            }
            $RL = $tT["\151\x73\x73\165\145\x72"];
            goto z8;
            sn:
            $Bs = array();
            foreach ($tT["\x73\165\x62\152\x65\143\x74"] as $FE => $Ng) {
                if (is_array($Ng)) {
                    goto b2;
                }
                array_unshift($Bs, "{$FE}\x3d{$Ng}");
                goto Og;
                b2:
                foreach ($Ng as $Xx) {
                    array_unshift($Bs, "{$FE}\x3d{$Xx}");
                    rX:
                }
                l0:
                Og:
                v9:
            }
            cK:
            $RL = implode("\x2c", $Bs);
            z8:
            $nP = $w3->createElementNS(self::XMLDSIGNS, $nc . "\x58\65\x30\71\123\165\x62\x6a\x65\x63\164\x4e\141\155\x65", $RL);
            $Hj->appendChild($nP);
            FP:
            if (!($Tl && !empty($tT["\151\x73\x73\x75\145\162"]) && !empty($tT["\163\145\162\x69\x61\x6c\x4e\x75\155\142\x65\x72"]))) {
                goto La;
            }
            if (is_array($tT["\151\163\x73\x75\x65\162"])) {
                goto OE;
            }
            $PZ = $tT["\151\x73\x73\165\145\x72"];
            goto eG;
            OE:
            $Bs = array();
            foreach ($tT["\151\163\163\165\145\162"] as $FE => $Ng) {
                array_unshift($Bs, "{$FE}\x3d{$Ng}");
                Ba:
            }
            nP:
            $PZ = implode("\x2c", $Bs);
            eG:
            $rf = $w3->createElementNS(self::XMLDSIGNS, $nc . "\130\x35\60\x39\x49\x73\x73\x75\145\x72\x53\145\162\x69\141\x6c");
            $Hj->appendChild($rf);
            $jM = $w3->createElementNS(self::XMLDSIGNS, $nc . "\x58\x35\60\x39\111\163\x73\x75\145\162\x4e\141\x6d\x65", $PZ);
            $rf->appendChild($jM);
            $jM = $w3->createElementNS(self::XMLDSIGNS, $nc . "\130\x35\60\x39\123\145\162\x69\x61\154\116\165\155\x62\x65\162", $tT["\x73\145\x72\151\141\x6c\x4e\165\x6d\x62\x65\162"]);
            $rf->appendChild($jM);
            La:
            rJ:
            d3:
            $yE = $w3->createElementNS(self::XMLDSIGNS, $nc . "\130\x35\x30\71\103\x65\x72\x74\x69\x66\x69\x63\141\x74\x65", $Rv);
            $Hj->appendChild($yE);
            WF:
        }
        ct:
    }
    public function add509Cert($N1, $Dn = true, $NJ = false, $Pg = null)
    {
        if (!($P3 = $this->getXPathObj())) {
            goto Pp;
        }
        self::staticAdd509Cert($this->sigNode, $N1, $Dn, $NJ, $P3, $Pg);
        Pp:
    }
    public function appendToKeyInfo($xi)
    {
        $bw = $this->sigNode;
        $w3 = $bw->ownerDocument;
        $P3 = $this->getXPathObj();
        if (!empty($P3)) {
            goto PR;
        }
        $P3 = new DOMXPath($bw->ownerDocument);
        $P3->registerNamespace("\x73\x65\x63\144\x73\x69\147", self::XMLDSIGNS);
        PR:
        $FB = "\56\57\x73\145\143\x64\x73\151\147\x3a\x4b\145\171\x49\156\146\x6f";
        $KK = $P3->query($FB, $bw);
        $yF = $KK->item(0);
        if ($yF) {
            goto Bt;
        }
        $nc = '';
        $qL = $bw->lookupPrefix(self::XMLDSIGNS);
        if (empty($qL)) {
            goto G2;
        }
        $nc = $qL . "\72";
        G2:
        $DF = false;
        $yF = $w3->createElementNS(self::XMLDSIGNS, $nc . "\x4b\145\171\x49\156\x66\157");
        $FB = "\x2e\x2f\163\145\x63\x64\163\x69\x67\72\x4f\x62\152\145\143\164";
        $KK = $P3->query($FB, $bw);
        if (!($kC = $KK->item(0))) {
            goto DW;
        }
        $kC->parentNode->insertBefore($yF, $kC);
        $DF = true;
        DW:
        if ($DF) {
            goto Jq;
        }
        $bw->appendChild($yF);
        Jq:
        Bt:
        $yF->appendChild($xi);
        return $yF;
    }
    public function getValidatedNodes()
    {
        return $this->validatedNodes;
    }
}
