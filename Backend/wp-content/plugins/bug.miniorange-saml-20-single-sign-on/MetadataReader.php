<?php


include_once "\125\164\151\154\151\x74\x69\x65\163\x2e\x70\150\160";
class MetadataReader
{
    private $identityProviders;
    private $serviceProviders;
    public function __construct(DOMNode $DH = NULL)
    {
        $this->identityProviders = array();
        $this->serviceProviders = array();
        $Mq = Utilities::xpQuery($DH, "\x2e\57\x73\141\x6d\x6c\x5f\155\145\x74\141\x64\141\x74\x61\72\105\156\164\151\164\x69\145\x73\x44\145\x73\x63\162\151\x70\x74\157\162");
        if (!empty($Mq)) {
            goto pj;
        }
        $fr = Utilities::xpQuery($DH, "\56\57\163\x61\155\x6c\x5f\x6d\145\x74\x61\144\141\x74\141\x3a\105\x6e\164\x69\x74\x79\104\x65\x73\143\x72\151\160\x74\x6f\x72");
        goto ge;
        pj:
        $fr = Utilities::xpQuery($Mq[0], "\56\x2f\x73\x61\155\x6c\137\155\x65\x74\x61\x64\141\164\x61\72\105\x6e\x74\151\164\x79\104\x65\x73\143\x72\x69\160\x74\157\x72");
        ge:
        foreach ($fr as $wn) {
            $e_ = Utilities::xpQuery($wn, "\56\57\x73\141\155\x6c\x5f\155\145\164\x61\x64\141\x74\x61\72\x49\104\x50\123\x53\117\x44\145\163\143\162\x69\x70\x74\157\x72");
            if (!(isset($e_) && !empty($e_))) {
                goto Wz;
            }
            array_push($this->identityProviders, new IdentityProviders($wn));
            Wz:
            LH:
        }
        UH:
    }
    public function getIdentityProviders()
    {
        return $this->identityProviders;
    }
    public function getServiceProviders()
    {
        return $this->serviceProviders;
    }
}
class IdentityProviders
{
    private $idpName;
    private $entityID;
    private $loginDetails;
    private $logoutDetails;
    private $signingCertificate;
    private $encryptionCertificate;
    private $signedRequest;
    private $loginbinding;
    private $logoutbinding;
    public function __construct(DOMElement $DH = NULL)
    {
        $this->idpName = '';
        $this->loginDetails = array();
        $this->logoutDetails = array();
        $this->signingCertificate = array();
        $this->encryptionCertificate = array();
        if (!$DH->hasAttribute("\x65\156\164\x69\164\x79\x49\x44")) {
            goto xm;
        }
        $this->entityID = $DH->getAttribute("\145\156\164\x69\x74\171\x49\x44");
        xm:
        if (!$DH->hasAttribute("\x57\x61\156\164\101\x75\164\x68\x6e\x52\x65\x71\165\145\x73\x74\x73\x53\x69\x67\x6e\145\144")) {
            goto J8;
        }
        $this->signedRequest = $DH->getAttribute("\x57\x61\x6e\x74\x41\165\164\150\156\122\x65\x71\165\x65\x73\164\x73\123\x69\147\156\145\144");
        J8:
        $e_ = Utilities::xpQuery($DH, "\56\x2f\163\141\155\x6c\x5f\155\x65\x74\141\144\x61\164\x61\72\111\104\x50\x53\123\x4f\x44\x65\163\143\162\x69\160\x74\157\x72");
        if (count($e_) > 1) {
            goto CM;
        }
        if (empty($e_)) {
            goto o7;
        }
        goto tJ;
        CM:
        throw new Exception("\x4d\x6f\162\145\40\164\x68\141\156\40\157\156\x65\40\x3c\x49\104\x50\x53\x53\x4f\x44\145\163\x63\162\x69\160\164\x6f\162\76\40\151\x6e\40\x3c\x45\156\164\151\x74\171\x44\145\163\143\x72\151\160\164\157\162\76\x2e");
        goto tJ;
        o7:
        throw new Exception("\115\151\x73\x73\x69\x6e\147\40\x72\x65\161\165\x69\x72\145\144\40\74\x49\104\x50\123\123\x4f\x44\145\163\143\x72\151\x70\x74\157\x72\76\x20\151\x6e\x20\74\105\156\x74\151\164\171\x44\x65\163\143\162\151\x70\x74\157\162\76\x2e");
        tJ:
        $P8 = $e_[0];
        $nq = Utilities::xpQuery($DH, "\x2e\57\x73\x61\155\154\137\x6d\145\164\141\144\x61\x74\x61\72\x45\170\x74\x65\x6e\x73\151\157\x6e\x73");
        if (!$nq) {
            goto PT;
        }
        $this->parseInfo($P8);
        PT:
        $this->parseSSOService($P8);
        $this->parseSLOService($P8);
        $this->parsex509Certificate($P8);
    }
    private function parseInfo($DH)
    {
        $jy = Utilities::xpQuery($DH, "\56\57\x6d\x64\x75\151\x3a\x55\111\x49\156\146\157\57\x6d\x64\165\151\72\104\151\x73\x70\154\x61\x79\116\141\155\145");
        foreach ($jy as $BT) {
            if (!($BT->hasAttribute("\170\x6d\154\x3a\x6c\141\x6e\x67") && $BT->getAttribute("\x78\155\154\x3a\x6c\x61\156\x67") == "\x65\x6e")) {
                goto kR;
            }
            $this->idpName = $BT->textContent;
            kR:
            Rq:
        }
        Rs:
    }
    private function parseSSOService($DH)
    {
        $pB = Utilities::xpQuery($DH, "\x2e\x2f\163\141\155\154\137\155\x65\x74\x61\144\141\164\x61\x3a\123\151\156\147\x6c\145\x53\151\x67\156\x4f\156\123\145\162\166\151\143\145");
        $h1 = 0;
        foreach ($pB as $xV) {
            $R1 = str_replace("\165\x72\x6e\x3a\157\x61\x73\151\x73\72\x6e\141\x6d\x65\x73\72\164\143\72\x53\101\115\114\72\62\56\60\x3a\142\x69\x6e\x64\151\x6e\x67\163\x3a", '', $xV->getAttribute("\x42\151\x6e\144\x69\156\x67"));
            $this->loginDetails = array_merge($this->loginDetails, array($R1 => $xV->getAttribute("\x4c\157\143\141\x74\151\157\x6e")));
            if (!($R1 == "\110\x54\x54\x50\x2d\x52\x65\x64\151\162\145\x63\164")) {
                goto iH;
            }
            $h1 = 1;
            $this->loginbinding = "\110\164\164\x70\x52\145\144\151\x72\145\143\164";
            iH:
            pe:
        }
        YW:
        if ($h1) {
            goto p7;
        }
        $this->loginbinding = "\110\164\164\x70\x50\x6f\x73\164";
        p7:
    }
    private function parseSLOService($DH)
    {
        $h1 = 0;
        $Da = Utilities::xpQuery($DH, "\56\57\x73\141\155\x6c\x5f\x6d\145\164\141\x64\141\164\x61\72\123\x69\x6e\147\x6c\x65\x4c\157\147\157\165\x74\123\x65\x72\x76\151\143\145");
        foreach ($Da as $cK) {
            $R1 = str_replace("\165\162\x6e\x3a\157\141\x73\x69\163\x3a\x6e\x61\x6d\145\163\x3a\x74\143\72\123\101\x4d\x4c\x3a\62\56\x30\72\x62\151\x6e\x64\151\156\x67\x73\72", '', $cK->getAttribute("\x42\151\x6e\x64\151\156\x67"));
            $this->logoutDetails = array_merge($this->logoutDetails, array($R1 => $cK->getAttribute("\114\157\143\141\x74\151\x6f\x6e")));
            if (!($R1 == "\110\x54\x54\x50\55\122\x65\144\151\x72\145\x63\164")) {
                goto JR;
            }
            $h1 = 1;
            $this->logoutbinding = "\110\164\x74\160\122\x65\144\x69\162\145\143\x74";
            JR:
            mE:
        }
        Tf:
        if (!empty($this->logoutbinding)) {
            goto fI;
        }
        $this->logoutbinding = "\110\x74\164\160\120\157\x73\x74";
        fI:
    }
    private function parsex509Certificate($DH)
    {
        foreach (Utilities::xpQuery($DH, "\x2e\57\163\141\x6d\x6c\x5f\155\145\164\141\144\x61\164\141\72\113\145\171\104\145\x73\143\x72\151\160\164\x6f\x72") as $Wf) {
            if ($Wf->hasAttribute("\x75\x73\145")) {
                goto Ze;
            }
            $this->parseSigningCertificate($Wf);
            goto Ad;
            Ze:
            if ($Wf->getAttribute("\165\163\145") == "\145\x6e\x63\162\171\x70\x74\151\x6f\156") {
                goto cP;
            }
            $this->parseSigningCertificate($Wf);
            goto mp;
            cP:
            $this->parseEncryptionCertificate($Wf);
            mp:
            Ad:
            Uw:
        }
        ua:
    }
    private function parseSigningCertificate($DH)
    {
        $r2 = Utilities::xpQuery($DH, "\56\x2f\144\163\72\113\145\x79\x49\156\146\x6f\x2f\x64\163\x3a\x58\65\x30\x39\104\141\x74\x61\x2f\x64\x73\72\130\x35\60\71\x43\x65\x72\x74\151\x66\x69\x63\141\x74\x65");
        $mE = trim($r2[0]->textContent);
        $mE = str_replace(array("\xd", "\xa", "\x9", "\40"), '', $mE);
        if (empty($r2)) {
            goto gY;
        }
        array_push($this->signingCertificate, $mE);
        gY:
    }
    private function parseEncryptionCertificate($DH)
    {
        $r2 = Utilities::xpQuery($DH, "\x2e\57\144\x73\x3a\x4b\x65\171\111\156\146\157\57\x64\x73\72\x58\x35\x30\71\104\x61\x74\141\57\144\163\x3a\130\65\x30\71\103\145\x72\x74\x69\x66\151\143\141\164\145");
        $mE = trim($r2[0]->textContent);
        $mE = str_replace(array("\xd", "\12", "\x9", "\40"), '', $mE);
        if (empty($r2)) {
            goto oH;
        }
        array_push($this->encryptionCertificate, $mE);
        oH:
    }
    public function getIdpName()
    {
        return $this->idpName;
    }
    public function getEntityID()
    {
        return $this->entityID;
    }
    public function getLoginURL($R1)
    {
        return $this->loginDetails[$R1];
    }
    public function getLogoutURL($R1)
    {
        return $this->logoutDetails[$R1];
    }
    public function getLoginDetails()
    {
        return $this->loginDetails;
    }
    public function getLogoutDetails()
    {
        return $this->logoutDetails;
    }
    public function getSigningCertificate()
    {
        return $this->signingCertificate;
    }
    public function getEncryptionCertificate()
    {
        return $this->encryptionCertificate[0];
    }
    public function isRequestSigned()
    {
        return $this->signedRequest;
    }
    public function getBindingLogin()
    {
        return $this->loginbinding;
    }
    public function getBindingLogout()
    {
        return $this->logoutbinding;
    }
}
class ServiceProviders
{
}
