<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath as XPath;
class XMLSecEnc
{
    const template = "\74\170\145\x6e\x63\x3a\x45\156\143\162\x79\x70\164\145\x64\104\141\164\x61\40\x78\x6d\x6c\x6e\163\72\x78\145\156\x63\75\47\x68\x74\164\x70\x3a\57\x2f\x77\x77\x77\56\167\x33\56\x6f\162\147\57\x32\60\x30\x31\57\60\64\x2f\x78\155\x6c\145\156\143\x23\x27\x3e\15\xa\40\40\x20\x3c\x78\145\x6e\x63\x3a\x43\x69\160\150\x65\162\104\141\164\141\x3e\15\12\x20\40\40\40\x20\40\x3c\170\x65\156\x63\x3a\x43\x69\160\x68\x65\x72\x56\141\x6c\x75\145\76\74\57\x78\145\156\143\x3a\103\151\x70\x68\x65\162\x56\141\x6c\x75\145\x3e\15\xa\40\x20\40\x3c\x2f\x78\145\x6e\143\72\x43\x69\160\150\x65\162\104\141\x74\141\x3e\15\xa\x3c\57\170\x65\156\143\x3a\105\x6e\x63\162\171\160\164\x65\144\x44\x61\164\x61\x3e";
    const Element = "\150\x74\164\x70\x3a\57\x2f\x77\x77\x77\56\x77\x33\x2e\157\162\x67\57\x32\60\x30\x31\57\x30\x34\x2f\170\155\154\x65\x6e\143\x23\x45\154\145\155\145\x6e\164";
    const Content = "\x68\164\164\160\x3a\57\x2f\167\167\x77\56\x77\63\56\x6f\162\x67\x2f\62\x30\60\x31\x2f\60\x34\57\170\x6d\x6c\x65\x6e\x63\x23\103\157\x6e\x74\145\x6e\164";
    const URI = 3;
    const XMLENCNS = "\x68\x74\x74\160\72\x2f\57\167\x77\x77\x2e\x77\63\56\x6f\162\147\57\62\x30\60\61\57\60\64\57\170\155\x6c\x65\156\143\43";
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
    public function addReference($Ex, $xi, $WK)
    {
        if ($xi instanceof DOMNode) {
            goto zY;
        }
        throw new Exception("\44\156\x6f\144\x65\x20\151\x73\x20\x6e\x6f\164\40\157\x66\x20\x74\171\x70\145\x20\x44\x4f\115\116\x6f\x64\x65");
        zY:
        $Np = $this->encdoc;
        $this->_resetTemplate();
        $GA = $this->encdoc;
        $this->encdoc = $Np;
        $Lo = XMLSecurityDSig::generateGUID();
        $YD = $GA->documentElement;
        $YD->setAttribute("\111\x64", $Lo);
        $this->references[$Ex] = array("\156\157\x64\x65" => $xi, "\x74\x79\160\x65" => $WK, "\x65\x6e\x63\x6e\157\x64\x65" => $GA, "\x72\145\146\165\162\x69" => $Lo);
    }
    public function setNode($xi)
    {
        $this->rawNode = $xi;
    }
    public function encryptNode($zX, $B4 = true)
    {
        $xr = '';
        if (!empty($this->rawNode)) {
            goto MA;
        }
        throw new Exception("\x4e\x6f\144\145\40\164\157\40\x65\x6e\143\162\171\160\164\x20\150\141\x73\40\156\x6f\x74\40\142\x65\145\x6e\x20\x73\x65\x74");
        MA:
        if ($zX instanceof XMLSecurityKey) {
            goto TB;
        }
        throw new Exception("\111\x6e\x76\141\x6c\151\144\x20\x4b\145\x79");
        TB:
        $ta = $this->rawNode->ownerDocument;
        $b5 = new DOMXPath($this->encdoc);
        $Jt = $b5->query("\57\170\x65\156\x63\x3a\x45\156\x63\162\171\x70\x74\x65\x64\104\141\164\x61\57\x78\145\156\x63\x3a\103\x69\x70\150\x65\x72\x44\141\164\x61\57\x78\145\156\143\x3a\x43\x69\160\150\x65\162\x56\141\x6c\165\x65");
        $Hb = $Jt->item(0);
        if (!($Hb == null)) {
            goto ZP;
        }
        throw new Exception("\x45\162\x72\157\x72\x20\x6c\157\143\x61\164\x69\156\x67\40\103\x69\x70\x68\x65\162\126\x61\154\165\x65\x20\x65\x6c\x65\155\x65\x6e\x74\x20\x77\x69\x74\150\151\x6e\x20\164\145\x6d\160\154\x61\164\x65");
        ZP:
        switch ($this->type) {
            case self::Element:
                $xr = $ta->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute("\124\x79\x70\145", self::Element);
                goto it;
            case self::Content:
                $B2 = $this->rawNode->childNodes;
                foreach ($B2 as $dh) {
                    $xr .= $ta->saveXML($dh);
                    K2:
                }
                JT:
                $this->encdoc->documentElement->setAttribute("\124\171\160\x65", self::Content);
                goto it;
            default:
                throw new Exception("\124\x79\160\145\40\x69\x73\x20\x63\x75\x72\162\x65\156\164\154\x79\x20\156\157\x74\40\163\165\x70\160\157\x72\164\145\144");
        }
        xw:
        it:
        $dW = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\x6e\143\x3a\x45\156\143\162\x79\x70\164\151\x6f\x6e\115\145\x74\150\x6f\x64"));
        $dW->setAttribute("\101\x6c\x67\157\162\x69\164\x68\155", $zX->getAlgorithm());
        $Hb->parentNode->parentNode->insertBefore($dW, $Hb->parentNode->parentNode->firstChild);
        $yl = base64_encode($zX->encryptData($xr));
        $Ng = $this->encdoc->createTextNode($yl);
        $Hb->appendChild($Ng);
        if ($B4) {
            goto lg;
        }
        return $this->encdoc->documentElement;
        goto iS;
        lg:
        switch ($this->type) {
            case self::Element:
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto MV;
                }
                return $this->encdoc;
                MV:
                $rx = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($rx, $this->rawNode);
                return $rx;
            case self::Content:
                $rx = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                Rc:
                if (!$this->rawNode->firstChild) {
                    goto NI;
                }
                $this->rawNode->removeChild($this->rawNode->firstChild);
                goto Rc;
                NI:
                $this->rawNode->appendChild($rx);
                return $rx;
        }
        p9:
        NV:
        iS:
    }
    public function encryptReferences($zX)
    {
        $Sw = $this->rawNode;
        $JL = $this->type;
        foreach ($this->references as $Ex => $X8) {
            $this->encdoc = $X8["\145\x6e\143\156\x6f\144\145"];
            $this->rawNode = $X8["\156\x6f\x64\145"];
            $this->type = $X8["\164\171\x70\145"];
            try {
                $eu = $this->encryptNode($zX);
                $this->references[$Ex]["\x65\x6e\x63\x6e\x6f\x64\x65"] = $eu;
            } catch (Exception $Tn) {
                $this->rawNode = $Sw;
                $this->type = $JL;
                throw $Tn;
            }
            ey:
        }
        Aj:
        $this->rawNode = $Sw;
        $this->type = $JL;
    }
    public function getCipherValue()
    {
        if (!empty($this->rawNode)) {
            goto Y_;
        }
        throw new Exception("\116\x6f\x64\145\x20\164\157\x20\144\145\143\x72\x79\x70\x74\x20\150\141\x73\x20\x6e\157\x74\40\x62\145\145\156\x20\163\145\164");
        Y_:
        $ta = $this->rawNode->ownerDocument;
        $b5 = new DOMXPath($ta);
        $b5->registerNamespace("\x78\155\154\x65\x6e\143\162", self::XMLENCNS);
        $FB = "\x2e\x2f\x78\155\154\x65\x6e\x63\x72\x3a\103\x69\160\x68\x65\x72\x44\141\x74\x61\x2f\x78\x6d\154\145\x6e\x63\162\72\103\151\160\x68\x65\x72\x56\141\154\165\x65";
        $KK = $b5->query($FB, $this->rawNode);
        $xi = $KK->item(0);
        if ($xi) {
            goto zL;
        }
        return null;
        zL:
        return base64_decode($xi->nodeValue);
    }
    public function decryptNode($zX, $B4 = true)
    {
        if ($zX instanceof XMLSecurityKey) {
            goto Xn;
        }
        throw new Exception("\x49\x6e\x76\141\154\151\x64\40\113\x65\171");
        Xn:
        $X9 = $this->getCipherValue();
        if ($X9) {
            goto Fo;
        }
        throw new Exception("\103\x61\156\156\x6f\164\x20\x6c\157\143\141\x74\x65\x20\145\x6e\143\162\x79\x70\x74\x65\144\x20\144\x61\164\141");
        goto p0;
        Fo:
        $Xl = $zX->decryptData($X9);
        if ($B4) {
            goto LB;
        }
        return $Xl;
        goto IU;
        LB:
        switch ($this->type) {
            case self::Element:
                $Sc = new DOMDocument();
                $Sc->loadXML($Xl);
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto B1;
                }
                return $Sc;
                B1:
                $rx = $this->rawNode->ownerDocument->importNode($Sc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($rx, $this->rawNode);
                return $rx;
            case self::Content:
                if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                    goto eC;
                }
                $ta = $this->rawNode->ownerDocument;
                goto xg;
                eC:
                $ta = $this->rawNode;
                xg:
                $Kh = $ta->createDocumentFragment();
                $Kh->appendXML($Xl);
                $mn = $this->rawNode->parentNode;
                $mn->replaceChild($Kh, $this->rawNode);
                return $mn;
            default:
                return $Xl;
        }
        OL:
        vf:
        IU:
        p0:
    }
    public function encryptKey($Y6, $eP, $WX = true)
    {
        if (!(!$Y6 instanceof XMLSecurityKey || !$eP instanceof XMLSecurityKey)) {
            goto N1;
        }
        throw new Exception("\111\x6e\166\141\x6c\x69\x64\40\113\145\171");
        N1:
        $Sk = base64_encode($Y6->encryptData($eP->key));
        $Ii = $this->encdoc->documentElement;
        $rw = $this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\x6e\x63\72\x45\156\x63\162\x79\x70\164\x65\x64\x4b\145\x79");
        if ($WX) {
            goto Fu;
        }
        $this->encKey = $rw;
        goto x_;
        Fu:
        $yF = $Ii->insertBefore($this->encdoc->createElementNS("\x68\164\164\160\x3a\x2f\x2f\167\167\167\56\x77\63\56\x6f\162\x67\x2f\62\x30\60\x30\57\60\x39\57\x78\155\154\144\163\x69\147\43", "\144\163\151\x67\72\113\x65\x79\111\x6e\146\157"), $Ii->firstChild);
        $yF->appendChild($rw);
        x_:
        $dW = $rw->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\x6e\143\72\105\x6e\143\162\x79\160\164\151\157\x6e\115\145\164\150\157\144"));
        $dW->setAttribute("\x41\154\147\157\x72\151\x74\x68\155", $Y6->getAlgorith());
        if (empty($Y6->name)) {
            goto TT;
        }
        $yF = $rw->appendChild($this->encdoc->createElementNS("\x68\164\164\160\72\57\57\167\x77\167\56\167\63\x2e\157\x72\147\x2f\x32\x30\x30\60\57\60\x39\57\170\155\154\144\x73\x69\147\43", "\144\163\151\x67\x3a\113\145\171\111\x6e\146\157"));
        $yF->appendChild($this->encdoc->createElementNS("\150\x74\164\160\72\57\57\167\x77\167\56\x77\63\56\157\162\147\57\62\x30\x30\60\x2f\x30\x39\x2f\x78\x6d\154\x64\163\x69\147\43", "\144\x73\x69\x67\x3a\x4b\x65\171\x4e\x61\x6d\x65", $Y6->name));
        TT:
        $P6 = $rw->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\x63\72\x43\x69\160\x68\145\162\x44\141\164\141"));
        $P6->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\156\x63\72\x43\151\x70\x68\x65\x72\x56\141\154\165\x65", $Sk));
        if (!(is_array($this->references) && count($this->references) > 0)) {
            goto Xb;
        }
        $KF = $rw->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\156\143\72\x52\x65\x66\x65\162\x65\156\x63\x65\x4c\x69\x73\x74"));
        foreach ($this->references as $Ex => $X8) {
            $Lo = $X8["\162\x65\x66\x75\x72\151"];
            $Tf = $KF->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\143\x3a\x44\141\164\141\x52\145\x66\x65\x72\145\x6e\x63\145"));
            $Tf->setAttribute("\125\122\x49", "\43" . $Lo);
            f5:
        }
        AU:
        Xb:
        return;
    }
    public function decryptKey($rw)
    {
        if ($rw->isEncrypted) {
            goto qs;
        }
        throw new Exception("\x4b\x65\171\40\151\163\x20\x6e\157\164\40\x45\156\143\x72\171\x70\164\x65\x64");
        qs:
        if (!empty($rw->key)) {
            goto HM;
        }
        throw new Exception("\113\x65\171\40\151\163\x20\x6d\151\x73\163\x69\156\x67\x20\x64\141\164\x61\40\164\x6f\x20\160\145\x72\x66\157\162\155\40\x74\x68\145\40\144\x65\143\x72\x79\x70\164\151\157\x6e");
        HM:
        return $this->decryptNode($rw, false);
    }
    public function locateEncryptedData($YD)
    {
        if ($YD instanceof DOMDocument) {
            goto Ju;
        }
        $ta = $YD->ownerDocument;
        goto AA;
        Ju:
        $ta = $YD;
        AA:
        if (!$ta) {
            goto v1;
        }
        $P3 = new DOMXPath($ta);
        $FB = "\x2f\57\x2a\x5b\x6c\x6f\143\141\154\55\x6e\x61\155\145\x28\x29\75\47\105\156\143\162\171\160\x74\x65\x64\x44\141\164\x61\47\x20\x61\x6e\144\x20\156\x61\x6d\145\163\x70\x61\143\x65\x2d\x75\162\x69\50\x29\75\47" . self::XMLENCNS . "\47\135";
        $KK = $P3->query($FB);
        return $KK->item(0);
        v1:
        return null;
    }
    public function locateKey($xi = null)
    {
        if (!empty($xi)) {
            goto Xm;
        }
        $xi = $this->rawNode;
        Xm:
        if ($xi instanceof DOMNode) {
            goto Tn;
        }
        return null;
        Tn:
        if (!($ta = $xi->ownerDocument)) {
            goto YT;
        }
        $P3 = new DOMXPath($ta);
        $P3->registerNamespace("\170\x6d\x6c\163\x65\143\x65\x6e\143", self::XMLENCNS);
        $FB = "\x2e\x2f\57\170\x6d\x6c\x73\145\143\x65\x6e\143\x3a\105\x6e\x63\x72\x79\160\164\x69\x6f\156\115\x65\164\150\157\144";
        $KK = $P3->query($FB, $xi);
        if (!($V2 = $KK->item(0))) {
            goto pi;
        }
        $uB = $V2->getAttribute("\x41\154\147\x6f\162\151\x74\150\x6d");
        try {
            $zX = new XMLSecurityKey($uB, array("\x74\171\x70\x65" => "\x70\x72\151\166\141\164\145"));
        } catch (Exception $Tn) {
            return null;
        }
        return $zX;
        pi:
        YT:
        return null;
    }
    public static function staticLocateKeyInfo($aQ = null, $xi = null)
    {
        if (!(empty($xi) || !$xi instanceof DOMNode)) {
            goto yw;
        }
        return null;
        yw:
        $ta = $xi->ownerDocument;
        if ($ta) {
            goto Qt;
        }
        return null;
        Qt:
        $P3 = new DOMXPath($ta);
        $P3->registerNamespace("\170\155\x6c\163\x65\x63\145\156\143", self::XMLENCNS);
        $P3->registerNamespace("\x78\155\x6c\163\145\143\144\163\151\x67", XMLSecurityDSig::XMLDSIGNS);
        $FB = "\x2e\x2f\x78\x6d\x6c\x73\x65\x63\x64\163\x69\x67\x3a\x4b\145\x79\x49\x6e\146\x6f";
        $KK = $P3->query($FB, $xi);
        $V2 = $KK->item(0);
        if ($V2) {
            goto E1;
        }
        return $aQ;
        E1:
        foreach ($V2->childNodes as $dh) {
            switch ($dh->localName) {
                case "\113\x65\171\x4e\141\155\x65":
                    if (empty($aQ)) {
                        goto S7;
                    }
                    $aQ->name = $dh->nodeValue;
                    S7:
                    goto eV;
                case "\x4b\x65\171\126\x61\154\165\x65":
                    foreach ($dh->childNodes as $Ph) {
                        switch ($Ph->localName) {
                            case "\104\123\x41\x4b\x65\x79\126\141\154\x75\145":
                                throw new Exception("\104\x53\x41\x4b\145\171\x56\141\x6c\165\145\40\x63\165\162\x72\x65\156\x74\x6c\x79\x20\x6e\157\x74\40\x73\x75\x70\x70\157\162\x74\x65\144");
                            case "\x52\x53\101\x4b\145\171\126\141\154\165\x65":
                                $uI = null;
                                $LK = null;
                                if (!($Ym = $Ph->getElementsByTagName("\115\157\144\x75\x6c\x75\163")->item(0))) {
                                    goto Gb;
                                }
                                $uI = base64_decode($Ym->nodeValue);
                                Gb:
                                if (!($NX = $Ph->getElementsByTagName("\x45\170\x70\157\156\145\156\x74")->item(0))) {
                                    goto YK;
                                }
                                $LK = base64_decode($NX->nodeValue);
                                YK:
                                if (!(empty($uI) || empty($LK))) {
                                    goto b8;
                                }
                                throw new Exception("\x4d\x69\163\163\x69\156\x67\40\115\157\x64\165\154\x75\163\x20\157\162\x20\105\170\x70\x6f\x6e\145\156\x74");
                                b8:
                                $xs = XMLSecurityKey::convertRSA($uI, $LK);
                                $aQ->loadKey($xs);
                                goto eS;
                        }
                        ma:
                        eS:
                        I8:
                    }
                    DX:
                    goto eV;
                case "\122\145\x74\162\x69\145\x76\x61\154\115\x65\x74\150\157\144":
                    $WK = $dh->getAttribute("\124\x79\160\x65");
                    if (!($WK !== "\x68\164\x74\x70\72\x2f\x2f\x77\x77\x77\x2e\x77\63\x2e\x6f\162\147\x2f\62\60\x30\x31\57\x30\64\57\x78\155\154\x65\156\x63\x23\x45\156\x63\162\x79\x70\164\145\x64\113\145\171")) {
                        goto fk;
                    }
                    goto eV;
                    fk:
                    $av = $dh->getAttribute("\x55\122\111");
                    if (!($av[0] !== "\43")) {
                        goto QJ;
                    }
                    goto eV;
                    QJ:
                    $Vh = substr($av, 1);
                    $FB = "\57\x2f\x78\155\154\163\x65\x63\x65\x6e\x63\72\x45\156\143\x72\x79\x70\x74\x65\144\x4b\145\171\133\x40\x49\x64\x3d\42" . XPath::filterAttrValue($Vh, XPath::DOUBLE_QUOTE) . "\x22\135";
                    $XJ = $P3->query($FB)->item(0);
                    if ($XJ) {
                        goto cV;
                    }
                    throw new Exception("\125\156\x61\x62\154\x65\40\164\x6f\x20\x6c\157\x63\141\x74\x65\40\105\x6e\x63\162\171\160\164\145\144\113\x65\x79\40\x77\x69\164\150\40\100\x49\x64\x3d\47{$Vh}\47\56");
                    cV:
                    return XMLSecurityKey::fromEncryptedKeyElement($XJ);
                case "\105\x6e\143\162\x79\160\x74\x65\x64\113\x65\171":
                    return XMLSecurityKey::fromEncryptedKeyElement($dh);
                case "\130\65\60\x39\104\x61\x74\x61":
                    if (!($DB = $dh->getElementsByTagName("\x58\65\x30\x39\x43\x65\x72\x74\x69\x66\x69\143\141\164\x65"))) {
                        goto LA;
                    }
                    if (!($DB->length > 0)) {
                        goto fH;
                    }
                    $Py = $DB->item(0)->textContent;
                    $Py = str_replace(array("\15", "\12", "\x20"), '', $Py);
                    $Py = "\x2d\x2d\x2d\x2d\x2d\102\x45\107\111\116\x20\103\105\x52\x54\x49\x46\x49\x43\x41\124\105\55\x2d\55\x2d\55\xa" . chunk_split($Py, 64, "\12") . "\x2d\55\55\55\55\x45\x4e\x44\40\x43\105\122\x54\111\x46\x49\x43\x41\x54\105\55\55\55\x2d\55\xa";
                    $aQ->loadKey($Py, false, true);
                    fH:
                    LA:
                    goto eV;
            }
            d1:
            eV:
            kU:
        }
        EU:
        return $aQ;
    }
    public function locateKeyInfo($aQ = null, $xi = null)
    {
        if (!empty($xi)) {
            goto oF;
        }
        $xi = $this->rawNode;
        oF:
        return self::staticLocateKeyInfo($aQ, $xi);
    }
}
