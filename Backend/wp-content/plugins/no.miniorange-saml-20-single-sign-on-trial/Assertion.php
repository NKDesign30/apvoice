<?php


include_once "\125\164\x69\x6c\x69\x74\151\x65\x73\56\x70\x68\x70";
include_once "\x78\155\154\x73\145\143\x6c\151\x62\163\x2e\160\150\x70";
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
    public function __construct(DOMElement $rd = NULL, $nZ)
    {
        $this->id = Utilities::generateId();
        $this->issueInstant = Utilities::generateTimestamp();
        $this->issuer = '';
        $this->authnInstant = Utilities::generateTimestamp();
        $this->attributes = array();
        $this->nameFormat = "\165\162\156\72\157\x61\163\151\163\x3a\156\141\155\x65\x73\72\x74\x63\x3a\x53\101\x4d\114\x3a\x31\56\x31\x3a\156\141\x6d\145\x69\144\x2d\146\157\x72\x6d\x61\164\x3a\x75\x6e\163\x70\145\x63\x69\146\151\145\144";
        $this->certificates = array();
        $this->AuthenticatingAuthority = array();
        $this->SubjectConfirmation = array();
        if (!($rd === NULL)) {
            goto mm;
        }
        return;
        mm:
        if (!($rd->localName === "\105\x6e\143\162\171\160\x74\x65\x64\101\x73\x73\x65\162\x74\x69\x6f\156")) {
            goto pP;
        }
        $xr = Utilities::xpQuery($rd, "\56\x2f\170\x65\156\x63\x3a\105\156\x63\162\x79\160\164\x65\x64\x44\141\164\x61");
        $YN = Utilities::xpQuery($rd, "\x2e\57\x78\145\156\143\72\105\156\x63\162\x79\x70\164\145\x64\104\141\164\141\x2f\x64\163\72\x4b\145\x79\x49\156\x66\157\x2f\170\145\156\143\72\105\x6e\143\x72\x79\160\164\x65\x64\113\145\x79");
        $Sa = '';
        if (empty($YN)) {
            goto uV;
        }
        $Sa = $YN[0]->firstChild->getAttribute("\101\154\x67\x6f\x72\x69\x74\x68\155");
        goto FD;
        uV:
        $YN = Utilities::xpQuery($rd, "\x2e\57\170\x65\156\143\x3a\x45\156\143\162\x79\x70\x74\145\x64\113\x65\x79\x2f\x78\145\156\x63\72\105\156\143\162\x79\160\x74\x69\x6f\x6e\115\145\164\x68\x6f\144");
        $Sa = $YN[0]->getAttribute("\x41\154\147\157\x72\x69\164\x68\155");
        FD:
        $Hu = Utilities::getEncryptionAlgorithm($Sa);
        if (count($xr) === 0) {
            goto Bq;
        }
        if (count($xr) > 1) {
            goto cQ;
        }
        goto Xh;
        Bq:
        throw new Exception("\115\151\x73\163\x69\156\x67\40\145\156\x63\x72\x79\160\x74\x65\144\40\144\x61\164\141\40\151\x6e\40\x3c\163\141\x6d\154\72\105\x6e\143\x72\171\x70\164\x65\x64\x41\163\x73\145\162\x74\x69\157\156\x3e\56");
        goto Xh;
        cQ:
        throw new Exception("\x4d\157\162\145\40\x74\x68\x61\x6e\x20\157\x6e\x65\40\x65\156\x63\162\171\160\164\145\x64\x20\x64\141\164\141\x20\145\154\x65\155\x65\156\x74\x20\x69\156\40\x3c\163\x61\155\154\72\105\156\x63\162\171\x70\164\x65\x64\101\163\x73\145\162\x74\x69\x6f\x6e\x3e\x2e");
        Xh:
        $FE = new XMLSecurityKey($Hu, array("\x74\x79\x70\x65" => "\x70\x72\x69\x76\141\x74\145"));
        $yO = get_site_option("\x6d\x6f\137\x73\x61\155\154\137\x63\x75\162\162\145\x6e\x74\x5f\x63\x65\162\x74\137\160\x72\151\x76\141\164\x65\x5f\153\x65\171");
        $FE->loadKey($nZ, FALSE);
        $M5 = array();
        $rd = Utilities::decryptElement($xr[0], $FE, $M5);
        pP:
        if ($rd->hasAttribute("\x49\x44")) {
            goto Vp;
        }
        throw new Exception("\x4d\151\x73\x73\x69\x6e\x67\40\111\104\40\x61\x74\x74\x72\x69\x62\165\164\x65\x20\x6f\156\x20\123\101\115\114\40\141\163\163\x65\162\x74\151\x6f\156\56");
        Vp:
        $this->id = $rd->getAttribute("\111\x44");
        if (!($rd->getAttribute("\x56\145\162\x73\151\x6f\x6e") !== "\x32\x2e\60")) {
            goto ST;
        }
        throw new Exception("\125\x6e\x73\x75\160\x70\x6f\162\164\x65\144\x20\x76\x65\x72\163\x69\157\x6e\x3a\x20" . $rd->getAttribute("\126\145\162\x73\x69\x6f\156"));
        ST:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($rd->getAttribute("\111\163\163\x75\x65\111\156\x73\x74\x61\x6e\x74"));
        $Jq = Utilities::xpQuery($rd, "\x2e\57\x73\141\155\x6c\137\141\x73\x73\145\162\164\151\157\156\72\x49\163\163\165\145\x72");
        if (!empty($Jq)) {
            goto A8;
        }
        throw new Exception("\x4d\x69\x73\163\x69\156\x67\x20\74\163\141\x6d\154\x3a\111\163\163\165\x65\x72\x3e\x20\x69\156\40\x61\163\x73\x65\162\x74\x69\x6f\x6e\56");
        A8:
        $this->issuer = trim($Jq[0]->textContent);
        $this->parseConditions($rd);
        $this->parseAuthnStatement($rd);
        $this->parseAttributes($rd);
        $this->parseEncryptedAttributes($rd);
        $this->parseSignature($rd);
        $this->parseSubject($rd);
    }
    private function parseSubject(DOMElement $rd)
    {
        $CJ = Utilities::xpQuery($rd, "\56\57\x73\141\155\x6c\x5f\141\163\163\x65\x72\164\151\157\156\x3a\x53\x75\142\152\x65\x63\x74");
        if (empty($CJ)) {
            goto fK;
        }
        if (count($CJ) > 1) {
            goto Je;
        }
        goto o1;
        fK:
        return;
        goto o1;
        Je:
        throw new Exception("\115\157\x72\x65\x20\164\150\141\156\x20\157\156\x65\x20\x3c\163\141\x6d\x6c\x3a\123\165\142\x6a\x65\143\x74\76\x20\x69\x6e\x20\x3c\163\141\155\154\x3a\101\163\163\x65\162\164\x69\157\x6e\76\56");
        o1:
        $CJ = $CJ[0];
        $f1 = Utilities::xpQuery($CJ, "\x2e\x2f\163\x61\155\x6c\x5f\x61\163\163\x65\x72\x74\x69\157\x6e\72\116\141\155\145\111\x44\x20\174\40\56\57\x73\x61\155\154\137\x61\163\x73\145\x72\164\151\x6f\156\x3a\105\x6e\143\162\x79\160\164\145\144\111\104\57\x78\x65\x6e\143\72\105\156\143\162\171\x70\x74\145\x64\x44\x61\164\141");
        if (empty($f1)) {
            goto qO;
        }
        if (count($f1) > 1) {
            goto oc;
        }
        goto NU;
        qO:
        if ($_POST["\x52\145\154\141\x79\x53\164\141\x74\x65"] == "\x74\145\x73\x74\126\141\154\x69\x64\141\164\145" or $_POST["\122\145\154\x61\x79\x53\x74\x61\x74\145"] == "\164\145\x73\x74\x4e\x65\167\103\145\x72\x74\151\146\x69\143\141\x74\145") {
            goto l5;
        }
        wp_die("\127\x65\x20\x63\157\x75\154\x64\x20\156\x6f\x74\x20\163\151\x67\156\x20\171\157\x75\40\151\156\56\40\x50\x6c\x65\141\163\x65\x20\143\157\156\164\141\143\x74\40\x79\x6f\165\162\40\x61\x64\x6d\151\x6e\x69\x73\164\x72\141\x74\x6f\x72");
        goto aJ;
        l5:
        echo "\x3c\144\151\x76\40\163\164\x79\x6c\x65\75\42\146\157\x6e\x74\x2d\x66\x61\x6d\151\154\171\72\x43\141\x6c\151\142\162\151\x3b\x70\x61\x64\144\151\x6e\147\x3a\60\x20\63\45\73\42\76";
        echo "\74\144\151\x76\x20\x73\x74\171\154\x65\x3d\42\143\157\x6c\157\162\72\x20\43\141\71\x34\64\x34\62\73\x62\141\x63\x6b\147\162\157\x75\x6e\144\55\143\x6f\x6c\157\x72\x3a\40\43\146\62\144\145\x64\145\73\x70\141\x64\144\x69\x6e\147\72\x20\x31\x35\160\170\73\155\141\162\147\151\x6e\55\x62\157\x74\x74\157\155\72\x20\x32\x30\160\x78\73\164\x65\x78\x74\55\x61\x6c\151\147\x6e\x3a\143\x65\156\164\145\162\x3b\x62\157\162\144\x65\x72\x3a\61\x70\170\40\163\x6f\x6c\x69\x64\x20\43\x45\66\x42\x33\x42\62\x3b\146\x6f\156\164\55\x73\x69\172\x65\x3a\x31\70\x70\x74\x3b\x22\76\x20\105\122\x52\x4f\x52\x3c\x2f\144\151\x76\76\xd\12\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\74\x64\151\166\40\163\164\x79\154\x65\75\x22\143\x6f\x6c\x6f\x72\72\40\43\141\x39\x34\x34\x34\62\73\x66\157\x6e\164\x2d\163\x69\172\x65\x3a\x31\64\x70\164\73\x20\x6d\141\162\x67\x69\x6e\x2d\x62\157\164\x74\x6f\x6d\72\62\60\160\170\73\42\x3e\x3c\160\76\x3c\163\164\162\x6f\156\x67\x3e\x45\x72\162\157\x72\x3a\40\x3c\57\163\164\x72\157\x6e\x67\x3e\115\x69\x73\x73\x69\x6e\147\40\x20\116\141\x6d\x65\x49\104\40\x6f\x72\x20\x45\156\x63\162\x79\x70\164\145\x64\x49\104\x20\x69\156\40\123\101\x4d\114\x20\x52\x65\163\160\x6f\156\x73\145\x3c\57\x70\76\xd\xa\x20\x20\40\40\x20\40\40\40\x20\40\x20\40\x20\40\x20\40\x3c\x70\76\x50\x6c\x65\x61\163\x65\40\x63\157\156\164\141\143\164\40\x79\x6f\165\162\x20\141\144\155\151\156\151\x73\164\x72\x61\164\x6f\x72\40\x61\156\x64\40\x72\145\x70\x6f\x72\x74\40\x74\150\145\40\146\157\x6c\154\157\167\151\x6e\147\x20\x65\x72\x72\157\162\72\74\x2f\x70\x3e\15\12\x20\40\40\x20\x20\40\40\40\40\x20\40\x20\40\40\x20\x20\x3c\x70\x3e\x3c\163\164\x72\x6f\x6e\147\x3e\120\x6f\163\x73\x69\x62\x6c\x65\40\103\x61\165\163\x65\72\74\x2f\163\x74\162\x6f\x6e\147\76\40\116\x61\155\145\111\104\40\156\157\x74\40\x66\157\165\x6e\x64\40\x69\x6e\x20\x53\101\x4d\114\x20\122\x65\163\x70\157\x6e\x73\x65\40\163\165\142\152\x65\x63\164\x3c\x2f\160\76\xd\12\x20\40\x20\40\40\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\74\57\144\x69\x76\76\xd\12\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\40\40\40\40\x20\x3c\x64\151\x76\x20\163\164\171\x6c\145\75\42\155\141\x72\x67\151\156\72\x33\45\73\x64\x69\x73\160\154\x61\x79\x3a\142\154\157\143\x6b\x3b\x74\x65\170\x74\x2d\x61\154\151\x67\156\x3a\x63\145\x6e\164\x65\162\73\42\x3e\15\xa\x20\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\x20\40\x20\x3c\144\151\166\x20\x73\x74\171\x6c\x65\x3d\x22\155\141\162\147\151\156\x3a\63\x25\x3b\x64\x69\x73\160\x6c\141\x79\x3a\142\x6c\157\143\x6b\x3b\x74\x65\170\164\55\x61\x6c\151\x67\x6e\x3a\x63\145\x6e\164\x65\162\x3b\42\x3e\x3c\x69\156\x70\165\164\40\163\164\x79\x6c\145\x3d\42\x70\x61\144\x64\x69\x6e\x67\72\61\45\73\x77\x69\144\164\x68\72\x31\60\x30\160\170\73\142\141\143\x6b\x67\x72\x6f\165\x6e\x64\72\x20\43\x30\60\71\61\103\104\x20\156\157\156\x65\x20\x72\145\160\145\x61\x74\x20\163\143\162\x6f\x6c\154\40\x30\45\40\x30\x25\x3b\143\165\x72\x73\x6f\x72\72\40\160\157\151\156\x74\145\x72\73\146\x6f\156\164\55\x73\x69\x7a\145\72\61\65\160\x78\73\142\157\x72\144\145\162\55\x77\x69\x64\164\150\x3a\x20\61\x70\x78\x3b\x62\157\x72\144\145\162\55\x73\x74\x79\x6c\x65\72\40\x73\x6f\x6c\x69\x64\73\142\x6f\x72\144\145\x72\55\x72\141\x64\151\x75\163\72\x20\x33\x70\x78\x3b\x77\x68\151\x74\x65\55\x73\x70\141\x63\x65\72\40\156\x6f\x77\162\141\x70\x3b\x62\x6f\170\x2d\163\151\172\151\x6e\147\72\x20\x62\x6f\162\144\x65\x72\55\x62\157\x78\x3b\142\x6f\x72\x64\145\162\x2d\x63\157\154\157\162\72\40\43\60\x30\67\63\x41\101\73\142\157\x78\x2d\163\x68\x61\144\x6f\x77\72\x20\x30\160\x78\x20\x31\x70\170\40\60\x70\x78\40\162\147\142\141\x28\x31\62\x30\54\40\62\60\60\54\40\62\x33\60\x2c\x20\60\x2e\x36\x29\40\151\x6e\163\145\x74\73\x63\x6f\x6c\157\x72\72\x20\43\x46\106\x46\73\42\x74\171\160\145\75\42\x62\x75\164\x74\157\156\42\40\x76\141\154\x75\145\x3d\42\x44\157\x6e\145\x22\x20\157\156\103\x6c\x69\x63\153\x3d\x22\163\145\x6c\x66\x2e\x63\154\157\163\145\50\x29\73\42\x3e\74\x2f\144\x69\x76\76";
        exit;
        aJ:
        goto NU;
        oc:
        throw new Exception("\115\x6f\x72\x65\40\164\150\x61\156\x20\157\x6e\x65\x20\74\x73\141\x6d\154\72\116\x61\x6d\x65\111\104\76\x20\x6f\x72\x20\x3c\163\x61\155\x6c\72\x45\156\143\x72\x79\x70\x74\145\144\x44\x3e\x20\151\x6e\40\x3c\163\141\155\x6c\x3a\123\x75\142\x6a\145\143\164\76\56");
        NU:
        $f1 = $f1[0];
        if ($f1->localName === "\x45\x6e\x63\162\x79\160\164\x65\x64\104\141\164\x61") {
            goto t2;
        }
        $this->nameId = Utilities::parseNameId($f1);
        goto qJ;
        t2:
        $this->encryptedNameId = $f1;
        qJ:
    }
    private function parseConditions(DOMElement $rd)
    {
        $xh = Utilities::xpQuery($rd, "\x2e\x2f\x73\x61\x6d\x6c\137\x61\163\163\x65\162\164\x69\x6f\x6e\72\103\157\156\144\151\164\x69\157\156\163");
        if (empty($xh)) {
            goto p3;
        }
        if (count($xh) > 1) {
            goto ea;
        }
        goto pZ;
        p3:
        return;
        goto pZ;
        ea:
        throw new Exception("\115\x6f\x72\x65\x20\164\150\x61\156\x20\x6f\156\145\40\74\x73\141\155\x6c\72\x43\x6f\156\x64\x69\164\151\x6f\x6e\163\x3e\40\151\156\x20\74\x73\x61\x6d\154\x3a\x41\163\163\145\162\x74\x69\x6f\156\x3e\56");
        pZ:
        $xh = $xh[0];
        if (!$xh->hasAttribute("\116\157\x74\x42\x65\146\157\162\x65")) {
            goto gD;
        }
        $GE = Utilities::xsDateTimeToTimestamp($xh->getAttribute("\x4e\157\x74\102\145\x66\157\x72\x65"));
        if (!($this->notBefore === NULL || $this->notBefore < $GE)) {
            goto Io;
        }
        $this->notBefore = $GE;
        Io:
        gD:
        if (!$xh->hasAttribute("\116\x6f\x74\x4f\156\x4f\x72\101\x66\164\145\x72")) {
            goto S9;
        }
        $jE = Utilities::xsDateTimeToTimestamp($xh->getAttribute("\x4e\x6f\164\x4f\x6e\117\162\101\x66\x74\145\162"));
        if (!($this->notOnOrAfter === NULL || $this->notOnOrAfter > $jE)) {
            goto zF;
        }
        $this->notOnOrAfter = $jE;
        zF:
        S9:
        $xi = $xh->firstChild;
        n_:
        if (!($xi !== NULL)) {
            goto Gj;
        }
        if (!$xi instanceof DOMText) {
            goto CJ;
        }
        goto q9;
        CJ:
        if (!($xi->namespaceURI !== "\x75\162\156\72\x6f\x61\163\x69\163\72\156\x61\x6d\x65\x73\x3a\x74\x63\72\123\101\x4d\114\72\62\x2e\60\x3a\141\163\163\x65\x72\164\151\157\x6e")) {
            goto QS;
        }
        throw new Exception("\125\156\153\x6e\x6f\x77\x6e\x20\156\141\x6d\x65\163\x70\x61\x63\145\x20\157\x66\40\x63\x6f\x6e\x64\x69\164\x69\157\x6e\x3a\40" . var_export($xi->namespaceURI, TRUE));
        QS:
        switch ($xi->localName) {
            case "\x41\165\144\x69\x65\156\143\145\x52\145\163\164\162\x69\x63\x74\151\x6f\x6e":
                $tp = Utilities::extractStrings($xi, "\165\162\156\72\157\x61\x73\151\x73\x3a\x6e\x61\155\145\163\72\164\143\x3a\123\x41\115\114\x3a\62\56\60\x3a\141\163\x73\145\x72\x74\x69\x6f\x6e", "\101\165\x64\151\x65\156\x63\x65");
                if ($this->validAudiences === NULL) {
                    goto zI;
                }
                $this->validAudiences = array_intersect($this->validAudiences, $tp);
                goto Lf;
                zI:
                $this->validAudiences = $tp;
                Lf:
                goto Nh;
            case "\x4f\x6e\145\124\151\155\145\125\x73\x65":
                goto Nh;
            case "\x50\162\x6f\x78\171\122\x65\x73\164\162\151\143\164\151\157\156":
                goto Nh;
            default:
                throw new Exception("\125\156\153\156\x6f\x77\x6e\x20\143\157\156\144\x69\164\151\157\156\72\40" . var_export($xi->localName, TRUE));
        }
        Cl:
        Nh:
        q9:
        $xi = $xi->nextSibling;
        goto n_;
        Gj:
    }
    private function parseAuthnStatement(DOMElement $rd)
    {
        $zG = Utilities::xpQuery($rd, "\56\57\163\141\155\x6c\x5f\141\x73\163\145\162\164\x69\157\156\x3a\x41\x75\164\x68\156\123\x74\x61\164\x65\x6d\145\156\164");
        if (empty($zG)) {
            goto J2;
        }
        if (count($zG) > 1) {
            goto EK;
        }
        goto vX;
        J2:
        $this->authnInstant = NULL;
        return;
        goto vX;
        EK:
        throw new Exception("\x4d\157\162\145\x20\x74\x68\141\x74\40\x6f\x6e\145\40\x3c\163\x61\155\154\72\x41\x75\x74\x68\156\x53\164\x61\x74\145\x6d\145\x6e\x74\76\x20\x69\156\x20\74\x73\x61\x6d\154\x3a\x41\163\163\145\x72\x74\151\157\x6e\x3e\x20\x6e\x6f\164\x20\x73\x75\x70\160\x6f\162\x74\145\x64\56");
        vX:
        $q3 = $zG[0];
        if ($q3->hasAttribute("\x41\165\164\x68\x6e\111\x6e\163\164\x61\156\x74")) {
            goto pn;
        }
        throw new Exception("\x4d\151\x73\x73\x69\x6e\147\x20\x72\145\161\x75\151\162\145\x64\x20\101\165\x74\150\x6e\x49\x6e\163\x74\x61\156\x74\40\x61\164\x74\x72\x69\142\x75\x74\145\x20\157\156\x20\x3c\163\141\x6d\x6c\x3a\101\165\164\150\156\x53\x74\141\164\145\155\145\x6e\x74\76\56");
        pn:
        $this->authnInstant = Utilities::xsDateTimeToTimestamp($q3->getAttribute("\101\165\x74\x68\156\111\156\x73\164\141\x6e\164"));
        if (!$q3->hasAttribute("\123\x65\163\163\x69\157\x6e\x4e\x6f\x74\x4f\x6e\117\x72\101\146\x74\x65\x72")) {
            goto Pi;
        }
        $this->sessionNotOnOrAfter = Utilities::xsDateTimeToTimestamp($q3->getAttribute("\x53\x65\x73\x73\151\x6f\156\x4e\x6f\164\x4f\x6e\117\x72\101\146\x74\145\x72"));
        Pi:
        if (!$q3->hasAttribute("\123\145\163\x73\x69\x6f\156\x49\156\144\x65\170")) {
            goto ck;
        }
        $this->sessionIndex = $q3->getAttribute("\x53\x65\163\163\151\x6f\x6e\111\x6e\144\x65\170");
        ck:
        $this->parseAuthnContext($q3);
    }
    private function parseAuthnContext(DOMElement $OL)
    {
        $XY = Utilities::xpQuery($OL, "\x2e\x2f\x73\141\x6d\x6c\137\x61\x73\163\x65\x72\164\151\x6f\x6e\x3a\101\x75\x74\x68\x6e\x43\157\x6e\x74\x65\170\x74");
        if (count($XY) > 1) {
            goto gc;
        }
        if (empty($XY)) {
            goto nN;
        }
        goto n5;
        gc:
        throw new Exception("\115\x6f\x72\145\40\x74\x68\141\156\40\x6f\156\x65\40\74\x73\141\155\x6c\x3a\101\x75\164\x68\x6e\103\157\x6e\x74\145\170\164\76\x20\x69\x6e\x20\x3c\163\141\x6d\154\x3a\101\x75\x74\150\156\x53\164\x61\164\145\155\145\x6e\164\x3e\x2e");
        goto n5;
        nN:
        throw new Exception("\x4d\x69\163\163\151\x6e\x67\40\x72\145\161\x75\x69\x72\x65\144\40\x3c\163\x61\155\x6c\72\101\165\164\x68\x6e\103\x6f\x6e\x74\145\170\x74\76\40\151\x6e\x20\x3c\x73\141\x6d\x6c\x3a\101\x75\164\x68\156\x53\164\x61\164\145\155\145\x6e\x74\x3e\x2e");
        n5:
        $m4 = $XY[0];
        $nV = Utilities::xpQuery($m4, "\x2e\57\x73\x61\x6d\x6c\x5f\141\x73\x73\145\x72\164\151\x6f\156\x3a\x41\165\164\x68\156\103\157\x6e\x74\145\170\x74\x44\145\x63\154\122\x65\x66");
        if (count($nV) > 1) {
            goto S8;
        }
        if (count($nV) === 1) {
            goto vE;
        }
        goto wZ;
        S8:
        throw new Exception("\115\157\162\x65\40\164\x68\x61\x6e\40\x6f\156\x65\40\x3c\x73\x61\x6d\154\72\101\x75\164\150\156\103\157\x6e\x74\x65\170\x74\104\145\x63\x6c\x52\145\x66\x3e\40\x66\157\x75\x6e\144\77");
        goto wZ;
        vE:
        $this->setAuthnContextDeclRef(trim($nV[0]->textContent));
        wZ:
        $SB = Utilities::xpQuery($m4, "\x2e\57\163\x61\x6d\x6c\137\141\x73\163\145\162\x74\151\x6f\x6e\72\x41\165\x74\x68\156\x43\x6f\156\164\x65\x78\x74\104\145\143\x6c");
        if (count($SB) > 1) {
            goto dG;
        }
        if (count($SB) === 1) {
            goto S2;
        }
        goto nW;
        dG:
        throw new Exception("\115\157\x72\x65\x20\164\150\x61\156\40\157\156\145\40\x3c\163\x61\x6d\x6c\72\x41\165\x74\x68\156\x43\x6f\x6e\164\145\x78\164\104\145\143\x6c\76\40\x66\157\165\156\144\x3f");
        goto nW;
        S2:
        $this->setAuthnContextDecl(new SAML2_XML_Chunk($SB[0]));
        nW:
        $qA = Utilities::xpQuery($m4, "\x2e\57\x73\x61\155\x6c\x5f\141\163\x73\145\162\x74\151\157\x6e\72\x41\x75\164\150\156\x43\157\x6e\164\x65\170\164\x43\x6c\141\163\163\122\145\146");
        if (count($qA) > 1) {
            goto I9;
        }
        if (count($qA) === 1) {
            goto yW;
        }
        goto fo;
        I9:
        throw new Exception("\115\157\x72\145\x20\164\x68\x61\156\40\x6f\x6e\x65\40\x3c\163\x61\155\154\x3a\x41\165\164\x68\156\x43\x6f\156\x74\145\170\x74\x43\154\x61\x73\x73\x52\145\x66\76\40\151\x6e\40\x3c\163\x61\x6d\x6c\72\x41\165\164\150\156\x43\x6f\156\164\x65\x78\164\76\x2e");
        goto fo;
        yW:
        $this->setAuthnContextClassRef(trim($qA[0]->textContent));
        fo:
        if (!(empty($this->authnContextClassRef) && empty($this->authnContextDecl) && empty($this->authnContextDeclRef))) {
            goto He;
        }
        throw new Exception("\115\x69\x73\x73\x69\x6e\x67\40\145\x69\x74\x68\145\x72\40\x3c\x73\141\155\154\72\101\x75\x74\x68\x6e\x43\157\x6e\x74\x65\x78\x74\103\x6c\x61\163\163\122\x65\146\76\40\157\162\40\74\163\x61\x6d\x6c\x3a\101\x75\164\150\156\x43\157\156\x74\145\170\x74\x44\145\143\154\x52\145\146\x3e\x20\x6f\x72\x20\74\x73\141\155\154\x3a\101\x75\164\x68\x6e\103\x6f\x6e\x74\x65\170\x74\104\145\143\154\x3e");
        He:
        $this->AuthenticatingAuthority = Utilities::extractStrings($m4, "\x75\162\x6e\x3a\x6f\141\x73\151\x73\x3a\x6e\x61\x6d\145\163\72\x74\143\72\x53\x41\115\114\72\x32\x2e\x30\72\x61\163\x73\x65\162\164\x69\157\x6e", "\x41\165\164\x68\x65\x6e\164\151\x63\x61\164\151\x6e\x67\x41\x75\164\150\x6f\162\x69\x74\x79");
    }
    private function parseAttributes(DOMElement $rd)
    {
        $qc = TRUE;
        $Zf = Utilities::xpQuery($rd, "\56\x2f\163\x61\x6d\x6c\x5f\141\163\x73\145\162\x74\151\x6f\156\x3a\x41\164\164\162\x69\142\x75\164\145\x53\x74\141\164\x65\x6d\145\156\x74\x2f\163\x61\x6d\x6c\137\141\163\163\145\x72\164\151\x6f\x6e\72\x41\x74\x74\x72\151\142\165\164\x65");
        foreach ($Zf as $Be) {
            if ($Be->hasAttribute("\116\141\x6d\145")) {
                goto J9;
            }
            throw new Exception("\115\151\x73\x73\x69\156\147\x20\x6e\x61\155\145\40\x6f\x6e\x20\x3c\163\x61\x6d\x6c\x3a\x41\x74\164\x72\x69\x62\165\164\145\76\x20\145\x6c\145\155\145\x6e\x74\x2e");
            J9:
            $Ex = $Be->getAttribute("\116\x61\x6d\145");
            if ($Be->hasAttribute("\x4e\x61\x6d\x65\106\157\162\x6d\x61\164")) {
                goto Qc;
            }
            $Ab = "\x75\162\156\x3a\157\141\163\x69\x73\72\156\x61\155\x65\163\x3a\164\x63\x3a\x53\101\x4d\x4c\72\x31\56\61\72\x6e\141\x6d\x65\151\x64\x2d\146\x6f\162\x6d\x61\x74\x3a\x75\156\x73\x70\x65\143\151\146\151\x65\144";
            goto UJ;
            Qc:
            $Ab = $Be->getAttribute("\116\141\x6d\x65\106\x6f\x72\x6d\x61\x74");
            UJ:
            if ($qc) {
                goto k1;
            }
            if (!($this->nameFormat !== $Ab)) {
                goto D8;
            }
            $this->nameFormat = "\165\x72\x6e\72\x6f\141\x73\151\x73\72\x6e\141\155\145\163\72\x74\143\x3a\x53\x41\x4d\114\x3a\x31\56\61\72\156\x61\x6d\145\151\144\x2d\146\x6f\x72\x6d\x61\164\72\165\x6e\x73\x70\x65\x63\x69\146\x69\x65\x64";
            D8:
            goto Eq;
            k1:
            $this->nameFormat = $Ab;
            $qc = FALSE;
            Eq:
            if (array_key_exists($Ex, $this->attributes)) {
                goto uq;
            }
            $this->attributes[$Ex] = array();
            uq:
            $ga = Utilities::xpQuery($Be, "\x2e\x2f\163\x61\155\x6c\x5f\141\x73\163\145\162\x74\x69\x6f\x6e\72\101\x74\164\162\151\142\165\164\x65\126\141\x6c\165\145");
            foreach ($ga as $Ng) {
                $this->attributes[$Ex][] = trim($Ng->textContent);
                pA:
            }
            SE:
            ej:
        }
        ia:
    }
    private function parseEncryptedAttributes(DOMElement $rd)
    {
        $this->encryptedAttribute = Utilities::xpQuery($rd, "\x2e\57\163\141\155\x6c\x5f\141\x73\x73\145\x72\x74\x69\157\156\x3a\x41\x74\x74\162\151\x62\165\x74\x65\x53\x74\x61\164\x65\155\145\x6e\x74\57\x73\x61\x6d\154\137\x61\163\x73\145\x72\164\x69\x6f\156\72\x45\156\143\162\x79\x70\164\145\144\101\x74\164\x72\x69\x62\165\x74\x65");
    }
    private function parseSignature(DOMElement $rd)
    {
        $OP = Utilities::validateElement($rd);
        if (!($OP !== FALSE)) {
            goto KI;
        }
        $this->wasSignedAtConstruction = TRUE;
        $this->certificates = $OP["\103\x65\162\x74\x69\146\x69\x63\x61\x74\x65\x73"];
        $this->signatureData = $OP;
        KI:
    }
    public function validate(XMLSecurityKey $FE)
    {
        if (!($this->signatureData === NULL)) {
            goto J0;
        }
        return FALSE;
        J0:
        Utilities::validateSignature($this->signatureData, $FE);
        return TRUE;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($Vh)
    {
        $this->id = $Vh;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($vG)
    {
        $this->issueInstant = $vG;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($Jq)
    {
        $this->issuer = $Jq;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto cT;
        }
        throw new Exception("\x41\164\x74\145\x6d\160\164\x65\144\40\x74\x6f\40\x72\x65\164\162\151\145\x76\x65\40\x65\156\143\162\171\x70\x74\x65\144\x20\x4e\141\x6d\145\111\104\40\x77\151\164\x68\x6f\x75\164\40\x64\145\x63\162\x79\x70\164\x69\156\147\x20\151\164\40\146\x69\x72\163\164\x2e");
        cT:
        return $this->nameId;
    }
    public function setNameId($f1)
    {
        $this->nameId = $f1;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto F1;
        }
        return TRUE;
        F1:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $FE)
    {
        $ta = new DOMDocument();
        $Ii = $ta->createElement("\162\x6f\x6f\164");
        $ta->appendChild($Ii);
        Utilities::addNameId($Ii, $this->nameId);
        $f1 = $Ii->firstChild;
        Utilities::getContainer()->debugMessage($f1, "\x65\156\x63\162\171\160\x74");
        $tv = new XMLSecEnc();
        $tv->setNode($f1);
        $tv->type = XMLSecEnc::Element;
        $bn = new XMLSecurityKey(XMLSecurityKey::AES128_CBC);
        $bn->generateSessionKey();
        $tv->encryptKey($FE, $bn);
        $this->encryptedNameId = $tv->encryptNode($bn);
        $this->nameId = NULL;
    }
    public function decryptNameId(XMLSecurityKey $FE, array $M5 = array())
    {
        if (!($this->encryptedNameId === NULL)) {
            goto ay;
        }
        return;
        ay:
        $f1 = Utilities::decryptElement($this->encryptedNameId, $FE, $M5);
        Utilities::getContainer()->debugMessage($f1, "\x64\145\143\x72\x79\x70\164");
        $this->nameId = Utilities::parseNameId($f1);
        $this->encryptedNameId = NULL;
    }
    public function decryptAttributes(XMLSecurityKey $FE, array $M5 = array())
    {
        if (!($this->encryptedAttribute === NULL)) {
            goto Qu;
        }
        return;
        Qu:
        $qc = TRUE;
        $Zf = $this->encryptedAttribute;
        foreach ($Zf as $VT) {
            $Be = Utilities::decryptElement($VT->getElementsByTagName("\x45\156\x63\162\171\160\x74\x65\144\104\x61\164\141")->item(0), $FE, $M5);
            if ($Be->hasAttribute("\x4e\141\x6d\145")) {
                goto m0;
            }
            throw new Exception("\115\x69\163\163\151\156\x67\40\156\x61\155\x65\x20\157\156\40\x3c\x73\x61\155\154\x3a\101\164\164\162\151\x62\x75\x74\x65\76\x20\145\x6c\145\x6d\x65\x6e\164\x2e");
            m0:
            $Ex = $Be->getAttribute("\116\141\155\x65");
            if ($Be->hasAttribute("\x4e\141\x6d\x65\106\157\x72\x6d\141\164")) {
                goto hI;
            }
            $Ab = "\165\x72\156\72\157\x61\x73\x69\163\72\156\x61\x6d\145\x73\x3a\x74\x63\72\123\101\x4d\114\72\x32\56\60\x3a\141\x74\x74\x72\x6e\x61\155\145\55\146\157\162\155\141\x74\x3a\165\156\163\160\x65\x63\x69\x66\151\145\144";
            goto lH;
            hI:
            $Ab = $Be->getAttribute("\x4e\x61\155\145\106\157\162\x6d\x61\164");
            lH:
            if ($qc) {
                goto rD;
            }
            if (!($this->nameFormat !== $Ab)) {
                goto eq;
            }
            $this->nameFormat = "\x75\x72\156\72\x6f\x61\x73\151\163\72\156\141\x6d\145\163\72\164\x63\72\123\x41\x4d\114\x3a\x32\x2e\x30\x3a\x61\164\164\x72\156\141\155\145\x2d\x66\x6f\162\x6d\141\164\72\165\x6e\x73\160\x65\x63\151\146\x69\145\x64";
            eq:
            goto MY;
            rD:
            $this->nameFormat = $Ab;
            $qc = FALSE;
            MY:
            if (array_key_exists($Ex, $this->attributes)) {
                goto uj;
            }
            $this->attributes[$Ex] = array();
            uj:
            $ga = Utilities::xpQuery($Be, "\56\57\163\141\x6d\154\x5f\141\x73\x73\145\162\164\x69\157\156\72\x41\164\x74\162\151\142\165\164\x65\x56\x61\154\165\x65");
            foreach ($ga as $Ng) {
                $this->attributes[$Ex][] = trim($Ng->textContent);
                aO:
            }
            YJ:
            jc:
        }
        Ll:
    }
    public function getNotBefore()
    {
        return $this->notBefore;
    }
    public function setNotBefore($GE)
    {
        $this->notBefore = $GE;
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($jE)
    {
        $this->notOnOrAfter = $jE;
    }
    public function setEncryptedAttributes($cr)
    {
        $this->requiredEncAttributes = $cr;
    }
    public function getValidAudiences()
    {
        return $this->validAudiences;
    }
    public function setValidAudiences(array $tN = NULL)
    {
        $this->validAudiences = $tN;
    }
    public function getAuthnInstant()
    {
        return $this->authnInstant;
    }
    public function setAuthnInstant($x0)
    {
        $this->authnInstant = $x0;
    }
    public function getSessionNotOnOrAfter()
    {
        return $this->sessionNotOnOrAfter;
    }
    public function setSessionNotOnOrAfter($M4)
    {
        $this->sessionNotOnOrAfter = $M4;
    }
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }
    public function setSessionIndex($q1)
    {
        $this->sessionIndex = $q1;
    }
    public function getAuthnContext()
    {
        if (empty($this->authnContextClassRef)) {
            goto K0;
        }
        return $this->authnContextClassRef;
        K0:
        if (empty($this->authnContextDeclRef)) {
            goto uO;
        }
        return $this->authnContextDeclRef;
        uO:
        return NULL;
    }
    public function setAuthnContext($uf)
    {
        $this->setAuthnContextClassRef($uf);
    }
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }
    public function setAuthnContextClassRef($P5)
    {
        $this->authnContextClassRef = $P5;
    }
    public function setAuthnContextDecl(SAML2_XML_Chunk $QN)
    {
        if (empty($this->authnContextDeclRef)) {
            goto VT;
        }
        throw new Exception("\x41\165\164\150\x6e\x43\x6f\156\x74\x65\170\x74\x44\x65\x63\154\122\x65\x66\x20\151\x73\40\x61\154\162\145\141\x64\171\x20\x72\145\147\x69\163\x74\x65\162\x65\144\x21\x20\115\141\171\40\x6f\156\154\171\x20\150\141\x76\x65\x20\x65\x69\164\x68\145\162\40\x61\x20\104\x65\143\x6c\x20\x6f\162\x20\141\x20\x44\145\x63\x6c\122\145\x66\x2c\40\156\157\x74\40\x62\x6f\164\150\x21");
        VT:
        $this->authnContextDecl = $QN;
    }
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }
    public function setAuthnContextDeclRef($Qi)
    {
        if (empty($this->authnContextDecl)) {
            goto hp;
        }
        throw new Exception("\101\x75\x74\150\x6e\x43\157\x6e\x74\145\170\x74\x44\x65\x63\x6c\40\x69\163\x20\141\x6c\162\x65\141\x64\x79\x20\162\145\147\x69\163\164\145\x72\145\x64\41\x20\115\x61\171\40\157\x6e\154\171\x20\x68\x61\166\145\x20\x65\x69\x74\x68\145\162\40\x61\40\104\x65\143\x6c\40\x6f\x72\40\141\40\104\145\x63\x6c\x52\145\x66\54\40\x6e\157\x74\x20\142\157\x74\x68\x21");
        hp:
        $this->authnContextDeclRef = $Qi;
    }
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }
    public function getAuthenticatingAuthority()
    {
        return $this->AuthenticatingAuthority;
    }
    public function setAuthenticatingAuthority($e1)
    {
        $this->AuthenticatingAuthority = $e1;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttributes(array $Zf)
    {
        $this->attributes = $Zf;
    }
    public function getAttributeNameFormat()
    {
        return $this->nameFormat;
    }
    public function setAttributeNameFormat($Ab)
    {
        $this->nameFormat = $Ab;
    }
    public function getSubjectConfirmation()
    {
        return $this->SubjectConfirmation;
    }
    public function setSubjectConfirmation(array $Ec)
    {
        $this->SubjectConfirmation = $Ec;
    }
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }
    public function setSignatureKey(XMLsecurityKey $S9 = NULL)
    {
        $this->signatureKey = $S9;
    }
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
    public function setEncryptionKey(XMLSecurityKey $sk = NULL)
    {
        $this->encryptionKey = $sk;
    }
    public function setCertificates(array $V_)
    {
        $this->certificates = $V_;
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
    public function toXML(DOMNode $up = NULL)
    {
        if ($up === NULL) {
            goto go;
        }
        $Mo = $up->ownerDocument;
        goto zO;
        go:
        $Mo = new DOMDocument();
        $up = $Mo;
        zO:
        $Ii = $Mo->createElementNS("\x75\x72\156\x3a\157\141\163\151\x73\x3a\x6e\141\155\x65\x73\72\164\143\72\x53\101\x4d\114\72\x32\56\60\x3a\x61\x73\x73\x65\162\164\151\x6f\x6e", "\163\x61\x6d\x6c\72" . "\x41\x73\x73\x65\x72\x74\x69\157\x6e");
        $up->appendChild($Ii);
        $Ii->setAttributeNS("\165\x72\x6e\72\x6f\141\x73\x69\x73\72\156\141\x6d\145\163\x3a\164\x63\72\123\x41\x4d\x4c\x3a\x32\x2e\60\x3a\x70\162\157\x74\157\143\x6f\x6c", "\163\x61\155\154\160\x3a\x74\155\160", "\164\x6d\x70");
        $Ii->removeAttributeNS("\165\162\156\72\x6f\141\x73\x69\x73\72\x6e\141\155\x65\x73\72\164\143\72\123\x41\x4d\114\72\62\x2e\60\72\x70\x72\157\164\157\x63\157\x6c", "\164\x6d\160");
        $Ii->setAttributeNS("\150\x74\x74\x70\x3a\x2f\57\167\x77\x77\56\167\63\56\157\x72\147\x2f\62\x30\60\61\x2f\130\x4d\x4c\123\143\150\145\155\x61\55\151\156\163\x74\141\x6e\143\145", "\170\163\151\x3a\x74\x6d\x70", "\x74\x6d\160");
        $Ii->removeAttributeNS("\150\164\x74\x70\72\57\57\x77\167\x77\56\x77\63\x2e\x6f\162\147\x2f\x32\60\x30\61\x2f\x58\115\x4c\123\x63\x68\145\155\141\55\x69\156\163\x74\141\x6e\143\145", "\x74\155\x70");
        $Ii->setAttributeNS("\x68\164\164\x70\x3a\x2f\57\167\167\x77\x2e\x77\x33\56\157\162\147\57\x32\60\60\x31\57\x58\115\114\123\143\150\x65\155\141", "\x78\x73\x3a\x74\155\160", "\164\x6d\x70");
        $Ii->removeAttributeNS("\x68\x74\x74\160\72\57\x2f\167\x77\x77\x2e\x77\63\56\157\162\x67\x2f\x32\60\60\x31\57\x58\x4d\114\123\143\x68\x65\155\x61", "\x74\155\x70");
        $Ii->setAttribute("\x49\104", $this->id);
        $Ii->setAttribute("\126\x65\162\x73\151\157\156", "\x32\56\x30");
        $Ii->setAttribute("\111\x73\163\x75\x65\x49\x6e\163\x74\141\156\x74", gmdate("\131\x2d\x6d\x2d\144\134\x54\x48\72\x69\72\163\134\132", $this->issueInstant));
        $Jq = Utilities::addString($Ii, "\165\162\x6e\72\157\141\x73\x69\163\72\156\x61\155\x65\163\72\x74\x63\x3a\123\101\115\114\72\x32\x2e\60\x3a\x61\x73\x73\145\x72\x74\x69\157\x6e", "\163\141\x6d\154\72\x49\163\x73\165\x65\162", $this->issuer);
        $this->addSubject($Ii);
        $this->addConditions($Ii);
        $this->addAuthnStatement($Ii);
        if ($this->requiredEncAttributes == FALSE) {
            goto Ok;
        }
        $this->addEncryptedAttributeStatement($Ii);
        goto zm;
        Ok:
        $this->addAttributeStatement($Ii);
        zm:
        if (!($this->signatureKey !== NULL)) {
            goto Wq;
        }
        Utilities::insertSignature($this->signatureKey, $this->certificates, $Ii, $Jq->nextSibling);
        Wq:
        return $Ii;
    }
    private function addSubject(DOMElement $Ii)
    {
        if (!($this->nameId === NULL && $this->encryptedNameId === NULL)) {
            goto cu;
        }
        return;
        cu:
        $CJ = $Ii->ownerDocument->createElementNS("\x75\162\x6e\72\x6f\141\x73\151\x73\x3a\156\x61\155\145\163\72\164\x63\72\x53\x41\x4d\x4c\72\62\x2e\x30\x3a\141\163\x73\x65\162\x74\x69\157\156", "\163\x61\x6d\154\72\123\x75\142\152\145\x63\164");
        $Ii->appendChild($CJ);
        if ($this->encryptedNameId === NULL) {
            goto Xs;
        }
        $WP = $CJ->ownerDocument->createElementNS("\165\162\x6e\72\x6f\141\x73\151\x73\72\x6e\141\x6d\145\163\72\164\x63\x3a\123\101\115\x4c\72\x32\x2e\x30\x3a\x61\x73\x73\145\x72\x74\151\x6f\x6e", "\x73\141\155\x6c\x3a" . "\x45\x6e\x63\x72\x79\x70\x74\x65\x64\111\x44");
        $CJ->appendChild($WP);
        $WP->appendChild($CJ->ownerDocument->importNode($this->encryptedNameId, TRUE));
        goto oM;
        Xs:
        Utilities::addNameId($CJ, $this->nameId);
        oM:
        foreach ($this->SubjectConfirmation as $VA) {
            $VA->toXML($CJ);
            Ye:
        }
        Uj:
    }
    private function addConditions(DOMElement $Ii)
    {
        $Mo = $Ii->ownerDocument;
        $xh = $Mo->createElementNS("\165\x72\x6e\72\157\141\163\151\x73\72\x6e\141\x6d\x65\x73\72\x74\x63\72\x53\101\115\x4c\72\x32\x2e\60\72\141\163\x73\x65\x72\x74\151\157\x6e", "\x73\141\155\154\x3a\x43\x6f\x6e\144\x69\164\151\157\x6e\163");
        $Ii->appendChild($xh);
        if (!($this->notBefore !== NULL)) {
            goto Zz;
        }
        $xh->setAttribute("\x4e\157\x74\x42\x65\x66\157\162\145", gmdate("\x59\55\155\55\x64\134\124\x48\x3a\151\x3a\x73\134\x5a", $this->notBefore));
        Zz:
        if (!($this->notOnOrAfter !== NULL)) {
            goto uP;
        }
        $xh->setAttribute("\x4e\x6f\164\x4f\156\x4f\162\101\146\x74\145\162", gmdate("\131\55\155\x2d\144\134\x54\x48\72\x69\72\163\x5c\132", $this->notOnOrAfter));
        uP:
        if (!($this->validAudiences !== NULL)) {
            goto LK;
        }
        $y6 = $Mo->createElementNS("\165\x72\156\x3a\x6f\x61\163\151\163\72\x6e\141\x6d\145\x73\x3a\164\x63\72\123\x41\115\114\72\62\56\60\x3a\x61\163\x73\145\x72\x74\151\157\x6e", "\163\141\x6d\154\x3a\101\x75\x64\x69\x65\156\x63\145\122\145\163\164\162\151\143\164\x69\157\156");
        $xh->appendChild($y6);
        Utilities::addStrings($y6, "\165\162\x6e\72\x6f\141\163\151\x73\x3a\x6e\141\x6d\145\163\x3a\x74\x63\72\123\101\x4d\x4c\72\62\x2e\x30\72\141\x73\x73\x65\162\164\x69\x6f\x6e", "\163\x61\155\x6c\72\101\165\144\x69\145\156\143\145", FALSE, $this->validAudiences);
        LK:
    }
    private function addAuthnStatement(DOMElement $Ii)
    {
        if (!($this->authnInstant === NULL || $this->authnContextClassRef === NULL && $this->authnContextDecl === NULL && $this->authnContextDeclRef === NULL)) {
            goto k9;
        }
        return;
        k9:
        $Mo = $Ii->ownerDocument;
        $OL = $Mo->createElementNS("\x75\x72\156\72\x6f\141\163\x69\x73\72\156\141\x6d\145\163\x3a\164\x63\x3a\123\101\x4d\114\72\x32\x2e\x30\72\x61\163\163\x65\x72\x74\x69\x6f\x6e", "\x73\141\x6d\x6c\72\101\x75\x74\x68\156\123\164\141\x74\x65\x6d\145\x6e\x74");
        $Ii->appendChild($OL);
        $OL->setAttribute("\101\x75\164\150\156\111\x6e\x73\x74\141\156\x74", gmdate("\131\55\155\x2d\144\134\124\110\x3a\151\72\x73\134\132", $this->authnInstant));
        if (!($this->sessionNotOnOrAfter !== NULL)) {
            goto B3;
        }
        $OL->setAttribute("\x53\145\163\x73\x69\157\x6e\x4e\157\x74\117\x6e\x4f\162\101\x66\164\x65\162", gmdate("\131\x2d\155\55\144\134\x54\110\x3a\151\x3a\x73\x5c\x5a", $this->sessionNotOnOrAfter));
        B3:
        if (!($this->sessionIndex !== NULL)) {
            goto mZ;
        }
        $OL->setAttribute("\x53\x65\163\x73\151\157\x6e\111\x6e\x64\145\x78", $this->sessionIndex);
        mZ:
        $m4 = $Mo->createElementNS("\165\162\x6e\72\157\x61\163\151\163\72\x6e\x61\x6d\x65\x73\72\x74\x63\72\x53\101\x4d\x4c\x3a\62\x2e\x30\x3a\141\x73\x73\145\162\x74\151\x6f\x6e", "\163\x61\155\154\x3a\x41\x75\x74\150\x6e\103\157\x6e\164\x65\170\x74");
        $OL->appendChild($m4);
        if (empty($this->authnContextClassRef)) {
            goto Su;
        }
        Utilities::addString($m4, "\165\x72\x6e\x3a\157\141\x73\151\x73\x3a\156\x61\x6d\145\x73\x3a\164\143\72\123\101\x4d\114\x3a\x32\x2e\60\72\141\163\163\145\162\x74\151\x6f\x6e", "\x73\x61\x6d\154\x3a\101\x75\x74\x68\x6e\x43\x6f\x6e\x74\145\x78\164\x43\x6c\x61\163\163\x52\145\146", $this->authnContextClassRef);
        Su:
        if (empty($this->authnContextDecl)) {
            goto zl;
        }
        $this->authnContextDecl->toXML($m4);
        zl:
        if (empty($this->authnContextDeclRef)) {
            goto Sq;
        }
        Utilities::addString($m4, "\x75\x72\156\72\x6f\x61\163\151\x73\72\x6e\141\155\x65\x73\72\164\x63\x3a\123\x41\115\x4c\72\x32\56\x30\x3a\x61\x73\x73\145\162\x74\151\157\x6e", "\163\x61\155\x6c\x3a\101\165\164\150\x6e\x43\x6f\156\164\145\x78\164\104\145\143\154\x52\145\x66", $this->authnContextDeclRef);
        Sq:
        Utilities::addStrings($m4, "\165\x72\156\72\x6f\x61\x73\x69\163\x3a\x6e\141\x6d\x65\x73\72\164\x63\72\x53\101\115\114\x3a\62\56\x30\72\141\163\163\x65\162\164\x69\x6f\x6e", "\x73\141\155\x6c\x3a\101\165\164\150\x65\x6e\164\151\143\141\164\151\x6e\x67\x41\165\164\x68\157\x72\151\x74\x79", FALSE, $this->AuthenticatingAuthority);
    }
    private function addAttributeStatement(DOMElement $Ii)
    {
        if (!empty($this->attributes)) {
            goto Va;
        }
        return;
        Va:
        $Mo = $Ii->ownerDocument;
        $om = $Mo->createElementNS("\x75\x72\156\72\157\x61\163\151\163\72\x6e\x61\155\x65\x73\72\x74\x63\x3a\x53\101\115\114\x3a\62\56\x30\x3a\141\x73\x73\x65\162\164\x69\157\x6e", "\x73\x61\x6d\x6c\72\101\x74\x74\x72\x69\x62\x75\x74\145\x53\164\141\164\145\155\145\156\x74");
        $Ii->appendChild($om);
        foreach ($this->attributes as $Ex => $ga) {
            $Be = $Mo->createElementNS("\x75\162\156\72\x6f\x61\163\151\x73\x3a\x6e\141\x6d\145\163\x3a\x74\143\72\123\x41\x4d\114\x3a\x32\56\x30\72\141\163\163\x65\162\x74\151\157\x6e", "\x73\141\x6d\154\72\x41\164\164\x72\x69\142\x75\x74\x65");
            $om->appendChild($Be);
            $Be->setAttribute("\116\141\155\145", $Ex);
            if (!($this->nameFormat !== "\165\162\x6e\72\x6f\141\163\151\163\x3a\x6e\141\x6d\145\163\72\x74\x63\x3a\x53\x41\x4d\114\72\62\x2e\60\72\141\164\164\162\156\141\155\145\x2d\146\157\x72\x6d\141\x74\x3a\165\156\x73\160\145\x63\151\x66\151\x65\144")) {
                goto C3;
            }
            $Be->setAttribute("\x4e\141\x6d\145\106\157\x72\155\141\164", $this->nameFormat);
            C3:
            foreach ($ga as $Ng) {
                if (is_string($Ng)) {
                    goto PA;
                }
                if (is_int($Ng)) {
                    goto jl;
                }
                $WK = NULL;
                goto f_;
                PA:
                $WK = "\170\163\x3a\163\x74\162\x69\x6e\147";
                goto f_;
                jl:
                $WK = "\170\x73\x3a\151\x6e\x74\145\147\145\x72";
                f_:
                $r_ = $Mo->createElementNS("\165\x72\156\x3a\x6f\141\163\151\163\72\x6e\141\155\145\163\72\x74\143\72\123\101\115\114\x3a\x32\56\60\72\x61\163\x73\x65\x72\164\x69\x6f\x6e", "\163\141\155\154\72\x41\x74\164\162\151\x62\x75\x74\145\126\x61\x6c\x75\x65");
                $Be->appendChild($r_);
                if (!($WK !== NULL)) {
                    goto Jd;
                }
                $r_->setAttributeNS("\150\164\x74\160\x3a\x2f\57\167\x77\x77\56\167\x33\56\157\162\147\57\62\60\60\61\x2f\x58\115\x4c\x53\x63\150\145\155\x61\55\151\x6e\x73\x74\x61\156\x63\x65", "\170\x73\x69\72\164\x79\160\145", $WK);
                Jd:
                if (!is_null($Ng)) {
                    goto td;
                }
                $r_->setAttributeNS("\150\164\164\160\72\57\x2f\167\167\x77\56\167\63\x2e\x6f\x72\x67\57\62\60\x30\61\57\x58\115\114\123\x63\150\x65\155\141\x2d\151\x6e\163\x74\x61\x6e\x63\145", "\x78\x73\x69\72\x6e\151\x6c", "\x74\x72\165\x65");
                td:
                if ($Ng instanceof DOMNodeList) {
                    goto sJ;
                }
                $r_->appendChild($Mo->createTextNode($Ng));
                goto Nv;
                sJ:
                $Sg = 0;
                tj:
                if (!($Sg < $Ng->length)) {
                    goto ir;
                }
                $xi = $Mo->importNode($Ng->item($Sg), TRUE);
                $r_->appendChild($xi);
                ce:
                $Sg++;
                goto tj;
                ir:
                Nv:
                ky:
            }
            kY:
            lU:
        }
        Q3:
    }
    private function addEncryptedAttributeStatement(DOMElement $Ii)
    {
        if (!($this->requiredEncAttributes == FALSE)) {
            goto U8;
        }
        return;
        U8:
        $Mo = $Ii->ownerDocument;
        $om = $Mo->createElementNS("\x75\x72\x6e\x3a\x6f\141\x73\151\163\x3a\156\x61\x6d\145\x73\x3a\x74\x63\72\x53\x41\115\x4c\x3a\62\x2e\x30\72\141\163\x73\x65\x72\x74\x69\x6f\156", "\163\141\x6d\x6c\72\x41\164\164\x72\151\x62\165\x74\x65\x53\x74\x61\164\145\155\x65\x6e\164");
        $Ii->appendChild($om);
        foreach ($this->attributes as $Ex => $ga) {
            $DX = new DOMDocument();
            $Be = $DX->createElementNS("\165\162\156\72\x6f\141\163\x69\x73\72\156\x61\x6d\145\x73\x3a\x74\143\72\123\x41\115\114\x3a\x32\56\60\x3a\x61\x73\163\x65\162\x74\x69\157\156", "\x73\x61\155\154\x3a\101\164\x74\x72\x69\x62\165\x74\145");
            $Be->setAttribute("\116\141\x6d\145", $Ex);
            $DX->appendChild($Be);
            if (!($this->nameFormat !== "\x75\162\x6e\x3a\157\x61\x73\151\x73\72\156\141\x6d\x65\x73\72\164\143\72\123\x41\115\114\72\62\x2e\x30\x3a\x61\164\164\162\x6e\141\x6d\x65\55\146\x6f\x72\x6d\141\164\72\165\x6e\163\160\145\x63\151\x66\x69\x65\x64")) {
                goto ym;
            }
            $Be->setAttribute("\116\x61\x6d\x65\x46\x6f\x72\155\x61\x74", $this->nameFormat);
            ym:
            foreach ($ga as $Ng) {
                if (is_string($Ng)) {
                    goto AL;
                }
                if (is_int($Ng)) {
                    goto ME;
                }
                $WK = NULL;
                goto j3;
                AL:
                $WK = "\x78\163\x3a\x73\164\x72\x69\156\147";
                goto j3;
                ME:
                $WK = "\x78\x73\72\151\156\x74\x65\147\x65\162";
                j3:
                $r_ = $DX->createElementNS("\x75\162\x6e\72\x6f\141\163\151\x73\x3a\x6e\x61\155\145\163\x3a\x74\x63\x3a\x53\x41\115\x4c\x3a\x32\x2e\60\72\x61\163\x73\145\162\x74\151\157\156", "\x73\141\155\154\72\101\x74\164\x72\x69\x62\165\164\x65\x56\141\154\165\145");
                $Be->appendChild($r_);
                if (!($WK !== NULL)) {
                    goto Gw;
                }
                $r_->setAttributeNS("\x68\x74\164\x70\72\x2f\x2f\x77\x77\167\x2e\167\x33\x2e\x6f\x72\x67\57\62\60\60\61\57\x58\x4d\x4c\123\143\x68\x65\x6d\x61\55\151\156\x73\x74\141\x6e\x63\x65", "\170\x73\x69\x3a\x74\x79\x70\x65", $WK);
                Gw:
                if ($Ng instanceof DOMNodeList) {
                    goto Q2;
                }
                $r_->appendChild($DX->createTextNode($Ng));
                goto A4;
                Q2:
                $Sg = 0;
                wU:
                if (!($Sg < $Ng->length)) {
                    goto rt;
                }
                $xi = $DX->importNode($Ng->item($Sg), TRUE);
                $r_->appendChild($xi);
                t7:
                $Sg++;
                goto wU;
                rt:
                A4:
                jA:
            }
            ZL:
            $r8 = new XMLSecEnc();
            $r8->setNode($DX->documentElement);
            $r8->type = "\x68\x74\x74\160\72\x2f\x2f\x77\x77\167\x2e\x77\63\56\x6f\x72\147\57\x32\x30\60\x31\57\x30\x34\57\x78\155\154\x65\x6e\x63\x23\105\154\x65\155\145\156\164";
            $bn = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
            $bn->generateSessionKey();
            $r8->encryptKey($this->encryptionKey, $bn);
            $gV = $r8->encryptNode($bn);
            $tw = $Mo->createElementNS("\x75\x72\156\x3a\x6f\141\163\x69\x73\x3a\x6e\x61\155\x65\163\x3a\x74\143\x3a\x53\x41\115\x4c\72\x32\x2e\x30\x3a\141\x73\x73\x65\x72\164\151\x6f\x6e", "\163\x61\155\154\x3a\x45\x6e\x63\162\x79\x70\164\x65\x64\x41\x74\x74\x72\151\142\165\x74\x65");
            $om->appendChild($tw);
            $sK = $Mo->importNode($gV, TRUE);
            $tw->appendChild($sK);
            xh:
        }
        xU:
    }
    public function getPrivateKeyUrl()
    {
        return $this->privateKeyUrl;
    }
    public function setPrivateKeyUrl($nZ)
    {
        $this->privateKeyUrl = $nZ;
    }
}
