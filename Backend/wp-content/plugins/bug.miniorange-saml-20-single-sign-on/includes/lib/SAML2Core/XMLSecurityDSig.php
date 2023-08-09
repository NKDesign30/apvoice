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
    const XMLDSIGNS = "\150\x74\x74\x70\x3a\x2f\57\167\x77\x77\56\167\x33\x2e\x6f\x72\x67\x2f\x32\60\x30\60\57\x30\x39\x2f\170\155\154\144\163\x69\x67\x23";
    const SHA1 = "\150\x74\164\160\72\x2f\57\x77\167\x77\x2e\167\63\x2e\x6f\162\147\57\x32\60\x30\x30\x2f\60\x39\x2f\x78\155\x6c\144\x73\x69\x67\43\163\x68\x61\x31";
    const SHA256 = "\x68\x74\164\160\72\57\x2f\x77\167\x77\56\167\x33\56\x6f\x72\x67\57\62\60\60\61\57\60\x34\x2f\170\155\x6c\145\156\x63\43\163\150\x61\62\65\66";
    const SHA384 = "\x68\164\x74\160\x3a\57\x2f\167\167\x77\56\167\63\x2e\157\x72\x67\57\62\x30\60\61\x2f\x30\64\x2f\170\x6d\x6c\x64\163\151\x67\x2d\155\157\x72\x65\43\163\150\141\x33\x38\64";
    const SHA512 = "\x68\164\x74\x70\x3a\57\x2f\x77\x77\167\56\167\63\x2e\157\162\x67\x2f\62\60\x30\61\57\x30\x34\57\170\x6d\x6c\x65\x6e\x63\x23\163\x68\x61\x35\61\62";
    const RIPEMD160 = "\x68\x74\x74\x70\72\x2f\57\167\x77\167\x2e\167\x33\x2e\157\162\147\57\62\60\x30\x31\57\60\64\x2f\x78\155\x6c\x65\x6e\143\x23\162\x69\160\145\155\x64\x31\x36\60";
    const C14N = "\150\164\x74\x70\x3a\57\x2f\167\x77\x77\x2e\x77\63\x2e\157\162\147\57\x54\x52\x2f\x32\60\60\61\57\122\x45\x43\x2d\170\155\154\55\143\61\x34\156\55\62\x30\x30\61\60\63\x31\65";
    const C14N_COMMENTS = "\150\x74\164\x70\72\57\57\x77\x77\x77\56\167\x33\x2e\x6f\x72\147\57\124\x52\57\62\60\x30\61\x2f\x52\105\x43\x2d\170\155\154\x2d\x63\x31\x34\156\55\62\60\x30\61\60\x33\61\x35\x23\x57\151\x74\150\x43\157\x6d\155\x65\156\164\163";
    const EXC_C14N = "\150\x74\164\160\x3a\x2f\x2f\x77\x77\167\56\x77\x33\x2e\157\x72\147\x2f\62\x30\x30\x31\x2f\61\60\x2f\170\x6d\154\x2d\145\x78\143\55\143\x31\x34\x6e\x23";
    const EXC_C14N_COMMENTS = "\150\164\x74\160\x3a\x2f\x2f\x77\x77\167\x2e\x77\63\x2e\157\162\x67\x2f\x32\x30\60\x31\x2f\x31\x30\57\170\x6d\154\55\x65\x78\143\x2d\x63\x31\64\156\x23\127\151\164\150\x43\x6f\155\155\x65\x6e\164\163";
    const template = "\x3c\x64\163\72\123\151\x67\156\x61\x74\165\162\x65\x20\170\155\154\x6e\x73\x3a\144\x73\x3d\42\150\x74\164\160\72\57\x2f\x77\x77\167\56\x77\63\56\157\162\x67\x2f\62\x30\60\x30\57\60\x39\x2f\170\155\x6c\144\163\151\147\43\42\x3e\xd\12\x20\x20\74\x64\x73\72\123\151\x67\x6e\145\x64\x49\x6e\146\157\x3e\15\xa\40\x20\40\x20\x3c\144\163\x3a\x53\x69\147\156\141\x74\165\162\145\x4d\145\164\150\157\144\40\x2f\76\xd\xa\40\40\x3c\57\144\163\x3a\123\151\147\156\x65\144\x49\x6e\146\x6f\76\15\xa\74\57\144\x73\x3a\x53\151\147\x6e\x61\164\x75\x72\x65\76";
    const BASE_TEMPLATE = "\x3c\x53\151\147\x6e\141\x74\165\x72\145\40\170\155\154\x6e\163\75\42\x68\164\x74\160\x3a\x2f\x2f\x77\167\x77\56\167\63\x2e\x6f\x72\x67\x2f\x32\x30\60\60\57\60\x39\x2f\x78\x6d\154\x64\x73\x69\147\43\x22\76\xd\12\40\x20\x3c\x53\x69\x67\156\145\x64\111\156\x66\157\76\15\12\x20\x20\x20\x20\74\123\151\x67\x6e\x61\x74\x75\162\145\x4d\145\x74\150\157\x64\x20\x2f\76\15\xa\40\40\x3c\x2f\123\151\x67\156\145\x64\111\x6e\146\x6f\x3e\xd\xa\x3c\x2f\123\151\x67\156\x61\164\x75\162\145\x3e";
    public $sigNode = null;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = null;
    private $xPathCtx = null;
    private $canonicalMethod = null;
    private $prefix = '';
    private $searchpfx = "\163\145\143\144\x73\x69\x67";
    private $validatedNodes = null;
    public function __construct($sK = "\144\x73")
    {
        $V0 = self::BASE_TEMPLATE;
        if (empty($sK)) {
            goto oj;
        }
        $this->prefix = $sK . "\72";
        $Yv = array("\74\x53", "\74\x2f\x53", "\x78\x6d\154\156\163\75");
        $pM = array("\x3c{$sK}\x3a\123", "\74\x2f{$sK}\x3a\x53", "\x78\x6d\x6c\156\x73\72{$sK}\75");
        $V0 = str_replace($Yv, $pM, $V0);
        oj:
        $vZ = new DOMDocument();
        $vZ->loadXML($V0);
        $this->sigNode = $vZ->documentElement;
    }
    private function resetXPathObj()
    {
        $this->xPathCtx = null;
    }
    private function getXPathObj()
    {
        if (!(empty($this->xPathCtx) && !empty($this->sigNode))) {
            goto oI;
        }
        $bg = new DOMXPath($this->sigNode->ownerDocument);
        $bg->registerNamespace("\163\x65\143\x64\163\151\x67", self::XMLDSIGNS);
        $this->xPathCtx = $bg;
        oI:
        return $this->xPathCtx;
    }
    public static function generateGUID($sK = "\x70\146\x78")
    {
        $vq = md5(uniqid(mt_rand(), true));
        $gv = $sK . substr($vq, 0, 8) . "\x2d" . substr($vq, 8, 4) . "\55" . substr($vq, 12, 4) . "\x2d" . substr($vq, 16, 4) . "\x2d" . substr($vq, 20, 12);
        return $gv;
    }
    public static function generate_GUID($sK = "\160\x66\x78")
    {
        return self::generateGUID($sK);
    }
    public function locateSignature($gU, $vX = 0)
    {
        if ($gU instanceof DOMDocument) {
            goto x8;
        }
        $gQ = $gU->ownerDocument;
        goto dm;
        x8:
        $gQ = $gU;
        dm:
        if (!$gQ) {
            goto gX;
        }
        $bg = new DOMXPath($gQ);
        $bg->registerNamespace("\163\x65\x63\144\163\x69\x67", self::XMLDSIGNS);
        $p4 = "\56\x2f\57\163\x65\143\x64\x73\x69\x67\72\x53\151\147\156\141\x74\x75\162\x65";
        $WI = $bg->query($p4, $gU);
        $this->sigNode = $WI->item($vX);
        return $this->sigNode;
        gX:
        return null;
    }
    public function createNewSignNode($BT, $T5 = null)
    {
        $gQ = $this->sigNode->ownerDocument;
        if (!is_null($T5)) {
            goto ek;
        }
        $m8 = $gQ->createElementNS(self::XMLDSIGNS, $this->prefix . $BT);
        goto bh;
        ek:
        $m8 = $gQ->createElementNS(self::XMLDSIGNS, $this->prefix . $BT, $T5);
        bh:
        return $m8;
    }
    public function setCanonicalMethod($Ft)
    {
        switch ($Ft) {
            case "\x68\x74\x74\160\72\x2f\x2f\167\x77\167\56\x77\63\56\157\162\147\57\x54\x52\57\62\x30\60\x31\x2f\x52\x45\x43\55\x78\155\154\55\x63\x31\64\x6e\x2d\x32\60\x30\61\60\63\x31\x35":
            case "\x68\x74\164\160\x3a\57\x2f\x77\167\x77\x2e\167\x33\x2e\157\162\x67\x2f\x54\x52\57\62\60\x30\x31\x2f\x52\x45\103\x2d\170\x6d\154\55\x63\x31\64\x6e\55\x32\x30\x30\61\x30\x33\61\x35\43\127\x69\164\150\x43\157\x6d\155\145\x6e\x74\x73":
            case "\x68\x74\164\x70\72\57\x2f\167\167\x77\x2e\167\63\56\x6f\x72\147\57\62\60\x30\x31\57\61\60\57\170\x6d\x6c\x2d\145\170\x63\x2d\x63\61\x34\x6e\x23":
            case "\x68\164\x74\160\x3a\57\x2f\x77\x77\167\x2e\167\x33\x2e\157\162\147\57\x32\60\x30\61\x2f\61\60\57\x78\x6d\154\x2d\145\x78\143\x2d\x63\61\x34\156\43\x57\x69\164\150\x43\x6f\155\x6d\145\156\x74\163":
                $this->canonicalMethod = $Ft;
                goto IV;
            default:
                throw new Exception("\x49\156\166\x61\x6c\x69\x64\x20\x43\141\x6e\157\x6e\151\143\x61\154\40\115\x65\x74\150\157\x64");
        }
        AN:
        IV:
        if (!($bg = $this->getXPathObj())) {
            goto FZ;
        }
        $p4 = "\x2e\57" . $this->searchpfx . "\x3a\123\x69\147\x6e\x65\144\111\x6e\146\x6f";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($sf = $WI->item(0))) {
            goto YI;
        }
        $p4 = "\56\x2f" . $this->searchpfx . "\x43\x61\x6e\x6f\156\x69\x63\x61\154\151\x7a\141\164\151\157\x6e\x4d\145\x74\150\157\144";
        $WI = $bg->query($p4, $sf);
        if ($an = $WI->item(0)) {
            goto X3;
        }
        $an = $this->createNewSignNode("\x43\141\x6e\x6f\x6e\x69\143\141\154\151\x7a\x61\x74\151\x6f\156\115\145\x74\150\x6f\x64");
        $sf->insertBefore($an, $sf->firstChild);
        X3:
        $an->setAttribute("\x41\x6c\147\157\x72\151\164\150\x6d", $this->canonicalMethod);
        YI:
        FZ:
    }
    private function canonicalizeData($m8, $yU, $V6 = null, $lf = null)
    {
        $Qw = false;
        $Is = false;
        switch ($yU) {
            case "\150\164\164\x70\x3a\57\57\x77\x77\x77\x2e\x77\63\56\157\162\x67\57\124\122\x2f\62\60\60\x31\57\x52\105\103\55\170\x6d\x6c\x2d\143\x31\64\156\x2d\x32\60\x30\61\x30\63\61\x35":
                $Qw = false;
                $Is = false;
                goto kj;
            case "\x68\164\164\x70\72\x2f\57\x77\167\x77\x2e\x77\63\56\157\162\x67\57\x54\122\57\x32\60\x30\x31\57\122\105\x43\55\x78\155\x6c\55\x63\61\x34\x6e\55\62\x30\x30\x31\60\x33\x31\65\x23\127\151\x74\150\x43\x6f\x6d\x6d\x65\156\164\x73":
                $Is = true;
                goto kj;
            case "\150\x74\164\160\x3a\57\x2f\x77\x77\x77\x2e\x77\x33\x2e\x6f\162\147\x2f\62\x30\60\61\x2f\x31\60\57\x78\155\x6c\x2d\x65\170\x63\x2d\143\61\64\156\43":
                $Qw = true;
                goto kj;
            case "\x68\x74\x74\x70\72\x2f\x2f\x77\x77\167\x2e\167\x33\x2e\x6f\162\x67\57\x32\60\60\61\x2f\x31\x30\57\x78\x6d\x6c\x2d\x65\170\x63\x2d\x63\61\x34\x6e\43\x57\x69\164\x68\103\157\155\155\145\156\164\163":
                $Qw = true;
                $Is = true;
                goto kj;
        }
        Jt:
        kj:
        if (!(is_null($V6) && $m8 instanceof DOMNode && $m8->ownerDocument !== null && $m8->isSameNode($m8->ownerDocument->documentElement))) {
            goto lF;
        }
        $GN = $m8;
        NU:
        if (!($NQ = $GN->previousSibling)) {
            goto dx;
        }
        if (!($NQ->nodeType == XML_PI_NODE || $NQ->nodeType == XML_COMMENT_NODE && $Is)) {
            goto Iy;
        }
        goto dx;
        Iy:
        $GN = $NQ;
        goto NU;
        dx:
        if (!($NQ == null)) {
            goto MI;
        }
        $m8 = $m8->ownerDocument;
        MI:
        lF:
        return $m8->C14N($Qw, $Is, $V6, $lf);
    }
    public function canonicalizeSignedInfo()
    {
        $gQ = $this->sigNode->ownerDocument;
        $yU = null;
        if (!$gQ) {
            goto f3;
        }
        $bg = $this->getXPathObj();
        $p4 = "\x2e\57\163\145\143\144\x73\151\x67\x3a\123\151\147\156\145\144\x49\x6e\146\157";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($C1 = $WI->item(0))) {
            goto YB;
        }
        $p4 = "\56\x2f\163\145\x63\144\163\151\147\x3a\x43\141\x6e\x6f\156\x69\143\141\x6c\151\172\x61\164\151\x6f\x6e\x4d\x65\x74\150\157\x64";
        $WI = $bg->query($p4, $C1);
        if (!($an = $WI->item(0))) {
            goto RB;
        }
        $yU = $an->getAttribute("\101\x6c\x67\157\162\151\x74\150\x6d");
        RB:
        $this->signedInfo = $this->canonicalizeData($C1, $yU);
        return $this->signedInfo;
        YB:
        f3:
        return null;
    }
    public function calculateDigest($kO, $wN, $H9 = true)
    {
        switch ($kO) {
            case self::SHA1:
                $Ty = "\163\150\x61\61";
                goto ft;
            case self::SHA256:
                $Ty = "\x73\x68\141\x32\x35\66";
                goto ft;
            case self::SHA384:
                $Ty = "\163\150\141\x33\70\64";
                goto ft;
            case self::SHA512:
                $Ty = "\x73\150\141\65\x31\62";
                goto ft;
            case self::RIPEMD160:
                $Ty = "\162\x69\160\x65\x6d\x64\61\x36\60";
                goto ft;
            default:
                throw new Exception("\103\x61\x6e\x6e\157\x74\40\x76\141\x6c\x69\x64\141\x74\145\x20\144\x69\x67\145\163\164\x3a\x20\x55\x6e\x73\165\160\x70\157\x72\164\x65\x64\40\101\154\147\x6f\162\151\164\150\x6d\40\x3c{$kO}\x3e");
        }
        Bb:
        ft:
        $L9 = hash($Ty, $wN, true);
        if (!$H9) {
            goto gy;
        }
        $L9 = base64_encode($L9);
        gy:
        return $L9;
    }
    public function validateDigest($Z0, $wN)
    {
        $bg = new DOMXPath($Z0->ownerDocument);
        $bg->registerNamespace("\163\x65\x63\x64\163\x69\147", self::XMLDSIGNS);
        $p4 = "\163\164\x72\x69\x6e\147\50\x2e\57\x73\145\x63\x64\163\151\147\72\104\151\x67\145\x73\164\x4d\145\164\x68\157\144\x2f\100\x41\154\x67\157\x72\x69\164\x68\155\51";
        $kO = $bg->evaluate($p4, $Z0);
        $Cg = $this->calculateDigest($kO, $wN, false);
        $p4 = "\163\x74\162\x69\x6e\147\x28\x2e\x2f\x73\145\143\x64\163\x69\x67\72\x44\151\147\x65\x73\x74\x56\141\154\x75\145\x29";
        $q_ = $bg->evaluate($p4, $Z0);
        return $Cg === base64_decode($q_);
    }
    public function processTransforms($Z0, $Zh, $bL = true)
    {
        $wN = $Zh;
        $bg = new DOMXPath($Z0->ownerDocument);
        $bg->registerNamespace("\163\145\x63\144\x73\x69\147", self::XMLDSIGNS);
        $p4 = "\x2e\x2f\x73\145\143\x64\x73\x69\x67\x3a\124\162\141\156\x73\x66\x6f\x72\155\163\57\x73\145\x63\x64\163\151\147\72\x54\162\141\x6e\163\x66\x6f\x72\x6d";
        $sI = $bg->query($p4, $Z0);
        $dz = "\x68\x74\x74\x70\x3a\57\x2f\x77\x77\x77\56\x77\x33\x2e\x6f\x72\147\57\124\x52\x2f\62\x30\x30\x31\57\122\105\x43\x2d\x78\155\154\55\143\x31\64\x6e\55\62\x30\x30\x31\x30\63\x31\x35";
        $V6 = null;
        $lf = null;
        foreach ($sI as $WH) {
            $HJ = $WH->getAttribute("\101\154\x67\x6f\162\151\164\x68\155");
            switch ($HJ) {
                case "\x68\164\164\x70\x3a\57\57\167\167\167\56\167\63\x2e\x6f\x72\147\57\62\x30\x30\x31\x2f\x31\x30\x2f\170\x6d\154\55\145\x78\143\55\x63\x31\64\156\43":
                case "\x68\164\x74\160\x3a\x2f\x2f\x77\x77\167\x2e\x77\63\56\157\162\x67\x2f\x32\x30\60\x31\57\61\x30\57\x78\155\154\x2d\x65\x78\x63\55\143\61\64\156\x23\x57\x69\x74\150\x43\x6f\x6d\155\145\x6e\x74\x73":
                    if (!$bL) {
                        goto cc;
                    }
                    $dz = $HJ;
                    goto Vy;
                    cc:
                    $dz = "\150\x74\164\x70\72\57\x2f\167\167\167\56\x77\63\x2e\157\162\x67\x2f\x32\x30\60\x31\x2f\x31\60\x2f\x78\155\154\55\x65\x78\x63\x2d\x63\x31\64\156\x23";
                    Vy:
                    $m8 = $WH->firstChild;
                    Ce:
                    if (!$m8) {
                        goto HO;
                    }
                    if (!($m8->localName == "\111\x6e\x63\154\165\x73\x69\x76\145\x4e\x61\155\145\x73\x70\141\143\145\163")) {
                        goto EO;
                    }
                    if (!($gE = $m8->getAttribute("\x50\x72\145\146\x69\170\x4c\151\x73\x74"))) {
                        goto iX;
                    }
                    $Bm = array();
                    $QW = explode("\x20", $gE);
                    foreach ($QW as $gE) {
                        $Wh = trim($gE);
                        if (empty($Wh)) {
                            goto iz;
                        }
                        $Bm[] = $Wh;
                        iz:
                        pF:
                    }
                    VT:
                    if (!(count($Bm) > 0)) {
                        goto pC;
                    }
                    $lf = $Bm;
                    pC:
                    iX:
                    goto HO;
                    EO:
                    $m8 = $m8->nextSibling;
                    goto Ce;
                    HO:
                    goto yC;
                case "\x68\x74\164\160\72\x2f\x2f\x77\x77\167\56\x77\63\x2e\157\x72\x67\x2f\x54\x52\x2f\x32\60\60\x31\57\x52\105\x43\55\170\x6d\154\55\143\61\64\x6e\55\x32\60\x30\x31\x30\63\x31\x35":
                case "\x68\164\164\x70\72\x2f\57\x77\167\x77\x2e\167\63\x2e\x6f\162\x67\57\124\122\x2f\x32\x30\x30\x31\x2f\122\x45\x43\55\170\x6d\x6c\55\143\x31\64\x6e\55\62\60\x30\x31\60\x33\61\65\43\x57\x69\x74\150\x43\157\155\155\145\156\164\163":
                    if (!$bL) {
                        goto q1;
                    }
                    $dz = $HJ;
                    goto Em;
                    q1:
                    $dz = "\150\164\164\160\72\x2f\x2f\x77\x77\x77\56\x77\x33\56\157\x72\x67\x2f\124\x52\57\x32\x30\60\61\x2f\122\x45\103\55\x78\155\x6c\55\143\61\x34\x6e\55\62\x30\x30\61\60\x33\61\65";
                    Em:
                    goto yC;
                case "\150\164\x74\160\72\x2f\x2f\x77\x77\x77\x2e\x77\x33\x2e\x6f\x72\x67\x2f\x54\x52\x2f\x31\71\x39\71\57\122\x45\103\x2d\170\x70\x61\x74\150\55\x31\71\x39\71\61\x31\x31\x36":
                    $m8 = $WH->firstChild;
                    KU:
                    if (!$m8) {
                        goto od;
                    }
                    if (!($m8->localName == "\130\120\141\x74\x68")) {
                        goto ct;
                    }
                    $V6 = array();
                    $V6["\161\165\145\x72\171"] = "\x28\56\57\57\x2e\x20\x7c\40\56\57\57\x40\x2a\40\x7c\40\56\57\57\x6e\141\x6d\145\163\x70\x61\143\145\x3a\72\x2a\x29\133" . $m8->nodeValue . "\x5d";
                    $My["\156\x61\155\145\x73\160\141\143\145\163"] = array();
                    $eW = $bg->query("\x2e\x2f\156\141\155\145\x73\x70\x61\x63\x65\x3a\x3a\x2a", $m8);
                    foreach ($eW as $vn) {
                        if (!($vn->localName != "\x78\155\154")) {
                            goto tO;
                        }
                        $V6["\x6e\141\x6d\145\x73\160\x61\x63\x65\163"][$vn->localName] = $vn->nodeValue;
                        tO:
                        OP:
                    }
                    mQ:
                    goto od;
                    ct:
                    $m8 = $m8->nextSibling;
                    goto KU;
                    od:
                    goto yC;
            }
            dj:
            yC:
            ss:
        }
        s6:
        if (!$wN instanceof DOMNode) {
            goto cX;
        }
        $wN = $this->canonicalizeData($Zh, $dz, $V6, $lf);
        cX:
        return $wN;
    }
    public function processRefNode($Z0)
    {
        $TB = null;
        $bL = true;
        if ($Sz = $Z0->getAttribute("\x55\x52\x49")) {
            goto Pa;
        }
        $bL = false;
        $TB = $Z0->ownerDocument;
        goto Eg;
        Pa:
        $G4 = parse_url($Sz);
        if (!empty($G4["\x70\141\x74\150"])) {
            goto hp;
        }
        if ($NV = $G4["\x66\x72\141\147\155\x65\156\164"]) {
            goto Op;
        }
        $TB = $Z0->ownerDocument;
        goto U0;
        Op:
        $bL = false;
        $cq = new DOMXPath($Z0->ownerDocument);
        if (!($this->idNS && is_array($this->idNS))) {
            goto R0;
        }
        foreach ($this->idNS as $pv => $d0) {
            $cq->registerNamespace($pv, $d0);
            y1:
        }
        uj:
        R0:
        $ep = "\x40\x49\144\x3d\x22" . XPath::filterAttrValue($NV, XPath::DOUBLE_QUOTE) . "\42";
        if (!is_array($this->idKeys)) {
            goto rG;
        }
        foreach ($this->idKeys as $d6) {
            $ep .= "\40\x6f\x72\x20\x40" . XPath::filterAttrName($d6) . "\75\42" . XPath::filterAttrValue($NV, XPath::DOUBLE_QUOTE) . "\x22";
            TC:
        }
        P8:
        rG:
        $p4 = "\57\57\52\x5b" . $ep . "\135";
        $TB = $cq->query($p4)->item(0);
        U0:
        hp:
        Eg:
        $wN = $this->processTransforms($Z0, $TB, $bL);
        if ($this->validateDigest($Z0, $wN)) {
            goto aU;
        }
        return false;
        aU:
        if (!$TB instanceof DOMNode) {
            goto st;
        }
        if (!empty($NV)) {
            goto lO;
        }
        $this->validatedNodes[] = $TB;
        goto YL;
        lO:
        $this->validatedNodes[$NV] = $TB;
        YL:
        st:
        return true;
    }
    public function getRefNodeID($Z0)
    {
        if (!($Sz = $Z0->getAttribute("\x55\122\x49"))) {
            goto Qi;
        }
        $G4 = parse_url($Sz);
        if (!empty($G4["\160\x61\164\x68"])) {
            goto Dn;
        }
        if (!($NV = $G4["\x66\162\x61\x67\x6d\145\x6e\x74"])) {
            goto dA;
        }
        return $NV;
        dA:
        Dn:
        Qi:
        return null;
    }
    public function getRefIDs()
    {
        $kY = array();
        $bg = $this->getXPathObj();
        $p4 = "\56\57\x73\145\143\x64\x73\151\x67\72\x53\151\x67\x6e\145\x64\x49\156\x66\157\x2f\x73\145\143\144\x73\x69\147\72\122\145\146\145\162\x65\x6e\143\x65";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($WI->length == 0)) {
            goto rF;
        }
        throw new Exception("\x52\x65\146\x65\x72\x65\x6e\x63\145\40\x6e\157\x64\145\x73\x20\x6e\x6f\x74\40\x66\x6f\165\156\x64");
        rF:
        foreach ($WI as $Z0) {
            $kY[] = $this->getRefNodeID($Z0);
            U3:
        }
        DG:
        return $kY;
    }
    public function validateReference()
    {
        $vr = $this->sigNode->ownerDocument->documentElement;
        if ($vr->isSameNode($this->sigNode)) {
            goto fF;
        }
        if (!($this->sigNode->parentNode != null)) {
            goto co;
        }
        $this->sigNode->parentNode->removeChild($this->sigNode);
        co:
        fF:
        $bg = $this->getXPathObj();
        $p4 = "\x2e\x2f\163\145\143\x64\163\151\147\x3a\x53\x69\x67\x6e\145\144\111\156\146\157\57\x73\145\143\x64\x73\x69\147\72\122\x65\146\145\x72\145\x6e\143\x65";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($WI->length == 0)) {
            goto UW;
        }
        throw new Exception("\x52\145\x66\145\162\x65\156\143\x65\40\156\157\x64\x65\x73\x20\156\x6f\x74\40\146\157\x75\x6e\144");
        UW:
        $this->validatedNodes = array();
        foreach ($WI as $Z0) {
            if ($this->processRefNode($Z0)) {
                goto EL;
            }
            $this->validatedNodes = null;
            throw new Exception("\122\145\x66\145\x72\x65\156\143\x65\40\166\x61\x6c\151\144\x61\x74\x69\x6f\x6e\40\x66\x61\x69\154\x65\x64");
            EL:
            T8:
        }
        Lc:
        return true;
    }
    private function addRefInternal($zC, $m8, $HJ, $gs = null, $pt = null)
    {
        $sK = null;
        $HA = null;
        $yu = "\x49\x64";
        $JA = true;
        $m2 = false;
        if (!is_array($pt)) {
            goto xO;
        }
        $sK = empty($pt["\x70\162\x65\146\151\170"]) ? null : $pt["\160\162\x65\146\x69\x78"];
        $HA = empty($pt["\160\x72\x65\146\151\170\137\156\x73"]) ? null : $pt["\x70\x72\145\146\x69\x78\x5f\x6e\x73"];
        $yu = empty($pt["\x69\144\137\x6e\141\155\x65"]) ? "\x49\x64" : $pt["\x69\x64\x5f\x6e\141\x6d\145"];
        $JA = !isset($pt["\x6f\x76\x65\x72\x77\x72\x69\164\145"]) ? true : (bool) $pt["\157\166\145\162\167\162\x69\x74\x65"];
        $m2 = !isset($pt["\x66\x6f\x72\x63\145\x5f\165\162\x69"]) ? false : (bool) $pt["\x66\157\x72\143\x65\x5f\165\x72\x69"];
        xO:
        $ai = $yu;
        if (empty($sK)) {
            goto tF;
        }
        $ai = $sK . "\x3a" . $ai;
        tF:
        $Z0 = $this->createNewSignNode("\x52\145\146\145\162\x65\x6e\143\145");
        $zC->appendChild($Z0);
        if (!$m8 instanceof DOMDocument) {
            goto Tv;
        }
        if ($m2) {
            goto XM;
        }
        goto u0;
        Tv:
        $Sz = null;
        if ($JA) {
            goto qX;
        }
        $Sz = $HA ? $m8->getAttributeNS($HA, $yu) : $m8->getAttribute($yu);
        qX:
        if (!empty($Sz)) {
            goto HJ;
        }
        $Sz = self::generateGUID();
        $m8->setAttributeNS($HA, $ai, $Sz);
        HJ:
        $Z0->setAttribute("\125\122\x49", "\x23" . $Sz);
        goto u0;
        XM:
        $Z0->setAttribute("\x55\x52\x49", '');
        u0:
        $gn = $this->createNewSignNode("\x54\x72\141\x6e\163\x66\157\x72\155\163");
        $Z0->appendChild($gn);
        if (is_array($gs)) {
            goto Ja;
        }
        if (!empty($this->canonicalMethod)) {
            goto p5;
        }
        goto ZW;
        Ja:
        foreach ($gs as $WH) {
            $Xs = $this->createNewSignNode("\x54\162\141\156\163\146\x6f\x72\155");
            $gn->appendChild($Xs);
            if (is_array($WH) && !empty($WH["\x68\164\x74\160\x3a\x2f\57\167\167\x77\56\x77\x33\x2e\157\x72\147\x2f\124\x52\57\x31\x39\71\71\x2f\x52\x45\x43\55\170\160\141\164\150\55\61\71\71\x39\61\x31\61\x36"]) && !empty($WH["\150\x74\x74\160\72\57\x2f\x77\167\x77\x2e\167\x33\56\157\x72\147\57\x54\122\x2f\x31\71\71\71\x2f\122\x45\x43\55\x78\x70\x61\x74\x68\55\x31\71\71\71\61\x31\61\66"]["\161\165\x65\x72\x79"])) {
                goto Bu;
            }
            $Xs->setAttribute("\101\154\x67\157\162\151\x74\150\x6d", $WH);
            goto kO;
            Bu:
            $Xs->setAttribute("\x41\x6c\147\157\162\151\164\x68\x6d", "\150\x74\164\x70\72\x2f\57\x77\x77\x77\56\167\63\56\157\x72\x67\x2f\124\122\57\x31\x39\71\x39\57\122\105\x43\55\170\x70\141\x74\150\x2d\61\71\x39\71\x31\61\61\x36");
            $i7 = $this->createNewSignNode("\x58\x50\141\164\150", $WH["\x68\164\164\160\72\x2f\57\167\x77\167\56\x77\x33\56\157\162\x67\57\x54\122\57\61\x39\71\x39\57\x52\x45\x43\55\170\160\141\164\x68\55\61\x39\71\x39\x31\61\x31\66"]["\x71\165\145\x72\x79"]);
            $Xs->appendChild($i7);
            if (empty($WH["\x68\164\164\x70\x3a\x2f\57\167\167\x77\x2e\167\x33\x2e\157\162\147\x2f\x54\122\57\61\71\71\x39\57\122\105\x43\x2d\170\160\141\x74\x68\55\x31\x39\x39\71\61\x31\x31\66"]["\156\141\155\145\163\160\x61\x63\x65\x73"])) {
                goto iU;
            }
            foreach ($WH["\150\164\164\x70\72\x2f\57\x77\167\167\56\167\x33\56\x6f\x72\x67\57\124\122\57\x31\x39\x39\x39\57\122\105\x43\55\x78\160\141\x74\x68\x2d\x31\x39\x39\x39\x31\x31\61\66"]["\156\x61\155\145\163\160\141\143\145\x73"] as $sK => $nL) {
                $i7->setAttributeNS("\x68\x74\x74\x70\72\57\57\167\x77\167\56\x77\63\x2e\157\x72\x67\57\62\x30\60\x30\57\x78\x6d\x6c\156\163\57", "\x78\x6d\154\156\x73\72{$sK}", $nL);
                TF:
            }
            QG:
            iU:
            kO:
            cj:
        }
        ca:
        goto ZW;
        p5:
        $Xs = $this->createNewSignNode("\x54\x72\x61\x6e\x73\x66\x6f\x72\x6d");
        $gn->appendChild($Xs);
        $Xs->setAttribute("\101\154\x67\x6f\162\x69\x74\x68\x6d", $this->canonicalMethod);
        ZW:
        $gk = $this->processTransforms($Z0, $m8);
        $Cg = $this->calculateDigest($HJ, $gk);
        $XD = $this->createNewSignNode("\x44\151\x67\x65\x73\164\x4d\145\164\150\x6f\144");
        $Z0->appendChild($XD);
        $XD->setAttribute("\101\154\147\x6f\162\151\164\x68\x6d", $HJ);
        $q_ = $this->createNewSignNode("\104\x69\x67\145\163\164\x56\141\x6c\x75\x65", $Cg);
        $Z0->appendChild($q_);
    }
    public function addReference($m8, $HJ, $gs = null, $pt = null)
    {
        if (!($bg = $this->getXPathObj())) {
            goto ED;
        }
        $p4 = "\x2e\57\x73\x65\143\x64\163\x69\x67\x3a\123\151\147\x6e\x65\x64\x49\156\146\157";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($Nd = $WI->item(0))) {
            goto W7;
        }
        $this->addRefInternal($Nd, $m8, $HJ, $gs, $pt);
        W7:
        ED:
    }
    public function addReferenceList($cx, $HJ, $gs = null, $pt = null)
    {
        if (!($bg = $this->getXPathObj())) {
            goto Ye;
        }
        $p4 = "\x2e\57\x73\145\x63\144\163\151\147\72\123\x69\x67\156\145\144\111\x6e\146\157";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($Nd = $WI->item(0))) {
            goto n8;
        }
        foreach ($cx as $m8) {
            $this->addRefInternal($Nd, $m8, $HJ, $gs, $pt);
            El:
        }
        hl:
        n8:
        Ye:
    }
    public function addObject($wN, $K6 = null, $GR = null)
    {
        $h7 = $this->createNewSignNode("\117\x62\x6a\x65\x63\x74");
        $this->sigNode->appendChild($h7);
        if (empty($K6)) {
            goto hx;
        }
        $h7->setAttribute("\x4d\x69\x6d\145\124\x79\x70\x65", $K6);
        hx:
        if (empty($GR)) {
            goto v0;
        }
        $h7->setAttribute("\105\156\x63\x6f\144\151\x6e\147", $GR);
        v0:
        if ($wN instanceof DOMElement) {
            goto gt;
        }
        $HY = $this->sigNode->ownerDocument->createTextNode($wN);
        goto lZ;
        gt:
        $HY = $this->sigNode->ownerDocument->importNode($wN, true);
        lZ:
        $h7->appendChild($HY);
        return $h7;
    }
    public function locateKey($m8 = null)
    {
        if (!empty($m8)) {
            goto Xf;
        }
        $m8 = $this->sigNode;
        Xf:
        if ($m8 instanceof DOMNode) {
            goto B_;
        }
        return null;
        B_:
        if (!($gQ = $m8->ownerDocument)) {
            goto IS;
        }
        $bg = new DOMXPath($gQ);
        $bg->registerNamespace("\x73\x65\143\144\163\151\x67", self::XMLDSIGNS);
        $p4 = "\163\164\x72\x69\156\x67\x28\x2e\57\x73\145\x63\x64\163\x69\x67\x3a\x53\151\147\156\145\x64\111\x6e\x66\157\x2f\x73\x65\x63\x64\x73\x69\147\72\123\151\x67\x6e\141\x74\x75\x72\145\x4d\145\x74\x68\x6f\x64\57\100\x41\154\147\157\x72\151\x74\x68\x6d\51";
        $HJ = $bg->evaluate($p4, $m8);
        if (!$HJ) {
            goto zP;
        }
        try {
            $RX = new XMLSecurityKey($HJ, array("\164\171\x70\145" => "\160\165\142\154\x69\x63"));
        } catch (Exception $aW) {
            return null;
        }
        return $RX;
        zP:
        IS:
        return null;
    }
    public function verify($RX)
    {
        $gQ = $this->sigNode->ownerDocument;
        $bg = new DOMXPath($gQ);
        $bg->registerNamespace("\x73\145\x63\144\x73\x69\147", self::XMLDSIGNS);
        $p4 = "\163\x74\x72\x69\156\x67\x28\56\x2f\163\x65\143\144\163\x69\x67\x3a\123\151\147\x6e\141\x74\x75\x72\145\126\x61\x6c\x75\x65\x29";
        $Nu = $bg->evaluate($p4, $this->sigNode);
        if (!empty($Nu)) {
            goto Qm;
        }
        throw new Exception("\x55\156\x61\142\154\x65\40\x74\157\x20\154\x6f\143\141\164\145\40\x53\151\147\156\x61\164\165\x72\145\126\141\x6c\x75\145");
        Qm:
        return $RX->verifySignature($this->signedInfo, base64_decode($Nu));
    }
    public function signData($RX, $wN)
    {
        return $RX->signData($wN);
    }
    public function sign($RX, $Tm = null)
    {
        if (!($Tm != null)) {
            goto Gw;
        }
        $this->resetXPathObj();
        $this->appendSignature($Tm);
        $this->sigNode = $Tm->lastChild;
        Gw:
        if (!($bg = $this->getXPathObj())) {
            goto WQ;
        }
        $p4 = "\56\x2f\x73\x65\143\x64\163\x69\147\x3a\x53\151\x67\x6e\x65\x64\111\156\x66\157";
        $WI = $bg->query($p4, $this->sigNode);
        if (!($Nd = $WI->item(0))) {
            goto F2;
        }
        $p4 = "\56\57\163\145\x63\144\163\151\147\x3a\123\151\147\x6e\x61\x74\x75\162\145\115\x65\x74\150\157\x64";
        $WI = $bg->query($p4, $Nd);
        $pL = $WI->item(0);
        $pL->setAttribute("\101\154\147\157\162\x69\164\x68\155", $RX->type);
        $wN = $this->canonicalizeData($Nd, $this->canonicalMethod);
        $Nu = base64_encode($this->signData($RX, $wN));
        $pG = $this->createNewSignNode("\x53\151\x67\156\141\164\165\162\x65\x56\141\x6c\165\x65", $Nu);
        if ($ZH = $Nd->nextSibling) {
            goto Kk;
        }
        $this->sigNode->appendChild($pG);
        goto e3;
        Kk:
        $ZH->parentNode->insertBefore($pG, $ZH);
        e3:
        F2:
        WQ:
    }
    public function appendCert()
    {
    }
    public function appendKey($RX, $zy = null)
    {
        $RX->serializeKey($zy);
    }
    public function insertSignature($m8, $Y9 = null)
    {
        $x4 = $m8->ownerDocument;
        $ll = $x4->importNode($this->sigNode, true);
        if ($Y9 == null) {
            goto Bh;
        }
        return $m8->insertBefore($ll, $Y9);
        goto QU;
        Bh:
        return $m8->insertBefore($ll);
        QU:
    }
    public function appendSignature($U8, $Ye = false)
    {
        $Y9 = $Ye ? $U8->firstChild : null;
        return $this->insertSignature($U8, $Y9);
    }
    public static function get509XCert($Xf, $DY = true)
    {
        $EL = self::staticGet509XCerts($Xf, $DY);
        if (empty($EL)) {
            goto ah;
        }
        return $EL[0];
        ah:
        return '';
    }
    public static function staticGet509XCerts($EL, $DY = true)
    {
        if ($DY) {
            goto CH;
        }
        return array($EL);
        goto qM;
        CH:
        $wN = '';
        $IG = array();
        $rS = explode("\xa", $EL);
        $Um = false;
        foreach ($rS as $gp) {
            if (!$Um) {
                goto dv;
            }
            if (!(strncmp($gp, "\55\x2d\x2d\x2d\55\105\x4e\104\x20\103\x45\122\124\111\x46\x49\103\101\x54\105", 20) == 0)) {
                goto qe;
            }
            $Um = false;
            $IG[] = $wN;
            $wN = '';
            goto Tl;
            qe:
            $wN .= trim($gp);
            goto fC;
            dv:
            if (!(strncmp($gp, "\x2d\55\55\55\x2d\102\x45\x47\111\116\40\x43\x45\x52\124\x49\x46\x49\x43\101\124\105", 22) == 0)) {
                goto Ws;
            }
            $Um = true;
            Ws:
            fC:
            Tl:
        }
        PZ:
        return $IG;
        qM:
    }
    public static function staticAdd509Cert($y3, $Xf, $DY = true, $kr = false, $bg = null, $pt = null)
    {
        if (!$kr) {
            goto TP;
        }
        $Xf = file_get_contents($Xf);
        TP:
        if ($y3 instanceof DOMElement) {
            goto Nd;
        }
        throw new Exception("\x49\x6e\x76\x61\154\151\x64\40\160\x61\x72\x65\156\x74\40\x4e\157\x64\x65\40\160\x61\162\x61\x6d\x65\x74\145\162");
        Nd:
        $O9 = $y3->ownerDocument;
        if (!empty($bg)) {
            goto lW;
        }
        $bg = new DOMXPath($y3->ownerDocument);
        $bg->registerNamespace("\163\x65\143\144\x73\x69\147", self::XMLDSIGNS);
        lW:
        $p4 = "\56\x2f\163\x65\x63\x64\x73\x69\x67\x3a\113\145\x79\111\156\146\x6f";
        $WI = $bg->query($p4, $y3);
        $Gn = $WI->item(0);
        $g5 = '';
        if (!$Gn) {
            goto Se;
        }
        $gE = $Gn->lookupPrefix(self::XMLDSIGNS);
        if (empty($gE)) {
            goto rT;
        }
        $g5 = $gE . "\72";
        rT:
        goto E6;
        Se:
        $gE = $y3->lookupPrefix(self::XMLDSIGNS);
        if (empty($gE)) {
            goto jM;
        }
        $g5 = $gE . "\x3a";
        jM:
        $ax = false;
        $Gn = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\113\x65\171\111\156\146\157");
        $p4 = "\56\x2f\x73\x65\143\144\x73\x69\x67\x3a\117\x62\x6a\x65\x63\164";
        $WI = $bg->query($p4, $y3);
        if (!($ie = $WI->item(0))) {
            goto uh;
        }
        $ie->parentNode->insertBefore($Gn, $ie);
        $ax = true;
        uh:
        if ($ax) {
            goto Bn;
        }
        $y3->appendChild($Gn);
        Bn:
        E6:
        $EL = self::staticGet509XCerts($Xf, $DY);
        $Lg = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\130\65\60\71\104\x61\164\x61");
        $Gn->appendChild($Lg);
        $Al = false;
        $eh = false;
        if (!is_array($pt)) {
            goto cx;
        }
        if (empty($pt["\151\163\x73\165\x65\x72\x53\145\x72\151\141\x6c"])) {
            goto yE;
        }
        $Al = true;
        yE:
        if (empty($pt["\x73\x75\x62\152\x65\x63\164\x4e\x61\155\145"])) {
            goto ZO;
        }
        $eh = true;
        ZO:
        cx:
        foreach ($EL as $Nx) {
            if (!($Al || $eh)) {
                goto s4;
            }
            if (!($mE = openssl_x509_parse("\x2d\x2d\55\x2d\x2d\102\105\x47\x49\x4e\40\103\x45\122\x54\x49\x46\111\x43\101\x54\x45\55\x2d\x2d\x2d\55\12" . chunk_split($Nx, 64, "\xa") . "\55\x2d\55\x2d\55\105\x4e\104\40\103\x45\122\x54\111\x46\x49\x43\101\x54\105\55\x2d\55\x2d\55\12"))) {
                goto B0;
            }
            if (!($eh && !empty($mE["\163\165\x62\x6a\145\x63\x74"]))) {
                goto tU;
            }
            if (is_array($mE["\163\165\142\152\x65\143\164"])) {
                goto QL;
            }
            $Fn = $mE["\151\x73\x73\165\145\162"];
            goto v5;
            QL:
            $s7 = array();
            foreach ($mE["\163\165\x62\x6a\x65\143\x74"] as $ez => $T5) {
                if (is_array($T5)) {
                    goto wS;
                }
                array_unshift($s7, "{$ez}\x3d{$T5}");
                goto T2;
                wS:
                foreach ($T5 as $Er) {
                    array_unshift($s7, "{$ez}\x3d{$Er}");
                    yz:
                }
                lp:
                T2:
                R8:
            }
            rM:
            $Fn = implode("\54", $s7);
            v5:
            $jv = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\130\x35\x30\71\x53\x75\x62\x6a\x65\143\x74\116\x61\x6d\145", $Fn);
            $Lg->appendChild($jv);
            tU:
            if (!($Al && !empty($mE["\151\163\x73\165\x65\x72"]) && !empty($mE["\163\x65\162\x69\x61\154\x4e\x75\x6d\x62\x65\x72"]))) {
                goto fg;
            }
            if (is_array($mE["\x69\163\163\165\x65\162"])) {
                goto Bp;
            }
            $n1 = $mE["\151\163\163\x75\145\162"];
            goto R7;
            Bp:
            $s7 = array();
            foreach ($mE["\x69\163\163\165\145\x72"] as $ez => $T5) {
                array_unshift($s7, "{$ez}\x3d{$T5}");
                We:
            }
            MB:
            $n1 = implode("\54", $s7);
            R7:
            $Bs = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\130\65\60\71\x49\163\163\165\x65\x72\x53\x65\x72\151\x61\x6c");
            $Lg->appendChild($Bs);
            $DS = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\130\x35\60\71\111\163\163\165\x65\x72\116\x61\x6d\145", $n1);
            $Bs->appendChild($DS);
            $DS = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\x58\65\60\x39\x53\145\162\x69\141\154\x4e\165\x6d\x62\145\162", $mE["\163\145\x72\x69\x61\x6c\116\165\155\x62\x65\162"]);
            $Bs->appendChild($DS);
            fg:
            B0:
            s4:
            $WT = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\130\65\60\71\x43\145\x72\x74\151\x66\151\143\x61\164\x65", $Nx);
            $Lg->appendChild($WT);
            VH:
        }
        G5:
    }
    public function add509Cert($Xf, $DY = true, $kr = false, $pt = null)
    {
        if (!($bg = $this->getXPathObj())) {
            goto VL;
        }
        self::staticAdd509Cert($this->sigNode, $Xf, $DY, $kr, $bg, $pt);
        VL:
    }
    public function appendToKeyInfo($m8)
    {
        $y3 = $this->sigNode;
        $O9 = $y3->ownerDocument;
        $bg = $this->getXPathObj();
        if (!empty($bg)) {
            goto pA;
        }
        $bg = new DOMXPath($y3->ownerDocument);
        $bg->registerNamespace("\163\145\x63\x64\163\x69\x67", self::XMLDSIGNS);
        pA:
        $p4 = "\x2e\x2f\x73\145\143\144\163\x69\147\72\x4b\x65\x79\x49\156\146\x6f";
        $WI = $bg->query($p4, $y3);
        $Gn = $WI->item(0);
        if ($Gn) {
            goto A_;
        }
        $g5 = '';
        $gE = $y3->lookupPrefix(self::XMLDSIGNS);
        if (empty($gE)) {
            goto vq;
        }
        $g5 = $gE . "\x3a";
        vq:
        $ax = false;
        $Gn = $O9->createElementNS(self::XMLDSIGNS, $g5 . "\x4b\x65\171\x49\156\146\157");
        $p4 = "\x2e\57\163\145\143\144\163\151\147\72\117\x62\x6a\x65\x63\164";
        $WI = $bg->query($p4, $y3);
        if (!($ie = $WI->item(0))) {
            goto oD;
        }
        $ie->parentNode->insertBefore($Gn, $ie);
        $ax = true;
        oD:
        if ($ax) {
            goto Kv;
        }
        $y3->appendChild($Gn);
        Kv:
        A_:
        $Gn->appendChild($m8);
        return $Gn;
    }
    public function getValidatedNodes()
    {
        return $this->validatedNodes;
    }
}
