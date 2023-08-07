<?php


include_once "\x55\x74\151\x6c\151\x74\x69\145\x73\56\x70\x68\x70";
include_once "\x78\x6d\154\x73\145\143\154\151\142\163\x2e\x70\150\x70";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class SAML2_Assertion
{
    private $id;
    private $issueInstant;
    private $issuer;
    private $nameId;
    private $encryptedNameId;
    private $encryptedAttribute;
    private $encryptionKey;
    private $notBefore;
    private $notOnOrAfter;
    private $validAudiences;
    private $sessionNotOnOrAfter;
    private $sessionIndex;
    private $authnInstant;
    private $authnContextClassRef;
    private $authnContextDecl;
    private $authnContextDeclRef;
    private $AuthenticatingAuthority;
    private $attributes;
    private $nameFormat;
    private $signatureKey;
    private $certificates;
    private $signatureData;
    private $requiredEncAttributes;
    private $SubjectConfirmation;
    private $privateKeyUrl;
    protected $wasSignedAtConstruction = FALSE;
    public function __construct(DOMElement $DH = NULL, $Af)
    {
        $this->id = Utilities::generateId();
        $this->issueInstant = Utilities::generateTimestamp();
        $this->issuer = '';
        $this->authnInstant = Utilities::generateTimestamp();
        $this->attributes = array();
        $this->nameFormat = "\x75\162\156\x3a\157\141\x73\x69\163\72\156\x61\x6d\x65\163\x3a\x74\x63\x3a\123\101\x4d\114\72\61\56\61\72\156\141\155\x65\151\x64\x2d\x66\157\162\155\x61\164\72\165\x6e\x73\160\x65\x63\151\146\151\x65\x64";
        $this->certificates = array();
        $this->AuthenticatingAuthority = array();
        $this->SubjectConfirmation = array();
        if (!($DH === NULL)) {
            goto z3;
        }
        return;
        z3:
        if (!($DH->localName === "\x45\x6e\x63\x72\x79\x70\164\x65\x64\x41\163\163\x65\162\x74\x69\157\156")) {
            goto A6;
        }
        $wN = Utilities::xpQuery($DH, "\x2e\57\x78\145\x6e\143\72\105\x6e\x63\x72\x79\160\164\145\x64\x44\x61\x74\141");
        $D_ = Utilities::xpQuery($DH, "\56\57\170\x65\x6e\143\x3a\x45\156\x63\x72\x79\160\x74\145\x64\104\141\164\x61\57\144\x73\x3a\113\145\x79\x49\156\x66\x6f\x2f\170\145\156\143\x3a\105\156\x63\162\x79\160\164\x65\x64\113\145\171");
        $Ft = '';
        if (empty($D_)) {
            goto xZ;
        }
        $Ft = $D_[0]->firstChild->getAttribute("\x41\154\147\x6f\x72\151\164\150\155");
        goto Py;
        xZ:
        $D_ = Utilities::xpQuery($DH, "\x2e\x2f\170\x65\x6e\143\72\x45\156\x63\162\171\160\x74\145\x64\113\x65\x79\x2f\x78\x65\156\143\x3a\x45\x6e\x63\162\x79\x70\x74\151\x6f\156\x4d\x65\164\x68\x6f\x64");
        $Ft = $D_[0]->getAttribute("\x41\x6c\x67\x6f\x72\151\x74\x68\155");
        Py:
        $Wd = Utilities::getEncryptionAlgorithm($Ft);
        if (count($wN) === 0) {
            goto s2;
        }
        if (count($wN) > 1) {
            goto qt;
        }
        goto Rf;
        s2:
        throw new Exception("\115\x69\163\x73\151\156\x67\40\x65\156\143\x72\171\x70\164\x65\144\x20\x64\x61\164\141\x20\x69\156\x20\74\x73\141\x6d\x6c\x3a\x45\156\143\x72\171\160\164\145\144\x41\163\x73\x65\162\164\x69\157\x6e\x3e\56");
        goto Rf;
        qt:
        throw new Exception("\115\x6f\x72\145\40\164\x68\141\x6e\x20\157\x6e\145\40\145\156\143\x72\x79\160\x74\x65\144\x20\144\x61\164\141\40\145\x6c\145\x6d\x65\x6e\164\40\x69\156\40\74\163\x61\x6d\x6c\72\x45\156\x63\162\171\160\164\x65\144\101\163\163\145\x72\164\151\157\156\76\56");
        Rf:
        $ez = new XMLSecurityKey($Wd, array("\x74\171\160\145" => "\160\162\151\166\x61\164\x65"));
        $dK = get_site_option("\x6d\x6f\x5f\163\141\x6d\x6c\137\x63\x75\x72\162\x65\156\164\137\143\x65\162\164\x5f\x70\162\x69\x76\x61\x74\145\137\x6b\145\171");
        $ez->loadKey($Af, FALSE);
        $Re = array();
        $DH = Utilities::decryptElement($wN[0], $ez, $Re);
        A6:
        if ($DH->hasAttribute("\111\104")) {
            goto Uy;
        }
        throw new Exception("\x4d\x69\x73\163\x69\x6e\x67\x20\111\104\40\x61\x74\164\x72\151\142\x75\x74\x65\40\157\x6e\40\x53\101\115\114\x20\141\x73\163\x65\x72\164\151\157\156\x2e");
        Uy:
        $this->id = $DH->getAttribute("\x49\104");
        if (!($DH->getAttribute("\x56\x65\162\x73\x69\x6f\156") !== "\x32\56\x30")) {
            goto XY;
        }
        throw new Exception("\125\x6e\163\165\x70\x70\x6f\x72\x74\145\144\40\x76\x65\x72\x73\x69\x6f\156\72\x20" . $DH->getAttribute("\x56\x65\162\x73\151\x6f\x6e"));
        XY:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($DH->getAttribute("\x49\163\163\165\145\x49\x6e\163\x74\141\156\164"));
        $NK = Utilities::xpQuery($DH, "\56\57\163\141\x6d\154\x5f\141\163\x73\145\x72\164\151\x6f\156\72\111\163\163\165\145\162");
        if (!empty($NK)) {
            goto fB;
        }
        throw new Exception("\115\x69\163\x73\151\156\x67\x20\74\163\141\x6d\x6c\x3a\x49\163\163\x75\145\x72\x3e\x20\151\156\40\141\163\163\x65\162\164\x69\157\x6e\56");
        fB:
        $this->issuer = trim($NK[0]->textContent);
        $this->parseConditions($DH);
        $this->parseAuthnStatement($DH);
        $this->parseAttributes($DH);
        $this->parseEncryptedAttributes($DH);
        $this->parseSignature($DH);
        $this->parseSubject($DH);
    }
    private function parseSubject(DOMElement $DH)
    {
        $XQ = Utilities::xpQuery($DH, "\x2e\57\x73\141\x6d\154\x5f\x61\163\x73\x65\162\164\x69\157\x6e\x3a\123\165\x62\x6a\145\x63\164");
        if (empty($XQ)) {
            goto FB;
        }
        if (count($XQ) > 1) {
            goto nm;
        }
        goto fR;
        FB:
        return;
        goto fR;
        nm:
        throw new Exception("\x4d\157\162\145\x20\x74\x68\x61\156\40\157\x6e\145\x20\x3c\163\141\x6d\x6c\72\123\165\142\152\145\x63\x74\76\40\151\x6e\x20\x3c\163\141\155\154\72\x41\163\x73\x65\x72\164\x69\x6f\x6e\76\x2e");
        fR:
        $XQ = $XQ[0];
        $k9 = Utilities::xpQuery($XQ, "\56\x2f\x73\x61\x6d\x6c\x5f\141\x73\x73\145\162\x74\x69\x6f\x6e\x3a\x4e\141\155\x65\111\x44\x20\x7c\x20\x2e\x2f\x73\x61\x6d\x6c\137\x61\x73\x73\145\x72\x74\151\157\x6e\x3a\105\156\x63\x72\171\160\x74\x65\144\111\104\57\x78\x65\156\x63\x3a\x45\x6e\x63\x72\171\x70\x74\x65\x64\104\x61\164\141");
        if (empty($k9)) {
            goto ko;
        }
        if (count($k9) > 1) {
            goto hV;
        }
        goto n1;
        ko:
        if ($_POST["\122\145\154\141\x79\123\164\141\164\145"] == "\x74\145\x73\x74\x56\141\154\x69\x64\141\x74\145" or $_POST["\x52\145\154\141\x79\x53\164\x61\164\x65"] == "\164\x65\x73\x74\116\145\x77\103\x65\x72\164\151\x66\151\x63\141\x74\x65") {
            goto XI;
        }
        wp_die("\x57\145\x20\x63\157\x75\154\x64\40\156\x6f\x74\x20\163\151\x67\156\40\x79\x6f\165\40\151\156\56\40\120\154\x65\x61\163\x65\x20\143\x6f\x6e\x74\x61\x63\164\40\x79\x6f\x75\x72\40\x61\x64\155\x69\x6e\x69\x73\164\x72\141\x74\x6f\162");
        goto t4;
        XI:
        echo "\x3c\x64\151\x76\40\x73\x74\171\x6c\x65\75\x22\x66\x6f\156\164\55\x66\141\x6d\151\154\x79\72\x43\x61\x6c\151\x62\162\x69\73\x70\x61\x64\144\151\156\147\72\60\40\63\x25\x3b\42\76";
        echo "\74\144\x69\x76\x20\x73\164\x79\x6c\145\75\42\143\157\x6c\x6f\x72\72\40\x23\141\71\x34\x34\64\x32\73\x62\141\x63\x6b\147\162\x6f\x75\x6e\x64\x2d\143\157\x6c\157\162\x3a\40\43\146\62\x64\x65\144\x65\73\x70\141\144\144\x69\x6e\147\72\40\x31\65\x70\x78\73\x6d\x61\x72\x67\151\x6e\55\142\x6f\164\x74\157\155\x3a\40\x32\60\160\x78\x3b\x74\145\x78\x74\x2d\141\x6c\151\147\156\72\143\x65\156\164\145\x72\73\x62\157\x72\x64\145\162\72\x31\x70\170\40\x73\x6f\x6c\x69\x64\x20\x23\105\66\102\x33\102\62\73\x66\x6f\156\x74\x2d\163\x69\172\145\x3a\61\x38\160\164\73\42\76\x20\105\x52\122\x4f\122\x3c\x2f\x64\151\166\x3e\15\xa\40\40\x20\40\40\40\x20\40\40\40\x20\x3c\144\151\x76\40\163\x74\x79\154\145\75\x22\x63\157\x6c\157\x72\x3a\40\x23\x61\71\x34\x34\64\x32\73\146\157\156\164\55\163\x69\172\145\72\x31\x34\160\164\x3b\40\x6d\x61\x72\x67\151\156\55\142\157\164\x74\x6f\155\x3a\x32\60\160\x78\73\42\x3e\x3c\160\x3e\74\163\164\162\x6f\156\147\x3e\x45\x72\x72\x6f\162\x3a\x20\74\57\x73\x74\x72\157\x6e\x67\76\x4d\x69\163\x73\x69\156\147\40\40\116\x61\x6d\x65\111\104\x20\x6f\162\40\x45\156\143\x72\171\x70\x74\x65\x64\111\x44\x20\x69\x6e\x20\123\x41\115\x4c\x20\122\145\x73\x70\x6f\156\163\x65\74\x2f\160\76\xd\12\x20\x20\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\40\x20\74\x70\76\120\x6c\x65\x61\x73\x65\x20\x63\157\156\164\141\x63\164\x20\171\157\165\162\40\x61\144\155\151\156\x69\x73\164\x72\141\x74\157\162\x20\x61\156\144\x20\x72\145\x70\157\162\x74\x20\x74\150\145\x20\x66\x6f\x6c\154\157\x77\x69\156\147\x20\x65\162\x72\157\x72\72\74\x2f\160\x3e\xd\xa\40\x20\x20\x20\40\40\40\40\40\x20\x20\40\40\x20\x20\x20\x3c\160\x3e\x3c\x73\164\x72\157\x6e\x67\x3e\x50\x6f\163\163\x69\x62\154\145\40\103\x61\165\163\145\x3a\74\57\163\x74\x72\157\x6e\147\76\x20\116\141\x6d\145\111\x44\40\156\x6f\x74\x20\146\157\x75\156\x64\40\x69\156\x20\x53\x41\x4d\114\40\x52\145\163\160\157\x6e\x73\145\40\x73\165\x62\x6a\145\x63\x74\x3c\x2f\x70\76\xd\xa\x20\40\40\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\40\x3c\57\144\151\166\76\15\12\x20\x20\x20\40\40\x20\40\40\40\40\x20\40\x20\40\40\40\74\144\x69\x76\x20\163\x74\171\x6c\x65\75\42\x6d\x61\162\x67\x69\x6e\x3a\63\45\73\144\151\x73\160\x6c\141\x79\72\x62\154\x6f\x63\153\x3b\x74\x65\x78\x74\55\x61\154\151\x67\x6e\72\x63\145\156\x74\x65\x72\x3b\x22\76\xd\xa\40\x20\x20\x20\x20\40\x20\40\40\40\x20\x20\40\x20\x20\x20\74\x64\x69\x76\40\x73\164\171\x6c\x65\75\42\155\x61\x72\147\x69\156\72\63\x25\x3b\144\x69\x73\x70\x6c\x61\171\72\142\x6c\157\143\x6b\x3b\x74\x65\x78\x74\x2d\x61\154\151\x67\156\x3a\x63\x65\x6e\164\x65\x72\x3b\x22\x3e\x3c\151\x6e\x70\x75\164\40\163\x74\x79\154\145\75\42\160\141\x64\x64\x69\x6e\x67\72\61\x25\73\x77\151\144\x74\150\72\x31\x30\60\160\x78\73\142\x61\x63\153\x67\x72\x6f\165\156\144\72\40\43\x30\x30\71\x31\103\104\40\x6e\x6f\156\x65\x20\162\x65\x70\x65\141\164\40\163\143\x72\157\154\x6c\40\x30\x25\x20\60\45\73\x63\165\162\x73\x6f\x72\x3a\x20\160\x6f\x69\156\164\x65\162\x3b\146\157\156\x74\55\163\x69\172\145\x3a\x31\65\160\x78\x3b\x62\157\x72\x64\x65\x72\55\167\x69\x64\x74\150\72\40\x31\160\x78\x3b\142\157\x72\x64\145\x72\55\163\164\x79\154\145\72\40\163\x6f\154\151\144\x3b\142\x6f\x72\x64\145\x72\x2d\x72\x61\x64\x69\x75\x73\x3a\40\63\x70\170\x3b\167\150\x69\164\145\55\163\160\141\143\x65\x3a\40\x6e\157\167\x72\141\x70\73\142\x6f\x78\55\163\151\x7a\x69\156\147\x3a\40\142\x6f\162\x64\x65\162\x2d\x62\157\170\73\x62\x6f\162\x64\145\x72\55\x63\157\x6c\157\162\x3a\40\x23\x30\60\x37\x33\101\101\x3b\142\x6f\170\55\163\x68\141\x64\x6f\x77\72\40\60\160\170\x20\61\x70\170\x20\60\x70\x78\x20\x72\x67\x62\x61\50\x31\x32\60\x2c\40\62\x30\x30\54\x20\62\63\60\x2c\40\x30\x2e\x36\51\40\151\x6e\163\x65\x74\73\143\x6f\x6c\x6f\x72\72\x20\43\106\x46\106\73\42\164\x79\x70\x65\x3d\x22\142\165\164\164\157\156\x22\40\x76\x61\154\165\145\x3d\42\104\x6f\156\145\x22\x20\x6f\x6e\x43\154\151\143\x6b\x3d\x22\x73\145\x6c\x66\56\143\154\x6f\x73\145\x28\x29\x3b\x22\76\x3c\57\144\151\x76\x3e";
        exit;
        t4:
        goto n1;
        hV:
        throw new Exception("\115\157\162\145\x20\x74\x68\x61\156\40\x6f\x6e\145\x20\x3c\163\141\155\x6c\72\116\x61\x6d\x65\x49\104\x3e\40\157\x72\x20\74\163\x61\155\154\x3a\105\x6e\143\x72\171\160\164\x65\144\104\x3e\40\151\x6e\40\x3c\163\141\x6d\154\72\123\165\x62\152\145\x63\x74\76\x2e");
        n1:
        $k9 = $k9[0];
        if ($k9->localName === "\105\x6e\x63\162\x79\x70\x74\x65\144\104\x61\x74\141") {
            goto mI;
        }
        $this->nameId = Utilities::parseNameId($k9);
        goto p6;
        mI:
        $this->encryptedNameId = $k9;
        p6:
    }
    private function parseConditions(DOMElement $DH)
    {
        $De = Utilities::xpQuery($DH, "\56\x2f\x73\141\x6d\154\137\141\163\163\145\x72\x74\x69\x6f\x6e\x3a\103\157\x6e\x64\151\x74\x69\157\x6e\163");
        if (empty($De)) {
            goto lX;
        }
        if (count($De) > 1) {
            goto J4;
        }
        goto HE;
        lX:
        return;
        goto HE;
        J4:
        throw new Exception("\x4d\157\x72\145\40\x74\x68\x61\x6e\40\x6f\x6e\x65\40\x3c\163\141\x6d\154\x3a\x43\x6f\x6e\144\x69\x74\151\x6f\156\x73\x3e\x20\151\156\x20\x3c\163\141\x6d\154\72\x41\x73\163\145\x72\164\151\x6f\156\x3e\56");
        HE:
        $De = $De[0];
        if (!$De->hasAttribute("\x4e\157\x74\102\145\146\157\162\x65")) {
            goto tt;
        }
        $OE = Utilities::xsDateTimeToTimestamp($De->getAttribute("\x4e\x6f\x74\102\145\146\157\162\x65"));
        if (!($this->notBefore === NULL || $this->notBefore < $OE)) {
            goto wH;
        }
        $this->notBefore = $OE;
        wH:
        tt:
        if (!$De->hasAttribute("\x4e\157\x74\x4f\156\117\x72\x41\146\x74\145\x72")) {
            goto P5;
        }
        $Xh = Utilities::xsDateTimeToTimestamp($De->getAttribute("\116\157\x74\x4f\x6e\x4f\162\101\x66\164\145\x72"));
        if (!($this->notOnOrAfter === NULL || $this->notOnOrAfter > $Xh)) {
            goto qh;
        }
        $this->notOnOrAfter = $Xh;
        qh:
        P5:
        $m8 = $De->firstChild;
        Zv:
        if (!($m8 !== NULL)) {
            goto D5;
        }
        if (!$m8 instanceof DOMText) {
            goto f2;
        }
        goto oN;
        f2:
        if (!($m8->namespaceURI !== "\x75\162\156\72\x6f\x61\163\151\163\x3a\x6e\x61\155\145\x73\x3a\x74\x63\x3a\x53\x41\115\x4c\x3a\x32\56\60\72\x61\163\163\145\x72\x74\151\x6f\x6e")) {
            goto E8;
        }
        throw new Exception("\x55\x6e\x6b\156\x6f\x77\156\40\x6e\141\155\145\x73\160\x61\x63\145\x20\x6f\x66\40\x63\x6f\156\x64\151\x74\151\157\x6e\72\x20" . var_export($m8->namespaceURI, TRUE));
        E8:
        switch ($m8->localName) {
            case "\101\x75\144\x69\x65\156\x63\145\x52\145\163\x74\162\151\143\164\151\x6f\x6e":
                $hG = Utilities::extractStrings($m8, "\165\162\x6e\x3a\157\x61\163\x69\163\x3a\156\x61\x6d\x65\163\x3a\164\143\x3a\123\x41\x4d\x4c\x3a\62\x2e\x30\x3a\x61\x73\x73\x65\162\164\x69\x6f\156", "\101\x75\144\151\x65\156\143\145");
                if ($this->validAudiences === NULL) {
                    goto Xs;
                }
                $this->validAudiences = array_intersect($this->validAudiences, $hG);
                goto KR;
                Xs:
                $this->validAudiences = $hG;
                KR:
                goto pz;
            case "\x4f\x6e\145\x54\151\x6d\145\125\163\145":
                goto pz;
            case "\120\162\157\x78\x79\x52\x65\x73\164\162\151\143\x74\151\157\x6e":
                goto pz;
            default:
                throw new Exception("\125\156\x6b\x6e\x6f\x77\x6e\x20\x63\157\156\144\151\x74\151\x6f\x6e\72\x20" . var_export($m8->localName, TRUE));
        }
        jX:
        pz:
        oN:
        $m8 = $m8->nextSibling;
        goto Zv;
        D5:
    }
    private function parseAuthnStatement(DOMElement $DH)
    {
        $yD = Utilities::xpQuery($DH, "\56\x2f\x73\x61\x6d\x6c\x5f\141\x73\x73\145\x72\164\151\x6f\x6e\x3a\x41\165\164\150\x6e\123\164\141\164\145\155\145\156\164");
        if (empty($yD)) {
            goto lh;
        }
        if (count($yD) > 1) {
            goto qK;
        }
        goto ZF;
        lh:
        $this->authnInstant = NULL;
        return;
        goto ZF;
        qK:
        throw new Exception("\115\157\162\x65\x20\164\x68\141\x74\40\x6f\x6e\145\x20\74\163\x61\x6d\x6c\x3a\x41\165\x74\x68\x6e\x53\164\141\x74\145\155\145\156\x74\76\x20\151\156\40\x3c\x73\x61\155\154\x3a\101\x73\163\x65\x72\x74\x69\157\156\x3e\40\x6e\x6f\x74\40\x73\x75\x70\x70\x6f\x72\164\145\x64\56");
        ZF:
        $r4 = $yD[0];
        if ($r4->hasAttribute("\101\165\164\x68\156\x49\x6e\x73\x74\x61\156\x74")) {
            goto k_;
        }
        throw new Exception("\x4d\x69\x73\x73\x69\156\x67\x20\x72\x65\161\x75\x69\162\145\144\x20\101\x75\164\150\156\111\156\163\164\x61\x6e\164\40\x61\x74\x74\x72\151\x62\165\x74\x65\x20\157\156\40\x3c\x73\x61\x6d\x6c\x3a\101\165\164\x68\x6e\x53\164\141\164\145\155\145\x6e\164\x3e\56");
        k_:
        $this->authnInstant = Utilities::xsDateTimeToTimestamp($r4->getAttribute("\x41\165\x74\150\x6e\x49\156\x73\164\141\x6e\x74"));
        if (!$r4->hasAttribute("\123\x65\x73\163\x69\157\x6e\x4e\157\164\117\156\117\162\x41\x66\164\145\162")) {
            goto Om;
        }
        $this->sessionNotOnOrAfter = Utilities::xsDateTimeToTimestamp($r4->getAttribute("\x53\145\163\x73\x69\157\x6e\116\157\x74\x4f\x6e\117\x72\x41\x66\164\x65\x72"));
        Om:
        if (!$r4->hasAttribute("\x53\145\x73\163\x69\157\156\x49\156\x64\145\170")) {
            goto su;
        }
        $this->sessionIndex = $r4->getAttribute("\x53\145\x73\x73\x69\157\x6e\x49\x6e\x64\145\x78");
        su:
        $this->parseAuthnContext($r4);
    }
    private function parseAuthnContext(DOMElement $by)
    {
        $qE = Utilities::xpQuery($by, "\56\x2f\163\141\155\154\x5f\141\163\163\x65\162\164\151\x6f\156\72\101\165\x74\150\x6e\x43\157\x6e\164\x65\170\164");
        if (count($qE) > 1) {
            goto KY;
        }
        if (empty($qE)) {
            goto f8;
        }
        goto dc;
        KY:
        throw new Exception("\115\157\x72\145\x20\x74\150\141\156\x20\157\156\x65\x20\x3c\163\x61\155\154\72\x41\165\x74\x68\156\103\x6f\x6e\164\x65\170\x74\x3e\40\151\x6e\x20\x3c\163\141\x6d\154\x3a\x41\x75\164\x68\x6e\x53\164\141\x74\145\155\x65\x6e\164\76\x2e");
        goto dc;
        f8:
        throw new Exception("\115\151\163\163\x69\x6e\x67\x20\x72\145\161\x75\151\162\x65\144\40\x3c\163\141\155\154\x3a\x41\x75\x74\150\x6e\103\x6f\156\164\x65\170\x74\x3e\40\151\156\x20\x3c\x73\141\x6d\x6c\72\x41\x75\x74\x68\x6e\123\164\x61\164\145\x6d\145\x6e\164\76\56");
        dc:
        $Tl = $qE[0];
        $f8 = Utilities::xpQuery($Tl, "\x2e\57\x73\141\155\154\x5f\141\163\163\x65\162\x74\x69\x6f\156\x3a\101\x75\x74\x68\156\x43\x6f\x6e\164\145\x78\x74\104\145\143\154\x52\145\146");
        if (count($f8) > 1) {
            goto Bq;
        }
        if (count($f8) === 1) {
            goto lq;
        }
        goto Dq;
        Bq:
        throw new Exception("\x4d\x6f\x72\145\x20\x74\x68\x61\156\40\x6f\156\145\x20\x3c\163\x61\x6d\154\72\x41\165\x74\x68\156\103\157\156\x74\145\170\164\104\145\143\154\x52\x65\146\76\x20\146\x6f\x75\x6e\x64\77");
        goto Dq;
        lq:
        $this->setAuthnContextDeclRef(trim($f8[0]->textContent));
        Dq:
        $Ia = Utilities::xpQuery($Tl, "\56\x2f\x73\141\x6d\x6c\137\141\x73\x73\145\x72\164\151\157\x6e\72\x41\165\164\150\x6e\103\157\156\x74\x65\170\x74\x44\145\143\154");
        if (count($Ia) > 1) {
            goto HZ;
        }
        if (count($Ia) === 1) {
            goto IZ;
        }
        goto xr;
        HZ:
        throw new Exception("\x4d\157\162\145\40\x74\x68\141\156\x20\157\x6e\145\x20\x3c\x73\141\155\154\72\x41\165\164\x68\x6e\x43\157\156\164\x65\170\x74\104\x65\x63\x6c\x3e\x20\x66\x6f\165\156\144\77");
        goto xr;
        IZ:
        $this->setAuthnContextDecl(new SAML2_XML_Chunk($Ia[0]));
        xr:
        $KQ = Utilities::xpQuery($Tl, "\56\57\x73\x61\155\154\137\x61\163\163\145\x72\x74\x69\x6f\156\x3a\x41\x75\x74\x68\x6e\x43\x6f\x6e\x74\145\170\164\x43\154\x61\163\163\122\145\146");
        if (count($KQ) > 1) {
            goto xz;
        }
        if (count($KQ) === 1) {
            goto Ca;
        }
        goto UY;
        xz:
        throw new Exception("\x4d\157\162\145\40\x74\150\x61\156\40\157\156\x65\40\74\x73\141\155\x6c\72\x41\x75\x74\x68\156\103\x6f\x6e\x74\x65\170\x74\x43\x6c\141\163\163\122\x65\x66\76\x20\x69\x6e\40\74\x73\141\155\x6c\x3a\x41\165\164\x68\156\103\x6f\156\x74\x65\x78\x74\76\56");
        goto UY;
        Ca:
        $this->setAuthnContextClassRef(trim($KQ[0]->textContent));
        UY:
        if (!(empty($this->authnContextClassRef) && empty($this->authnContextDecl) && empty($this->authnContextDeclRef))) {
            goto zG;
        }
        throw new Exception("\x4d\151\163\x73\151\x6e\147\x20\145\x69\164\x68\x65\x72\40\x3c\163\141\x6d\x6c\72\101\x75\164\150\x6e\x43\x6f\x6e\x74\145\170\x74\103\x6c\141\x73\x73\122\145\x66\76\40\x6f\162\x20\74\163\x61\155\x6c\72\x41\x75\x74\150\x6e\x43\157\156\x74\x65\x78\x74\104\x65\143\154\122\x65\146\x3e\40\157\x72\40\x3c\x73\x61\x6d\x6c\x3a\x41\x75\164\x68\x6e\103\157\156\164\x65\170\164\x44\145\143\154\76");
        zG:
        $this->AuthenticatingAuthority = Utilities::extractStrings($Tl, "\165\162\156\72\157\x61\x73\x69\x73\72\156\141\x6d\x65\x73\72\x74\x63\72\123\101\115\x4c\x3a\x32\56\60\x3a\141\163\x73\x65\x72\164\x69\157\x6e", "\x41\165\x74\x68\x65\x6e\164\151\143\x61\164\151\x6e\x67\101\165\x74\150\x6f\162\x69\164\x79");
    }
    private function parseAttributes(DOMElement $DH)
    {
        $ow = TRUE;
        $l0 = Utilities::xpQuery($DH, "\x2e\57\x73\x61\155\x6c\x5f\x61\x73\163\145\x72\x74\x69\x6f\x6e\72\x41\x74\x74\162\151\142\x75\164\x65\123\164\x61\x74\145\155\x65\x6e\x74\x2f\x73\141\155\x6c\x5f\141\163\163\145\x72\x74\x69\157\x6e\72\x41\164\164\x72\151\142\165\x74\x65");
        foreach ($l0 as $ma) {
            if ($ma->hasAttribute("\116\141\155\x65")) {
                goto Zt;
            }
            throw new Exception("\115\151\163\163\x69\x6e\147\x20\x6e\x61\155\145\x20\x6f\156\40\74\x73\141\155\x6c\x3a\x41\x74\164\x72\x69\142\x75\164\x65\x3e\x20\145\x6c\x65\155\x65\x6e\x74\x2e");
            Zt:
            $BT = $ma->getAttribute("\x4e\141\155\145");
            if ($ma->hasAttribute("\x4e\141\155\x65\x46\157\162\x6d\x61\164")) {
                goto g0;
            }
            $ux = "\165\162\156\72\x6f\141\163\x69\163\72\x6e\x61\155\145\163\72\164\143\72\123\x41\x4d\x4c\x3a\61\56\61\x3a\x6e\141\155\145\x69\144\x2d\x66\157\162\155\141\x74\x3a\x75\x6e\x73\160\x65\x63\x69\146\x69\145\144";
            goto Z0;
            g0:
            $ux = $ma->getAttribute("\x4e\141\x6d\x65\106\x6f\x72\155\x61\164");
            Z0:
            if ($ow) {
                goto ti;
            }
            if (!($this->nameFormat !== $ux)) {
                goto fc;
            }
            $this->nameFormat = "\x75\162\x6e\72\157\141\x73\x69\x73\x3a\x6e\141\155\x65\163\72\164\x63\72\x53\101\x4d\114\x3a\x31\56\61\72\156\x61\x6d\145\151\144\55\x66\x6f\162\x6d\141\164\72\x75\156\x73\x70\x65\x63\x69\x66\151\145\144";
            fc:
            goto Lb;
            ti:
            $this->nameFormat = $ux;
            $ow = FALSE;
            Lb:
            if (array_key_exists($BT, $this->attributes)) {
                goto A2;
            }
            $this->attributes[$BT] = array();
            A2:
            $Sr = Utilities::xpQuery($ma, "\56\57\x73\141\155\154\137\141\x73\x73\145\162\x74\x69\x6f\156\x3a\x41\164\164\162\x69\142\165\164\x65\126\141\x6c\165\x65");
            foreach ($Sr as $T5) {
                $this->attributes[$BT][] = trim($T5->textContent);
                w9:
            }
            Za:
            dr:
        }
        GF:
    }
    private function parseEncryptedAttributes(DOMElement $DH)
    {
        $this->encryptedAttribute = Utilities::xpQuery($DH, "\x2e\57\x73\x61\x6d\x6c\x5f\141\x73\x73\x65\162\164\x69\x6f\156\x3a\x41\164\164\162\151\x62\165\x74\x65\x53\164\141\164\145\x6d\x65\x6e\x74\x2f\163\x61\155\x6c\137\x61\163\x73\145\162\x74\151\157\x6e\x3a\105\x6e\x63\x72\171\160\164\x65\x64\x41\164\x74\162\x69\142\x75\164\145");
    }
    private function parseSignature(DOMElement $DH)
    {
        $Sj = Utilities::validateElement($DH);
        if (!($Sj !== FALSE)) {
            goto a4;
        }
        $this->wasSignedAtConstruction = TRUE;
        $this->certificates = $Sj["\x43\145\x72\x74\x69\x66\151\x63\141\x74\x65\x73"];
        $this->signatureData = $Sj;
        a4:
    }
    public function validate(XMLSecurityKey $ez)
    {
        if (!($this->signatureData === NULL)) {
            goto Dy;
        }
        return FALSE;
        Dy:
        Utilities::validateSignature($this->signatureData, $ez);
        return TRUE;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($Sh)
    {
        $this->id = $Sh;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($ty)
    {
        $this->issueInstant = $ty;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($NK)
    {
        $this->issuer = $NK;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto TJ;
        }
        throw new Exception("\x41\x74\x74\x65\x6d\160\x74\145\144\40\164\x6f\x20\x72\145\164\x72\151\145\x76\145\x20\145\x6e\143\162\171\x70\164\145\144\x20\116\141\x6d\145\x49\x44\x20\x77\x69\164\x68\x6f\165\x74\40\144\x65\143\162\171\160\x74\151\x6e\x67\x20\x69\x74\x20\146\x69\162\163\x74\56");
        TJ:
        return $this->nameId;
    }
    public function setNameId($k9)
    {
        $this->nameId = $k9;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Mt;
        }
        return TRUE;
        Mt:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $ez)
    {
        $gQ = new DOMDocument();
        $WB = $gQ->createElement("\162\157\157\x74");
        $gQ->appendChild($WB);
        Utilities::addNameId($WB, $this->nameId);
        $k9 = $WB->firstChild;
        Utilities::getContainer()->debugMessage($k9, "\145\156\143\x72\171\x70\x74");
        $MP = new XMLSecEnc();
        $MP->setNode($k9);
        $MP->type = XMLSecEnc::Element;
        $bq = new XMLSecurityKey(XMLSecurityKey::AES128_CBC);
        $bq->generateSessionKey();
        $MP->encryptKey($ez, $bq);
        $this->encryptedNameId = $MP->encryptNode($bq);
        $this->nameId = NULL;
    }
    public function decryptNameId(XMLSecurityKey $ez, array $Re = array())
    {
        if (!($this->encryptedNameId === NULL)) {
            goto vv;
        }
        return;
        vv:
        $k9 = Utilities::decryptElement($this->encryptedNameId, $ez, $Re);
        Utilities::getContainer()->debugMessage($k9, "\x64\145\x63\x72\x79\x70\164");
        $this->nameId = Utilities::parseNameId($k9);
        $this->encryptedNameId = NULL;
    }
    public function decryptAttributes(XMLSecurityKey $ez, array $Re = array())
    {
        if (!($this->encryptedAttribute === NULL)) {
            goto q2;
        }
        return;
        q2:
        $ow = TRUE;
        $l0 = $this->encryptedAttribute;
        foreach ($l0 as $sm) {
            $ma = Utilities::decryptElement($sm->getElementsByTagName("\105\156\x63\x72\x79\x70\x74\145\x64\x44\141\x74\141")->item(0), $ez, $Re);
            if ($ma->hasAttribute("\116\x61\x6d\145")) {
                goto uF;
            }
            throw new Exception("\x4d\x69\x73\x73\x69\156\x67\x20\x6e\141\x6d\145\40\x6f\x6e\40\74\x73\141\155\x6c\x3a\101\164\164\x72\151\x62\165\164\x65\x3e\40\x65\154\145\x6d\x65\156\164\x2e");
            uF:
            $BT = $ma->getAttribute("\x4e\141\155\x65");
            if ($ma->hasAttribute("\116\x61\155\145\x46\x6f\x72\x6d\141\x74")) {
                goto K0;
            }
            $ux = "\x75\162\156\x3a\x6f\x61\x73\151\x73\72\x6e\x61\155\x65\163\x3a\164\143\72\x53\x41\x4d\114\x3a\62\56\60\x3a\141\164\164\162\x6e\x61\155\x65\55\146\x6f\162\155\x61\x74\x3a\x75\156\x73\160\145\143\151\146\x69\145\144";
            goto db;
            K0:
            $ux = $ma->getAttribute("\116\141\x6d\x65\x46\x6f\x72\x6d\x61\164");
            db:
            if ($ow) {
                goto Pq;
            }
            if (!($this->nameFormat !== $ux)) {
                goto vg;
            }
            $this->nameFormat = "\x75\162\156\72\157\141\x73\x69\163\72\x6e\x61\x6d\145\x73\x3a\x74\x63\x3a\x53\x41\115\x4c\72\x32\x2e\x30\72\x61\x74\164\x72\x6e\141\x6d\145\x2d\146\157\162\155\141\164\72\165\x6e\x73\160\145\143\x69\x66\151\x65\144";
            vg:
            goto zw;
            Pq:
            $this->nameFormat = $ux;
            $ow = FALSE;
            zw:
            if (array_key_exists($BT, $this->attributes)) {
                goto vd;
            }
            $this->attributes[$BT] = array();
            vd:
            $Sr = Utilities::xpQuery($ma, "\56\57\163\x61\x6d\154\x5f\x61\x73\x73\x65\162\x74\x69\x6f\156\72\x41\x74\164\x72\x69\142\x75\164\145\x56\141\x6c\x75\145");
            foreach ($Sr as $T5) {
                $this->attributes[$BT][] = trim($T5->textContent);
                LK:
            }
            Q6:
            zp:
        }
        Ni:
    }
    public function getNotBefore()
    {
        return $this->notBefore;
    }
    public function setNotBefore($OE)
    {
        $this->notBefore = $OE;
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($Xh)
    {
        $this->notOnOrAfter = $Xh;
    }
    public function setEncryptedAttributes($cn)
    {
        $this->requiredEncAttributes = $cn;
    }
    public function getValidAudiences()
    {
        return $this->validAudiences;
    }
    public function setValidAudiences(array $j9 = NULL)
    {
        $this->validAudiences = $j9;
    }
    public function getAuthnInstant()
    {
        return $this->authnInstant;
    }
    public function setAuthnInstant($jl)
    {
        $this->authnInstant = $jl;
    }
    public function getSessionNotOnOrAfter()
    {
        return $this->sessionNotOnOrAfter;
    }
    public function setSessionNotOnOrAfter($zL)
    {
        $this->sessionNotOnOrAfter = $zL;
    }
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }
    public function setSessionIndex($ri)
    {
        $this->sessionIndex = $ri;
    }
    public function getAuthnContext()
    {
        if (empty($this->authnContextClassRef)) {
            goto xd;
        }
        return $this->authnContextClassRef;
        xd:
        if (empty($this->authnContextDeclRef)) {
            goto bD;
        }
        return $this->authnContextDeclRef;
        bD:
        return NULL;
    }
    public function setAuthnContext($UQ)
    {
        $this->setAuthnContextClassRef($UQ);
    }
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }
    public function setAuthnContextClassRef($I0)
    {
        $this->authnContextClassRef = $I0;
    }
    public function setAuthnContextDecl(SAML2_XML_Chunk $sU)
    {
        if (empty($this->authnContextDeclRef)) {
            goto H1;
        }
        throw new Exception("\x41\165\164\150\x6e\103\157\x6e\x74\145\x78\164\104\145\143\x6c\x52\145\146\x20\x69\x73\x20\141\154\162\145\x61\144\x79\x20\162\x65\147\x69\x73\x74\x65\162\x65\x64\41\40\115\141\x79\40\x6f\156\x6c\x79\x20\150\x61\x76\x65\x20\x65\151\164\150\x65\162\x20\x61\x20\x44\145\143\154\x20\x6f\162\x20\141\x20\x44\145\x63\154\x52\x65\x66\x2c\x20\x6e\x6f\164\x20\x62\x6f\x74\x68\41");
        H1:
        $this->authnContextDecl = $sU;
    }
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }
    public function setAuthnContextDeclRef($hR)
    {
        if (empty($this->authnContextDecl)) {
            goto em;
        }
        throw new Exception("\x41\x75\x74\x68\x6e\103\157\x6e\x74\x65\x78\x74\104\x65\143\154\40\x69\x73\x20\141\154\x72\x65\x61\x64\x79\x20\x72\145\147\151\163\x74\145\x72\x65\144\41\40\x4d\141\x79\40\x6f\156\154\x79\40\x68\141\x76\145\x20\x65\151\x74\150\x65\162\x20\x61\40\x44\x65\x63\x6c\x20\157\162\40\141\40\104\145\x63\x6c\x52\145\146\x2c\40\156\157\164\40\142\x6f\x74\150\x21");
        em:
        $this->authnContextDeclRef = $hR;
    }
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }
    public function getAuthenticatingAuthority()
    {
        return $this->AuthenticatingAuthority;
    }
    public function setAuthenticatingAuthority($gu)
    {
        $this->AuthenticatingAuthority = $gu;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttributes(array $l0)
    {
        $this->attributes = $l0;
    }
    public function getAttributeNameFormat()
    {
        return $this->nameFormat;
    }
    public function setAttributeNameFormat($ux)
    {
        $this->nameFormat = $ux;
    }
    public function getSubjectConfirmation()
    {
        return $this->SubjectConfirmation;
    }
    public function setSubjectConfirmation(array $Wp)
    {
        $this->SubjectConfirmation = $Wp;
    }
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }
    public function setSignatureKey(XMLsecurityKey $SR = NULL)
    {
        $this->signatureKey = $SR;
    }
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
    public function setEncryptionKey(XMLSecurityKey $Ro = NULL)
    {
        $this->encryptionKey = $Ro;
    }
    public function setCertificates(array $UH)
    {
        $this->certificates = $UH;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
    public function getWasSignedAtConstruction()
    {
        return $this->wasSignedAtConstruction;
    }
    public function toXML(DOMNode $GV = NULL)
    {
        if ($GV === NULL) {
            goto uo;
        }
        $x4 = $GV->ownerDocument;
        goto NO;
        uo:
        $x4 = new DOMDocument();
        $GV = $x4;
        NO:
        $WB = $x4->createElementNS("\165\x72\156\x3a\157\141\x73\151\x73\72\x6e\141\x6d\145\x73\x3a\164\143\72\x53\x41\x4d\x4c\x3a\x32\x2e\60\72\x61\163\x73\x65\162\164\151\157\156", "\x73\x61\155\154\72" . "\x41\x73\163\145\x72\164\x69\157\156");
        $GV->appendChild($WB);
        $WB->setAttributeNS("\165\162\x6e\72\157\x61\163\151\163\72\156\x61\x6d\x65\163\x3a\x74\143\72\123\101\x4d\x4c\72\62\x2e\60\72\x70\x72\157\x74\x6f\143\x6f\154", "\163\x61\x6d\x6c\x70\72\x74\155\x70", "\x74\155\x70");
        $WB->removeAttributeNS("\165\162\x6e\x3a\157\x61\163\x69\163\72\x6e\x61\155\x65\x73\x3a\164\143\72\x53\101\115\114\x3a\62\x2e\x30\72\x70\162\x6f\x74\157\143\157\154", "\164\155\160");
        $WB->setAttributeNS("\x68\164\x74\160\x3a\x2f\x2f\x77\167\167\x2e\167\x33\56\x6f\162\x67\57\x32\60\x30\x31\x2f\130\115\x4c\x53\143\x68\145\x6d\141\55\x69\156\x73\x74\141\x6e\143\145", "\170\163\x69\x3a\x74\x6d\160", "\164\x6d\x70");
        $WB->removeAttributeNS("\150\164\164\160\72\x2f\x2f\x77\167\x77\x2e\167\x33\56\x6f\162\147\57\x32\x30\x30\61\57\x58\115\x4c\x53\143\x68\145\x6d\141\x2d\151\x6e\163\164\141\156\143\x65", "\x74\155\160");
        $WB->setAttributeNS("\150\x74\164\x70\x3a\57\57\x77\167\x77\x2e\x77\x33\56\157\162\147\x2f\62\x30\x30\61\57\130\115\x4c\x53\x63\x68\x65\155\141", "\x78\x73\72\x74\x6d\x70", "\164\155\160");
        $WB->removeAttributeNS("\150\164\164\x70\x3a\57\57\x77\x77\167\x2e\167\63\56\157\162\147\x2f\62\x30\60\x31\x2f\130\115\x4c\123\143\x68\x65\155\141", "\x74\x6d\x70");
        $WB->setAttribute("\x49\x44", $this->id);
        $WB->setAttribute("\x56\x65\x72\163\151\x6f\x6e", "\62\56\60");
        $WB->setAttribute("\x49\x73\163\165\x65\x49\x6e\163\x74\x61\x6e\x74", gmdate("\x59\55\155\x2d\x64\134\x54\x48\72\151\72\x73\x5c\132", $this->issueInstant));
        $NK = Utilities::addString($WB, "\165\x72\156\x3a\157\141\x73\151\x73\72\x6e\141\155\x65\163\x3a\164\143\x3a\123\101\x4d\x4c\72\x32\x2e\60\x3a\141\x73\163\145\162\164\x69\x6f\156", "\163\x61\155\x6c\72\111\163\163\165\x65\162", $this->issuer);
        $this->addSubject($WB);
        $this->addConditions($WB);
        $this->addAuthnStatement($WB);
        if ($this->requiredEncAttributes == FALSE) {
            goto nf;
        }
        $this->addEncryptedAttributeStatement($WB);
        goto A1;
        nf:
        $this->addAttributeStatement($WB);
        A1:
        if (!($this->signatureKey !== NULL)) {
            goto rR;
        }
        Utilities::insertSignature($this->signatureKey, $this->certificates, $WB, $NK->nextSibling);
        rR:
        return $WB;
    }
    private function addSubject(DOMElement $WB)
    {
        if (!($this->nameId === NULL && $this->encryptedNameId === NULL)) {
            goto yo;
        }
        return;
        yo:
        $XQ = $WB->ownerDocument->createElementNS("\x75\x72\156\72\157\141\x73\151\x73\x3a\156\141\155\x65\163\72\164\143\x3a\123\101\x4d\114\x3a\62\56\60\72\x61\x73\x73\145\x72\164\151\x6f\x6e", "\163\141\x6d\154\x3a\123\165\x62\x6a\x65\143\x74");
        $WB->appendChild($XQ);
        if ($this->encryptedNameId === NULL) {
            goto Nr;
        }
        $eo = $XQ->ownerDocument->createElementNS("\x75\162\156\x3a\x6f\x61\x73\151\x73\72\x6e\141\x6d\x65\x73\72\x74\x63\72\x53\101\x4d\114\x3a\62\56\x30\x3a\141\163\163\145\162\x74\151\157\156", "\x73\141\155\x6c\x3a" . "\x45\x6e\x63\x72\x79\160\x74\x65\x64\x49\x44");
        $XQ->appendChild($eo);
        $eo->appendChild($XQ->ownerDocument->importNode($this->encryptedNameId, TRUE));
        goto x1;
        Nr:
        Utilities::addNameId($XQ, $this->nameId);
        x1:
        foreach ($this->SubjectConfirmation as $ZK) {
            $ZK->toXML($XQ);
            YP:
        }
        St:
    }
    private function addConditions(DOMElement $WB)
    {
        $x4 = $WB->ownerDocument;
        $De = $x4->createElementNS("\x75\162\156\x3a\157\x61\x73\x69\x73\72\x6e\141\x6d\145\x73\x3a\x74\x63\x3a\x53\101\x4d\114\72\62\56\60\72\141\x73\163\x65\162\x74\151\157\156", "\x73\141\155\x6c\72\x43\x6f\156\x64\x69\164\x69\x6f\x6e\163");
        $WB->appendChild($De);
        if (!($this->notBefore !== NULL)) {
            goto no;
        }
        $De->setAttribute("\x4e\x6f\164\102\x65\146\x6f\162\145", gmdate("\131\55\155\55\144\x5c\x54\x48\x3a\x69\x3a\163\x5c\132", $this->notBefore));
        no:
        if (!($this->notOnOrAfter !== NULL)) {
            goto Tc;
        }
        $De->setAttribute("\116\157\x74\x4f\x6e\x4f\162\101\146\x74\145\x72", gmdate("\131\55\155\x2d\144\x5c\124\x48\72\x69\x3a\163\x5c\132", $this->notOnOrAfter));
        Tc:
        if (!($this->validAudiences !== NULL)) {
            goto UN;
        }
        $SH = $x4->createElementNS("\165\162\156\72\x6f\x61\x73\151\x73\x3a\x6e\x61\155\145\x73\x3a\164\143\x3a\123\x41\115\x4c\72\62\x2e\x30\72\141\163\163\x65\x72\164\151\x6f\x6e", "\x73\141\x6d\x6c\x3a\101\x75\144\x69\x65\156\x63\x65\122\145\163\x74\x72\151\x63\164\x69\x6f\156");
        $De->appendChild($SH);
        Utilities::addStrings($SH, "\165\x72\156\72\157\141\163\151\163\x3a\156\141\155\145\163\72\164\x63\x3a\x53\x41\115\x4c\72\x32\x2e\x30\x3a\x61\163\163\x65\x72\164\x69\157\x6e", "\x73\x61\x6d\x6c\72\x41\165\144\x69\145\x6e\143\145", FALSE, $this->validAudiences);
        UN:
    }
    private function addAuthnStatement(DOMElement $WB)
    {
        if (!($this->authnInstant === NULL || $this->authnContextClassRef === NULL && $this->authnContextDecl === NULL && $this->authnContextDeclRef === NULL)) {
            goto go;
        }
        return;
        go:
        $x4 = $WB->ownerDocument;
        $by = $x4->createElementNS("\x75\162\156\72\x6f\x61\x73\x69\163\x3a\x6e\x61\155\145\163\72\164\143\x3a\123\101\x4d\114\x3a\62\56\x30\72\141\x73\x73\145\x72\164\151\x6f\x6e", "\163\x61\155\x6c\x3a\101\165\164\x68\156\123\164\x61\164\145\155\145\156\x74");
        $WB->appendChild($by);
        $by->setAttribute("\101\165\164\150\156\x49\156\x73\164\141\x6e\164", gmdate("\x59\x2d\155\55\144\x5c\x54\x48\72\151\72\163\x5c\x5a", $this->authnInstant));
        if (!($this->sessionNotOnOrAfter !== NULL)) {
            goto dI;
        }
        $by->setAttribute("\123\145\163\163\x69\157\x6e\x4e\157\x74\117\156\x4f\x72\101\x66\x74\145\162", gmdate("\131\x2d\x6d\x2d\144\134\x54\x48\72\x69\72\x73\134\x5a", $this->sessionNotOnOrAfter));
        dI:
        if (!($this->sessionIndex !== NULL)) {
            goto qy;
        }
        $by->setAttribute("\x53\145\x73\x73\x69\157\156\x49\x6e\x64\x65\170", $this->sessionIndex);
        qy:
        $Tl = $x4->createElementNS("\x75\162\x6e\x3a\157\x61\163\x69\x73\72\x6e\x61\155\x65\x73\72\x74\143\x3a\123\x41\115\x4c\x3a\62\x2e\60\x3a\x61\163\163\145\x72\164\151\x6f\x6e", "\x73\141\x6d\154\72\101\x75\164\150\x6e\103\157\156\x74\x65\170\164");
        $by->appendChild($Tl);
        if (empty($this->authnContextClassRef)) {
            goto Af;
        }
        Utilities::addString($Tl, "\x75\162\x6e\x3a\157\x61\x73\151\163\x3a\x6e\141\x6d\x65\163\x3a\164\x63\x3a\123\x41\115\x4c\x3a\62\x2e\x30\x3a\141\x73\x73\x65\162\x74\151\157\x6e", "\x73\141\x6d\154\x3a\101\165\164\x68\156\103\x6f\x6e\164\x65\x78\164\103\x6c\141\163\163\122\x65\x66", $this->authnContextClassRef);
        Af:
        if (empty($this->authnContextDecl)) {
            goto m0;
        }
        $this->authnContextDecl->toXML($Tl);
        m0:
        if (empty($this->authnContextDeclRef)) {
            goto f5;
        }
        Utilities::addString($Tl, "\165\x72\x6e\x3a\157\x61\x73\151\163\x3a\x6e\x61\x6d\145\163\x3a\164\x63\x3a\123\x41\115\114\72\x32\56\x30\x3a\141\x73\163\145\162\x74\x69\157\156", "\x73\x61\155\154\72\x41\165\164\x68\156\x43\x6f\156\164\x65\x78\164\x44\x65\x63\x6c\x52\145\x66", $this->authnContextDeclRef);
        f5:
        Utilities::addStrings($Tl, "\165\x72\156\x3a\157\141\163\151\x73\72\156\x61\155\x65\163\72\164\143\x3a\x53\x41\x4d\x4c\72\62\56\x30\x3a\x61\x73\x73\145\x72\164\151\157\156", "\x73\x61\155\154\72\101\165\164\x68\x65\156\x74\x69\x63\141\x74\151\156\147\x41\x75\164\x68\157\x72\x69\x74\171", FALSE, $this->AuthenticatingAuthority);
    }
    private function addAttributeStatement(DOMElement $WB)
    {
        if (!empty($this->attributes)) {
            goto Rd;
        }
        return;
        Rd:
        $x4 = $WB->ownerDocument;
        $iy = $x4->createElementNS("\165\x72\x6e\x3a\157\x61\163\151\x73\x3a\156\141\155\x65\x73\x3a\164\x63\x3a\123\101\115\114\x3a\x32\x2e\60\x3a\x61\x73\163\145\162\164\x69\x6f\x6e", "\163\141\x6d\x6c\x3a\101\164\x74\x72\x69\142\x75\164\x65\123\164\141\x74\145\155\145\156\164");
        $WB->appendChild($iy);
        foreach ($this->attributes as $BT => $Sr) {
            $ma = $x4->createElementNS("\x75\x72\156\72\157\x61\163\151\163\x3a\x6e\x61\x6d\x65\163\72\x74\x63\72\x53\101\x4d\x4c\72\x32\56\60\72\x61\x73\x73\x65\x72\x74\x69\157\x6e", "\163\x61\155\x6c\x3a\x41\164\x74\162\x69\142\165\x74\145");
            $iy->appendChild($ma);
            $ma->setAttribute("\x4e\141\155\x65", $BT);
            if (!($this->nameFormat !== "\165\162\156\72\x6f\141\x73\151\x73\72\x6e\141\x6d\x65\163\72\x74\x63\72\123\x41\x4d\114\x3a\x32\56\x30\x3a\141\x74\x74\x72\x6e\141\x6d\x65\x2d\146\x6f\162\x6d\x61\x74\72\x75\x6e\x73\x70\x65\x63\151\x66\x69\x65\x64")) {
                goto QK;
            }
            $ma->setAttribute("\116\141\x6d\145\x46\157\x72\x6d\141\164", $this->nameFormat);
            QK:
            foreach ($Sr as $T5) {
                if (is_string($T5)) {
                    goto i5;
                }
                if (is_int($T5)) {
                    goto Mo;
                }
                $Si = NULL;
                goto gK;
                i5:
                $Si = "\x78\163\72\163\x74\x72\x69\156\x67";
                goto gK;
                Mo:
                $Si = "\x78\x73\x3a\151\x6e\164\145\x67\x65\x72";
                gK:
                $iE = $x4->createElementNS("\165\x72\156\x3a\157\x61\163\151\x73\x3a\x6e\141\x6d\145\163\72\x74\143\72\123\101\115\x4c\x3a\62\56\x30\x3a\x61\x73\163\145\x72\164\151\x6f\156", "\163\x61\155\154\x3a\101\x74\x74\x72\151\142\165\x74\145\126\141\154\165\145");
                $ma->appendChild($iE);
                if (!($Si !== NULL)) {
                    goto iS;
                }
                $iE->setAttributeNS("\150\x74\164\160\x3a\x2f\57\x77\x77\x77\56\167\63\56\157\162\147\x2f\x32\x30\x30\61\57\130\x4d\114\123\x63\150\145\x6d\141\55\x69\156\163\x74\141\x6e\x63\145", "\170\x73\151\72\x74\171\x70\x65", $Si);
                iS:
                if (!is_null($T5)) {
                    goto sk;
                }
                $iE->setAttributeNS("\150\x74\164\x70\72\57\57\x77\167\167\56\167\x33\x2e\157\162\147\57\62\60\60\61\57\x58\115\114\x53\143\x68\x65\x6d\x61\x2d\151\156\163\x74\141\156\143\x65", "\x78\x73\151\72\156\x69\x6c", "\164\x72\x75\x65");
                sk:
                if ($T5 instanceof DOMNodeList) {
                    goto ll;
                }
                $iE->appendChild($x4->createTextNode($T5));
                goto A0;
                ll:
                $fD = 0;
                q3:
                if (!($fD < $T5->length)) {
                    goto ir;
                }
                $m8 = $x4->importNode($T5->item($fD), TRUE);
                $iE->appendChild($m8);
                PI:
                $fD++;
                goto q3;
                ir:
                A0:
                oy:
            }
            Et:
            XL:
        }
        hA:
    }
    private function addEncryptedAttributeStatement(DOMElement $WB)
    {
        if (!($this->requiredEncAttributes == FALSE)) {
            goto gp;
        }
        return;
        gp:
        $x4 = $WB->ownerDocument;
        $iy = $x4->createElementNS("\x75\x72\156\x3a\x6f\141\x73\x69\163\x3a\x6e\x61\155\145\163\72\164\x63\72\123\101\115\x4c\72\62\56\60\x3a\x61\163\x73\145\162\x74\x69\157\x6e", "\x73\141\155\x6c\x3a\101\x74\x74\x72\x69\x62\165\x74\145\123\164\x61\x74\145\x6d\145\156\164");
        $WB->appendChild($iy);
        foreach ($this->attributes as $BT => $Sr) {
            $Ug = new DOMDocument();
            $ma = $Ug->createElementNS("\x75\162\x6e\x3a\x6f\x61\163\151\x73\x3a\x6e\x61\x6d\145\163\72\164\143\72\123\x41\115\114\72\x32\x2e\x30\72\141\x73\163\145\x72\x74\151\157\x6e", "\163\141\155\x6c\x3a\101\164\164\x72\x69\x62\165\x74\x65");
            $ma->setAttribute("\x4e\x61\x6d\x65", $BT);
            $Ug->appendChild($ma);
            if (!($this->nameFormat !== "\165\x72\x6e\x3a\157\141\x73\151\163\x3a\156\141\155\145\163\72\164\143\72\123\x41\x4d\x4c\x3a\62\x2e\60\72\x61\164\164\x72\x6e\141\x6d\x65\x2d\x66\157\x72\x6d\x61\x74\x3a\x75\156\163\x70\145\x63\151\146\151\x65\x64")) {
                goto rU;
            }
            $ma->setAttribute("\116\141\x6d\x65\x46\157\x72\155\x61\x74", $this->nameFormat);
            rU:
            foreach ($Sr as $T5) {
                if (is_string($T5)) {
                    goto hh;
                }
                if (is_int($T5)) {
                    goto vE;
                }
                $Si = NULL;
                goto r5;
                hh:
                $Si = "\x78\x73\x3a\163\164\162\151\156\147";
                goto r5;
                vE:
                $Si = "\x78\x73\x3a\x69\x6e\164\145\147\145\162";
                r5:
                $iE = $Ug->createElementNS("\x75\x72\156\72\x6f\x61\163\x69\x73\72\156\x61\155\x65\x73\x3a\x74\143\x3a\123\101\x4d\114\72\x32\x2e\60\72\x61\x73\163\145\x72\x74\x69\157\x6e", "\x73\141\x6d\154\x3a\101\164\164\x72\151\142\165\164\x65\126\141\x6c\165\145");
                $ma->appendChild($iE);
                if (!($Si !== NULL)) {
                    goto uD;
                }
                $iE->setAttributeNS("\150\164\x74\x70\x3a\57\57\167\167\x77\56\x77\x33\56\157\162\x67\x2f\x32\x30\60\61\x2f\130\115\x4c\123\x63\x68\x65\155\141\x2d\x69\x6e\x73\164\x61\x6e\x63\x65", "\170\163\151\72\x74\171\x70\145", $Si);
                uD:
                if ($T5 instanceof DOMNodeList) {
                    goto Ap;
                }
                $iE->appendChild($Ug->createTextNode($T5));
                goto Ew;
                Ap:
                $fD = 0;
                TT:
                if (!($fD < $T5->length)) {
                    goto pU;
                }
                $m8 = $Ug->importNode($T5->item($fD), TRUE);
                $iE->appendChild($m8);
                S0:
                $fD++;
                goto TT;
                pU:
                Ew:
                Cd:
            }
            Kf:
            $We = new XMLSecEnc();
            $We->setNode($Ug->documentElement);
            $We->type = "\150\164\x74\x70\x3a\57\57\x77\x77\167\x2e\167\x33\56\157\x72\x67\57\x32\60\x30\61\x2f\x30\x34\x2f\170\x6d\x6c\x65\x6e\143\x23\x45\x6c\x65\x6d\x65\156\x74";
            $bq = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
            $bq->generateSessionKey();
            $We->encryptKey($this->encryptionKey, $bq);
            $Db = $We->encryptNode($bq);
            $dV = $x4->createElementNS("\x75\x72\156\x3a\x6f\x61\x73\x69\x73\x3a\x6e\x61\x6d\x65\163\72\x74\143\72\123\x41\x4d\x4c\x3a\62\x2e\x30\x3a\x61\x73\x73\x65\x72\164\151\157\156", "\x73\141\x6d\154\72\105\156\x63\x72\x79\x70\x74\145\144\101\164\164\x72\151\x62\x75\x74\145");
            $iy->appendChild($dV);
            $Hp = $x4->importNode($Db, TRUE);
            $dV->appendChild($Hp);
            q4:
        }
        t3:
    }
    public function getPrivateKeyUrl()
    {
        return $this->privateKeyUrl;
    }
    public function setPrivateKeyUrl($Af)
    {
        $this->privateKeyUrl = $Af;
    }
}
