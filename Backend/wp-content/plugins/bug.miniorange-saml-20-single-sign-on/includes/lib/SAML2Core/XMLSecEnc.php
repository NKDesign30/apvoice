<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath as XPath;
class XMLSecEnc
{
    const template = "\74\x78\x65\x6e\x63\x3a\105\x6e\143\x72\x79\160\164\x65\x64\x44\x61\x74\141\40\x78\155\x6c\x6e\x73\x3a\x78\x65\x6e\143\75\47\x68\164\164\160\72\57\57\167\167\167\56\x77\63\56\157\x72\147\57\62\x30\x30\x31\57\x30\x34\57\170\155\154\x65\156\x63\x23\47\x3e\15\12\x20\40\x20\x3c\170\145\x6e\143\x3a\x43\x69\x70\x68\x65\x72\104\141\x74\141\x3e\xd\12\x20\x20\x20\x20\x20\40\74\x78\145\156\143\x3a\103\151\x70\150\145\162\x56\x61\x6c\x75\x65\76\x3c\x2f\170\x65\x6e\143\x3a\103\x69\160\x68\x65\162\x56\x61\x6c\x75\145\76\xd\xa\40\x20\40\x3c\57\170\145\156\143\x3a\x43\x69\160\150\145\x72\104\x61\164\141\76\xd\12\x3c\x2f\170\145\x6e\x63\72\x45\x6e\x63\x72\x79\160\x74\x65\x64\x44\141\164\x61\76";
    const Element = "\150\164\x74\160\x3a\57\x2f\167\x77\167\56\x77\x33\56\x6f\162\147\57\62\x30\60\61\57\60\x34\x2f\x78\155\154\x65\x6e\x63\x23\105\x6c\x65\155\x65\156\164";
    const Content = "\150\x74\164\x70\x3a\57\57\167\x77\167\56\x77\x33\56\157\x72\147\x2f\62\x30\x30\61\57\x30\x34\57\170\x6d\x6c\145\156\143\43\103\x6f\x6e\164\x65\x6e\x74";
    const URI = 3;
    const XMLENCNS = "\150\164\x74\160\72\x2f\57\x77\x77\167\56\167\63\56\157\x72\x67\57\x32\60\60\x31\x2f\60\64\x2f\x78\155\x6c\145\156\x63\x23";
    private $encdoc = null;
    private $rawNode = null;
    public $type = null;
    public $encKey = null;
    private $references = array();
    public function __construct()
    {
        $this->_resetTemplate();
    }
    private function _resetTemplate()
    {
        $this->encdoc = new DOMDocument();
        $this->encdoc->loadXML(self::template);
    }
    public function addReference($BT, $m8, $Si)
    {
        if ($m8 instanceof DOMNode) {
            goto Jg;
        }
        throw new Exception("\x24\x6e\157\144\145\40\151\163\40\x6e\x6f\164\40\157\x66\40\164\171\x70\145\40\x44\x4f\115\116\157\x64\145");
        Jg:
        $Pk = $this->encdoc;
        $this->_resetTemplate();
        $TN = $this->encdoc;
        $this->encdoc = $Pk;
        $J9 = XMLSecurityDSig::generateGUID();
        $GN = $TN->documentElement;
        $GN->setAttribute("\111\144", $J9);
        $this->references[$BT] = array("\156\x6f\x64\x65" => $m8, "\x74\171\160\145" => $Si, "\x65\156\143\156\157\x64\145" => $TN, "\162\145\x66\165\x72\x69" => $J9);
    }
    public function setNode($m8)
    {
        $this->rawNode = $m8;
    }
    public function encryptNode($RX, $pM = true)
    {
        $wN = '';
        if (!empty($this->rawNode)) {
            goto AB;
        }
        throw new Exception("\116\157\144\x65\40\x74\x6f\40\145\x6e\143\162\171\160\164\x20\x68\141\x73\40\x6e\x6f\x74\40\142\x65\x65\x6e\40\163\x65\164");
        AB:
        if ($RX instanceof XMLSecurityKey) {
            goto e5;
        }
        throw new Exception("\x49\156\166\x61\x6c\151\144\x20\x4b\x65\x79");
        e5:
        $gQ = $this->rawNode->ownerDocument;
        $cq = new DOMXPath($this->encdoc);
        $Vb = $cq->query("\57\170\145\x6e\143\x3a\105\x6e\143\162\171\160\164\x65\144\x44\141\164\x61\x2f\x78\145\x6e\x63\x3a\x43\x69\x70\x68\145\162\104\x61\164\141\57\x78\x65\x6e\143\x3a\x43\151\x70\150\x65\162\x56\141\154\x75\145");
        $po = $Vb->item(0);
        if (!($po == null)) {
            goto gv;
        }
        throw new Exception("\105\x72\x72\x6f\162\x20\154\157\x63\x61\164\151\156\147\x20\x43\151\x70\150\145\162\x56\x61\x6c\x75\x65\40\x65\x6c\x65\x6d\x65\156\x74\40\x77\x69\x74\x68\x69\156\40\164\x65\155\160\x6c\141\164\x65");
        gv:
        switch ($this->type) {
            case self::Element:
                $wN = $gQ->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute("\124\171\160\x65", self::Element);
                goto I_;
            case self::Content:
                $VU = $this->rawNode->childNodes;
                foreach ($VU as $m9) {
                    $wN .= $gQ->saveXML($m9);
                    R4:
                }
                Kl:
                $this->encdoc->documentElement->setAttribute("\124\171\x70\x65", self::Content);
                goto I_;
            default:
                throw new Exception("\124\171\x70\145\x20\x69\x73\40\143\x75\162\162\x65\x6e\x74\x6c\x79\x20\x6e\x6f\164\40\x73\x75\x70\160\x6f\162\164\145\144");
        }
        gC:
        I_:
        $nX = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\145\156\x63\x3a\105\156\x63\x72\x79\160\164\x69\157\156\115\145\164\x68\x6f\x64"));
        $nX->setAttribute("\x41\x6c\147\157\162\151\x74\150\x6d", $RX->getAlgorithm());
        $po->parentNode->parentNode->insertBefore($nX, $po->parentNode->parentNode->firstChild);
        $K1 = base64_encode($RX->encryptData($wN));
        $T5 = $this->encdoc->createTextNode($K1);
        $po->appendChild($T5);
        if ($pM) {
            goto Pr;
        }
        return $this->encdoc->documentElement;
        goto kU;
        Pr:
        switch ($this->type) {
            case self::Element:
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto aW;
                }
                return $this->encdoc;
                aW:
                $di = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($di, $this->rawNode);
                return $di;
            case self::Content:
                $di = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                k5:
                if (!$this->rawNode->firstChild) {
                    goto Jm;
                }
                $this->rawNode->removeChild($this->rawNode->firstChild);
                goto k5;
                Jm:
                $this->rawNode->appendChild($di);
                return $di;
        }
        br:
        pb:
        kU:
    }
    public function encryptReferences($RX)
    {
        $tm = $this->rawNode;
        $u8 = $this->type;
        foreach ($this->references as $BT => $dS) {
            $this->encdoc = $dS["\145\x6e\x63\156\x6f\144\145"];
            $this->rawNode = $dS["\x6e\x6f\x64\145"];
            $this->type = $dS["\164\x79\x70\145"];
            try {
                $PZ = $this->encryptNode($RX);
                $this->references[$BT]["\145\156\143\x6e\157\144\145"] = $PZ;
            } catch (Exception $aW) {
                $this->rawNode = $tm;
                $this->type = $u8;
                throw $aW;
            }
            om:
        }
        LF:
        $this->rawNode = $tm;
        $this->type = $u8;
    }
    public function getCipherValue()
    {
        if (!empty($this->rawNode)) {
            goto Ha;
        }
        throw new Exception("\116\157\144\x65\40\x74\x6f\40\144\145\x63\x72\171\160\x74\40\x68\141\163\x20\x6e\x6f\x74\x20\x62\x65\145\156\40\163\145\x74");
        Ha:
        $gQ = $this->rawNode->ownerDocument;
        $cq = new DOMXPath($gQ);
        $cq->registerNamespace("\x78\155\154\x65\156\x63\x72", self::XMLENCNS);
        $p4 = "\x2e\57\170\x6d\154\145\156\x63\162\72\103\x69\160\x68\x65\162\104\141\164\141\x2f\x78\155\x6c\x65\x6e\x63\162\x3a\103\151\160\150\x65\x72\x56\x61\154\x75\x65";
        $WI = $cq->query($p4, $this->rawNode);
        $m8 = $WI->item(0);
        if ($m8) {
            goto YR;
        }
        return null;
        YR:
        return base64_decode($m8->nodeValue);
    }
    public function decryptNode($RX, $pM = true)
    {
        if ($RX instanceof XMLSecurityKey) {
            goto G8;
        }
        throw new Exception("\x49\x6e\x76\x61\x6c\x69\x64\x20\x4b\145\171");
        G8:
        $vs = $this->getCipherValue();
        if ($vs) {
            goto kf;
        }
        throw new Exception("\103\141\x6e\x6e\157\164\40\154\157\x63\141\164\x65\x20\x65\156\x63\x72\171\160\x74\145\144\40\x64\141\164\141");
        goto Bv;
        kf:
        $cN = $RX->decryptData($vs);
        if ($pM) {
            goto Wo;
        }
        return $cN;
        goto Vr;
        Wo:
        switch ($this->type) {
            case self::Element:
                $EA = new DOMDocument();
                $EA->loadXML($cN);
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto ij;
                }
                return $EA;
                ij:
                $di = $this->rawNode->ownerDocument->importNode($EA->documentElement, true);
                $this->rawNode->parentNode->replaceChild($di, $this->rawNode);
                return $di;
            case self::Content:
                if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                    goto M6;
                }
                $gQ = $this->rawNode->ownerDocument;
                goto dW;
                M6:
                $gQ = $this->rawNode;
                dW:
                $Ao = $gQ->createDocumentFragment();
                $Ao->appendXML($cN);
                $zy = $this->rawNode->parentNode;
                $zy->replaceChild($Ao, $this->rawNode);
                return $zy;
            default:
                return $cN;
        }
        Xh:
        pM:
        Vr:
        Bv:
    }
    public function encryptKey($nZ, $FH, $ck = true)
    {
        if (!(!$nZ instanceof XMLSecurityKey || !$FH instanceof XMLSecurityKey)) {
            goto XD;
        }
        throw new Exception("\111\156\166\x61\154\151\144\x20\x4b\145\x79");
        XD:
        $a8 = base64_encode($nZ->encryptData($FH->key));
        $WB = $this->encdoc->documentElement;
        $CV = $this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\143\72\105\x6e\x63\162\171\160\x74\x65\x64\113\x65\x79");
        if ($ck) {
            goto RQ;
        }
        $this->encKey = $CV;
        goto mr;
        RQ:
        $Gn = $WB->insertBefore($this->encdoc->createElementNS("\150\x74\164\160\x3a\x2f\x2f\167\167\x77\x2e\167\63\56\x6f\x72\x67\57\62\60\60\x30\57\60\71\x2f\170\x6d\154\144\163\x69\x67\x23", "\144\163\151\x67\x3a\113\145\171\x49\x6e\146\x6f"), $WB->firstChild);
        $Gn->appendChild($CV);
        mr:
        $nX = $CV->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\145\x6e\143\x3a\x45\156\143\162\x79\160\164\x69\157\x6e\x4d\x65\164\150\x6f\x64"));
        $nX->setAttribute("\x41\x6c\147\157\x72\x69\164\150\155", $nZ->getAlgorith());
        if (empty($nZ->name)) {
            goto ub;
        }
        $Gn = $CV->appendChild($this->encdoc->createElementNS("\150\x74\x74\x70\x3a\57\x2f\x77\167\167\56\x77\x33\56\x6f\162\147\57\x32\x30\60\60\x2f\60\x39\x2f\x78\x6d\154\144\x73\x69\147\43", "\144\x73\151\x67\72\x4b\145\x79\x49\156\x66\157"));
        $Gn->appendChild($this->encdoc->createElementNS("\x68\x74\164\160\x3a\x2f\57\167\167\167\56\x77\63\56\157\x72\147\x2f\62\x30\x30\60\x2f\x30\71\57\x78\x6d\x6c\144\x73\x69\147\43", "\144\163\x69\x67\x3a\x4b\145\x79\x4e\141\x6d\145", $nZ->name));
        ub:
        $br = $CV->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\156\143\x3a\103\151\160\x68\x65\162\x44\141\x74\141"));
        $br->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\156\143\72\103\151\160\150\145\x72\x56\141\154\x75\x65", $a8));
        if (!(is_array($this->references) && count($this->references) > 0)) {
            goto Dt;
        }
        $ye = $CV->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\x3a\122\145\x66\145\x72\x65\156\x63\145\114\x69\163\x74"));
        foreach ($this->references as $BT => $dS) {
            $J9 = $dS["\x72\x65\146\165\x72\x69"];
            $u1 = $ye->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\143\72\104\x61\164\141\x52\145\146\145\162\x65\x6e\143\x65"));
            $u1->setAttribute("\x55\122\111", "\43" . $J9);
            o6:
        }
        FI:
        Dt:
        return;
    }
    public function decryptKey($CV)
    {
        if ($CV->isEncrypted) {
            goto xq;
        }
        throw new Exception("\113\145\171\x20\x69\x73\40\156\157\x74\40\105\156\143\162\171\160\x74\x65\144");
        xq:
        if (!empty($CV->key)) {
            goto O8;
        }
        throw new Exception("\x4b\145\x79\x20\x69\x73\x20\x6d\x69\x73\x73\151\x6e\147\40\x64\x61\164\141\40\x74\157\x20\160\145\162\146\157\162\155\40\x74\x68\x65\40\144\x65\143\162\x79\x70\x74\x69\x6f\156");
        O8:
        return $this->decryptNode($CV, false);
    }
    public function locateEncryptedData($GN)
    {
        if ($GN instanceof DOMDocument) {
            goto oo;
        }
        $gQ = $GN->ownerDocument;
        goto c7;
        oo:
        $gQ = $GN;
        c7:
        if (!$gQ) {
            goto WM;
        }
        $bg = new DOMXPath($gQ);
        $p4 = "\57\x2f\x2a\133\x6c\x6f\143\141\154\55\x6e\141\155\145\50\51\75\47\105\156\143\162\x79\x70\x74\145\x64\x44\141\x74\x61\47\x20\141\156\144\x20\x6e\141\x6d\x65\163\x70\141\143\x65\x2d\x75\162\151\x28\51\x3d\x27" . self::XMLENCNS . "\x27\135";
        $WI = $bg->query($p4);
        return $WI->item(0);
        WM:
        return null;
    }
    public function locateKey($m8 = null)
    {
        if (!empty($m8)) {
            goto n3;
        }
        $m8 = $this->rawNode;
        n3:
        if ($m8 instanceof DOMNode) {
            goto VX;
        }
        return null;
        VX:
        if (!($gQ = $m8->ownerDocument)) {
            goto yj;
        }
        $bg = new DOMXPath($gQ);
        $bg->registerNamespace("\170\x6d\154\163\145\x63\145\x6e\143", self::XMLENCNS);
        $p4 = "\56\x2f\57\x78\155\154\163\x65\x63\x65\156\143\72\105\x6e\143\x72\171\160\x74\151\157\x6e\x4d\x65\x74\150\x6f\144";
        $WI = $bg->query($p4, $m8);
        if (!($lx = $WI->item(0))) {
            goto xw;
        }
        $mX = $lx->getAttribute("\x41\154\x67\157\x72\x69\164\x68\155");
        try {
            $RX = new XMLSecurityKey($mX, array("\164\171\160\145" => "\x70\x72\x69\166\x61\164\145"));
        } catch (Exception $aW) {
            return null;
        }
        return $RX;
        xw:
        yj:
        return null;
    }
    public static function staticLocateKeyInfo($EN = null, $m8 = null)
    {
        if (!(empty($m8) || !$m8 instanceof DOMNode)) {
            goto XC;
        }
        return null;
        XC:
        $gQ = $m8->ownerDocument;
        if ($gQ) {
            goto ck;
        }
        return null;
        ck:
        $bg = new DOMXPath($gQ);
        $bg->registerNamespace("\x78\x6d\x6c\163\145\143\x65\x6e\143", self::XMLENCNS);
        $bg->registerNamespace("\x78\x6d\154\x73\x65\x63\x64\x73\151\147", XMLSecurityDSig::XMLDSIGNS);
        $p4 = "\56\x2f\x78\155\x6c\163\x65\143\144\163\151\147\72\x4b\x65\x79\x49\x6e\146\157";
        $WI = $bg->query($p4, $m8);
        $lx = $WI->item(0);
        if ($lx) {
            goto EV;
        }
        return $EN;
        EV:
        foreach ($lx->childNodes as $m9) {
            switch ($m9->localName) {
                case "\x4b\x65\171\x4e\141\x6d\145":
                    if (empty($EN)) {
                        goto tw;
                    }
                    $EN->name = $m9->nodeValue;
                    tw:
                    goto ZD;
                case "\x4b\145\x79\x56\141\154\165\x65":
                    foreach ($m9->childNodes as $ti) {
                        switch ($ti->localName) {
                            case "\x44\x53\x41\x4b\145\171\126\x61\154\165\145":
                                throw new Exception("\104\123\101\x4b\145\171\x56\x61\x6c\165\x65\x20\143\165\x72\x72\145\x6e\164\154\171\40\x6e\157\x74\40\x73\165\x70\160\157\x72\x74\x65\144");
                            case "\x52\123\101\x4b\145\x79\x56\x61\154\165\145":
                                $IB = null;
                                $Lq = null;
                                if (!($TE = $ti->getElementsByTagName("\115\157\x64\165\154\165\163")->item(0))) {
                                    goto kT;
                                }
                                $IB = base64_decode($TE->nodeValue);
                                kT:
                                if (!($EK = $ti->getElementsByTagName("\x45\x78\x70\x6f\x6e\x65\x6e\x74")->item(0))) {
                                    goto Gm;
                                }
                                $Lq = base64_decode($EK->nodeValue);
                                Gm:
                                if (!(empty($IB) || empty($Lq))) {
                                    goto f6;
                                }
                                throw new Exception("\x4d\x69\x73\x73\151\156\147\40\115\x6f\144\165\154\x75\163\x20\157\x72\40\x45\x78\x70\x6f\x6e\145\156\x74");
                                f6:
                                $eI = XMLSecurityKey::convertRSA($IB, $Lq);
                                $EN->loadKey($eI);
                                goto Pv;
                        }
                        lt:
                        Pv:
                        gH:
                    }
                    Zu:
                    goto ZD;
                case "\122\145\x74\x72\151\x65\166\141\x6c\115\x65\164\150\157\x64":
                    $Si = $m9->getAttribute("\x54\171\x70\x65");
                    if (!($Si !== "\x68\x74\164\x70\x3a\x2f\x2f\x77\167\x77\x2e\x77\x33\x2e\157\162\147\57\62\60\x30\61\57\x30\x34\57\x78\x6d\x6c\145\156\143\43\105\x6e\x63\162\171\160\164\x65\x64\113\x65\171")) {
                        goto ZV;
                    }
                    goto ZD;
                    ZV:
                    $Sz = $m9->getAttribute("\x55\122\111");
                    if (!($Sz[0] !== "\43")) {
                        goto C1;
                    }
                    goto ZD;
                    C1:
                    $Sh = substr($Sz, 1);
                    $p4 = "\57\57\x78\155\x6c\163\145\x63\x65\x6e\x63\x3a\105\x6e\143\162\171\160\164\x65\144\113\145\x79\133\x40\x49\144\x3d\42" . XPath::filterAttrValue($Sh, XPath::DOUBLE_QUOTE) . "\x22\x5d";
                    $W0 = $bg->query($p4)->item(0);
                    if ($W0) {
                        goto aT;
                    }
                    throw new Exception("\125\156\x61\x62\154\x65\40\164\x6f\40\x6c\x6f\143\141\164\x65\x20\105\156\143\x72\x79\160\164\x65\x64\113\x65\x79\x20\167\x69\x74\150\x20\x40\x49\144\75\x27{$Sh}\x27\x2e");
                    aT:
                    return XMLSecurityKey::fromEncryptedKeyElement($W0);
                case "\105\x6e\143\x72\171\x70\x74\145\x64\x4b\145\171":
                    return XMLSecurityKey::fromEncryptedKeyElement($m9);
                case "\x58\65\60\71\x44\141\164\141":
                    if (!($sd = $m9->getElementsByTagName("\x58\x35\60\x39\x43\145\x72\164\x69\x66\151\143\141\164\145"))) {
                        goto lJ;
                    }
                    if (!($sd->length > 0)) {
                        goto c_;
                    }
                    $db = $sd->item(0)->textContent;
                    $db = str_replace(array("\15", "\12", "\40"), '', $db);
                    $db = "\x2d\x2d\55\55\x2d\x42\105\x47\x49\116\x20\103\x45\122\x54\x49\x46\x49\103\101\124\x45\55\x2d\x2d\x2d\x2d\12" . chunk_split($db, 64, "\xa") . "\x2d\55\55\x2d\x2d\x45\116\104\40\x43\105\x52\x54\111\x46\x49\103\x41\x54\105\x2d\55\55\55\x2d\12";
                    $EN->loadKey($db, false, true);
                    c_:
                    lJ:
                    goto ZD;
            }
            b4:
            ZD:
            ET:
        }
        dX:
        return $EN;
    }
    public function locateKeyInfo($EN = null, $m8 = null)
    {
        if (!empty($m8)) {
            goto rv;
        }
        $m8 = $this->rawNode;
        rv:
        return self::staticLocateKeyInfo($EN, $m8);
    }
}
