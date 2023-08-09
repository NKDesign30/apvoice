<?php


include_once "\x55\164\151\154\151\x74\x69\145\163\56\160\150\x70";
class MetadataReader
{
    private $identityProviders;
    private $serviceProviders;
    public function __construct(DOMNode $rd = NULL)
    {
        $this->identityProviders = array();
        $this->serviceProviders = array();
        $QZ = Utilities::xpQuery($rd, "\x2e\x2f\163\141\x6d\154\137\155\145\164\141\x64\141\164\x61\x3a\105\x6e\x74\x69\x74\x69\x65\163\x44\145\163\x63\x72\151\160\x74\157\x72");
        if (!empty($QZ)) {
            goto Gi;
        }
        $BK = Utilities::xpQuery($rd, "\x2e\57\163\141\x6d\154\x5f\155\145\164\141\x64\141\164\x61\72\x45\156\x74\151\x74\x79\104\145\163\x63\162\151\x70\164\x6f\x72");
        goto x9;
        Gi:
        $BK = Utilities::xpQuery($QZ[0], "\x2e\57\x73\141\x6d\x6c\x5f\155\145\164\x61\144\x61\164\141\72\x45\156\164\151\x74\x79\104\x65\x73\x63\162\x69\x70\164\x6f\x72");
        x9:
        foreach ($BK as $jK) {
            $D6 = Utilities::xpQuery($jK, "\x2e\x2f\x73\x61\155\154\x5f\x6d\145\164\x61\144\x61\164\x61\72\111\104\x50\123\123\117\104\x65\163\143\162\151\x70\x74\157\162");
            if (!(isset($D6) && !empty($D6))) {
                goto TK;
            }
            array_push($this->identityProviders, new IdentityProviders($jK));
            TK:
            nJ:
        }
        mf:
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
    public function __construct(DOMElement $rd = NULL)
    {
        $this->idpName = '';
        $this->loginDetails = array();
        $this->logoutDetails = array();
        $this->signingCertificate = array();
        $this->encryptionCertificate = array();
        if (!$rd->hasAttribute("\145\156\164\151\164\x79\x49\104")) {
            goto KA;
        }
        $this->entityID = $rd->getAttribute("\145\x6e\x74\x69\x74\x79\x49\104");
        KA:
        if (!$rd->hasAttribute("\127\x61\x6e\164\x41\165\x74\150\x6e\x52\x65\161\165\145\163\x74\x73\x53\x69\x67\x6e\145\x64")) {
            goto jq;
        }
        $this->signedRequest = $rd->getAttribute("\127\141\156\x74\101\165\x74\x68\156\x52\x65\161\165\x65\x73\164\x73\x53\x69\x67\x6e\x65\x64");
        jq:
        $D6 = Utilities::xpQuery($rd, "\56\57\163\x61\155\x6c\137\x6d\145\164\141\x64\x61\164\x61\x3a\111\104\120\x53\123\117\x44\145\163\143\x72\x69\160\164\157\162");
        if (count($D6) > 1) {
            goto ts;
        }
        if (empty($D6)) {
            goto Zl;
        }
        goto X2;
        ts:
        throw new Exception("\x4d\157\x72\145\40\164\x68\x61\x6e\40\x6f\156\x65\x20\x3c\x49\x44\x50\x53\123\117\104\x65\163\x63\x72\x69\160\164\157\162\x3e\x20\151\x6e\40\74\105\156\164\151\164\171\104\x65\163\x63\x72\x69\160\164\x6f\162\x3e\x2e");
        goto X2;
        Zl:
        throw new Exception("\115\x69\163\x73\151\x6e\147\x20\162\x65\x71\x75\x69\162\x65\x64\40\74\111\x44\x50\123\123\x4f\x44\145\163\x63\x72\x69\x70\164\x6f\162\76\x20\x69\x6e\40\74\x45\156\x74\x69\164\x79\x44\x65\163\x63\162\151\160\x74\x6f\162\x3e\56");
        X2:
        $FC = $D6[0];
        $oF = Utilities::xpQuery($rd, "\56\x2f\163\x61\155\x6c\x5f\155\x65\164\141\x64\x61\164\x61\x3a\105\x78\164\145\x6e\163\x69\157\156\163");
        if (!$oF) {
            goto cC;
        }
        $this->parseInfo($FC);
        cC:
        $this->parseSSOService($FC);
        $this->parseSLOService($FC);
        $this->parsex509Certificate($FC);
    }
    private function parseInfo($rd)
    {
        $N6 = Utilities::xpQuery($rd, "\x2e\x2f\x6d\144\165\x69\72\x55\111\111\x6e\146\x6f\57\155\x64\x75\151\x3a\104\151\163\x70\x6c\x61\x79\x4e\x61\155\145");
        foreach ($N6 as $Ex) {
            if (!($Ex->hasAttribute("\x78\x6d\154\x3a\154\x61\x6e\x67") && $Ex->getAttribute("\170\x6d\154\72\x6c\x61\156\x67") == "\145\x6e")) {
                goto q1;
            }
            $this->idpName = $Ex->textContent;
            q1:
            bb:
        }
        OF:
    }
    private function parseSSOService($rd)
    {
        $WB = Utilities::xpQuery($rd, "\56\57\163\x61\155\154\137\155\145\164\141\144\x61\164\x61\72\x53\x69\x6e\x67\154\x65\123\x69\x67\x6e\117\156\x53\x65\162\166\151\143\145");
        $VY = 0;
        foreach ($WB as $q0) {
            $d5 = str_replace("\165\x72\x6e\72\x6f\x61\163\x69\163\x3a\156\141\x6d\145\x73\72\x74\143\72\x53\101\115\x4c\72\62\56\x30\x3a\x62\151\156\144\x69\x6e\147\x73\x3a", '', $q0->getAttribute("\102\151\156\144\151\x6e\x67"));
            $this->loginDetails = array_merge($this->loginDetails, array($d5 => $q0->getAttribute("\114\157\x63\141\164\x69\157\156")));
            if (!($d5 == "\x48\124\x54\x50\x2d\x52\x65\144\151\x72\x65\x63\x74")) {
                goto RB;
            }
            $VY = 1;
            $this->loginbinding = "\x48\x74\164\160\122\145\144\x69\162\x65\143\x74";
            RB:
            jg:
        }
        Fh:
        if ($VY) {
            goto Ey;
        }
        $this->loginbinding = "\110\x74\x74\x70\120\x6f\x73\164";
        Ey:
    }
    private function parseSLOService($rd)
    {
        $VY = 0;
        $E4 = Utilities::xpQuery($rd, "\56\57\x73\141\x6d\x6c\x5f\x6d\x65\164\141\144\141\x74\x61\72\123\151\156\x67\x6c\145\114\157\147\157\x75\164\x53\145\162\166\151\143\145");
        foreach ($E4 as $FY) {
            $d5 = str_replace("\165\x72\156\72\157\141\x73\151\x73\72\x6e\x61\x6d\x65\x73\x3a\x74\x63\x3a\123\x41\x4d\x4c\72\x32\x2e\x30\72\x62\x69\156\x64\x69\x6e\x67\x73\x3a", '', $FY->getAttribute("\102\x69\156\x64\151\x6e\x67"));
            $this->logoutDetails = array_merge($this->logoutDetails, array($d5 => $FY->getAttribute("\x4c\157\143\x61\x74\151\x6f\x6e")));
            if (!($d5 == "\x48\124\x54\120\55\122\145\x64\x69\x72\x65\143\164")) {
                goto on;
            }
            $VY = 1;
            $this->logoutbinding = "\110\164\x74\160\122\x65\144\x69\162\x65\143\x74";
            on:
            B5:
        }
        Hk:
        if (!empty($this->logoutbinding)) {
            goto lf;
        }
        $this->logoutbinding = "\x48\x74\164\160\x50\x6f\x73\164";
        lf:
    }
    private function parsex509Certificate($rd)
    {
        foreach (Utilities::xpQuery($rd, "\x2e\x2f\163\x61\155\x6c\x5f\x6d\x65\x74\141\144\x61\164\141\x3a\x4b\x65\171\104\145\163\x63\162\x69\160\x74\x6f\162") as $Au) {
            if ($Au->hasAttribute("\x75\x73\145")) {
                goto DM;
            }
            $this->parseSigningCertificate($Au);
            goto mC;
            DM:
            if ($Au->getAttribute("\165\163\145") == "\145\x6e\143\x72\171\160\164\151\157\156") {
                goto nL;
            }
            $this->parseSigningCertificate($Au);
            goto m8;
            nL:
            $this->parseEncryptionCertificate($Au);
            m8:
            mC:
            IS:
        }
        HP:
    }
    private function parseSigningCertificate($rd)
    {
        $aO = Utilities::xpQuery($rd, "\x2e\x2f\144\x73\72\x4b\145\x79\x49\156\x66\157\x2f\144\163\x3a\x58\65\60\71\x44\x61\164\141\57\144\163\x3a\130\65\60\71\103\145\x72\164\x69\146\x69\x63\x61\x74\x65");
        $tT = trim($aO[0]->textContent);
        $tT = str_replace(array("\15", "\12", "\x9", "\x20"), '', $tT);
        if (empty($aO)) {
            goto ov;
        }
        array_push($this->signingCertificate, $tT);
        ov:
    }
    private function parseEncryptionCertificate($rd)
    {
        $aO = Utilities::xpQuery($rd, "\x2e\57\x64\x73\x3a\x4b\145\x79\111\156\x66\x6f\57\x64\x73\x3a\x58\65\60\71\x44\x61\164\x61\57\144\x73\72\130\65\60\x39\x43\x65\x72\164\x69\146\151\x63\x61\x74\145");
        $tT = trim($aO[0]->textContent);
        $tT = str_replace(array("\xd", "\xa", "\x9", "\40"), '', $tT);
        if (empty($aO)) {
            goto n1;
        }
        array_push($this->encryptionCertificate, $tT);
        n1:
    }
    public function getIdpName()
    {
        return $this->idpName;
    }
    public function getEntityID()
    {
        return $this->entityID;
    }
    public function getLoginURL($d5)
    {
        return $this->loginDetails[$d5];
    }
    public function getLogoutURL($d5)
    {
        return $this->logoutDetails[$d5];
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
