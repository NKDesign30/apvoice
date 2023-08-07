<?php


include_once "\125\x74\151\154\151\x74\x69\x65\163\x2e\160\150\160";
include_once "\170\155\154\163\x65\x63\154\151\x62\163\56\160\x68\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class SAML2_LogoutRequest
{
    private $tagName;
    private $id;
    private $issuer;
    private $destination;
    private $issueInstant;
    private $certificates;
    private $validators;
    private $notOnOrAfter;
    private $encryptedNameId;
    private $nameId;
    private $sessionIndexes;
    public function __construct(DOMElement $rd = NULL)
    {
        $this->tagName = "\x4c\x6f\147\157\x75\x74\x52\145\161\x75\x65\163\x74";
        $this->id = Utilities::generateID();
        $this->issueInstant = time();
        $this->certificates = array();
        $this->validators = array();
        if (!($rd === NULL)) {
            goto a9;
        }
        return;
        a9:
        if ($rd->hasAttribute("\x49\104")) {
            goto EE;
        }
        throw new Exception("\x4d\x69\x73\163\x69\156\x67\40\x49\104\40\x61\164\164\x72\151\142\x75\x74\x65\40\x6f\156\40\x53\x41\x4d\114\40\x6d\x65\x73\x73\141\x67\x65\x2e");
        EE:
        $this->id = $rd->getAttribute("\111\x44");
        if (!($rd->getAttribute("\126\x65\x72\163\x69\x6f\156") !== "\62\56\x30")) {
            goto LN;
        }
        throw new Exception("\125\156\x73\x75\x70\x70\x6f\162\164\x65\144\40\x76\145\x72\163\x69\x6f\156\72\40" . $rd->getAttribute("\126\x65\x72\x73\x69\x6f\156"));
        LN:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($rd->getAttribute("\x49\x73\x73\165\145\x49\156\163\164\141\156\164"));
        if (!$rd->hasAttribute("\104\x65\163\164\151\x6e\141\164\x69\x6f\x6e")) {
            goto Kg;
        }
        $this->destination = $rd->getAttribute("\x44\145\x73\164\x69\156\x61\164\151\x6f\x6e");
        Kg:
        $Jq = Utilities::xpQuery($rd, "\x2e\57\163\x61\x6d\x6c\137\141\x73\163\145\162\x74\x69\x6f\156\x3a\111\163\x73\x75\x65\x72");
        if (empty($Jq)) {
            goto X6;
        }
        $this->issuer = trim($Jq[0]->textContent);
        X6:
        try {
            $OP = Utilities::validateElement($rd);
            if (!($OP !== FALSE)) {
                goto Hb;
            }
            $this->certificates = $OP["\103\145\x72\164\151\x66\x69\143\x61\164\x65\163"];
            $this->validators[] = array("\x46\165\156\143\x74\151\x6f\x6e" => array("\x55\x74\151\x6c\x69\x74\x69\145\163", "\x76\141\x6c\x69\144\x61\164\x65\x53\x69\x67\x6e\141\164\165\162\145"), "\104\141\164\x61" => $OP);
            Hb:
        } catch (Exception $Tn) {
        }
        $this->sessionIndexes = array();
        if (!$rd->hasAttribute("\116\157\164\117\156\x4f\162\101\x66\x74\x65\x72")) {
            goto BO;
        }
        $this->notOnOrAfter = Utilities::xsDateTimeToTimestamp($rd->getAttribute("\x4e\157\x74\117\x6e\117\x72\101\x66\x74\145\x72"));
        BO:
        $f1 = Utilities::xpQuery($rd, "\x2e\x2f\x73\141\x6d\154\137\x61\163\x73\145\162\x74\151\x6f\x6e\x3a\x4e\x61\155\x65\111\104\x20\174\40\56\x2f\x73\x61\155\154\x5f\x61\163\163\145\162\164\151\157\x6e\x3a\105\156\x63\x72\x79\x70\164\145\144\x49\x44\57\x78\x65\156\x63\x3a\x45\156\143\162\171\160\x74\x65\144\x44\x61\x74\x61");
        if (empty($f1)) {
            goto RN;
        }
        if (count($f1) > 1) {
            goto cW;
        }
        goto YS;
        RN:
        throw new Exception("\x4d\151\163\163\151\x6e\147\40\x3c\x73\141\155\x6c\72\116\141\155\x65\x49\x44\76\40\x6f\x72\40\x3c\163\141\155\154\x3a\x45\156\x63\x72\x79\160\x74\145\144\111\104\x3e\40\151\156\40\74\x73\141\155\x6c\x70\72\x4c\x6f\147\x6f\x75\x74\x52\145\x71\x75\x65\x73\164\76\x2e");
        goto YS;
        cW:
        throw new Exception("\x4d\157\162\145\40\x74\x68\x61\x6e\40\157\x6e\145\x20\74\x73\141\155\154\72\x4e\141\x6d\x65\111\104\76\x20\157\162\x20\x3c\x73\141\x6d\x6c\72\105\x6e\143\162\x79\x70\x74\145\x64\x44\76\40\x69\x6e\40\74\x73\141\155\154\160\x3a\x4c\x6f\x67\x6f\x75\164\122\x65\x71\165\x65\163\164\x3e\56");
        YS:
        $f1 = $f1[0];
        if ($f1->localName === "\105\x6e\143\x72\x79\160\x74\145\144\104\x61\x74\141") {
            goto HG;
        }
        $this->nameId = Utilities::parseNameId($f1);
        goto mQ;
        HG:
        $this->encryptedNameId = $f1;
        mQ:
        $x4 = Utilities::xpQuery($rd, "\56\x2f\163\141\x6d\x6c\137\x70\x72\x6f\x74\x6f\143\x6f\x6c\72\123\145\163\163\151\157\156\x49\x6e\144\x65\x78");
        foreach ($x4 as $q1) {
            $this->sessionIndexes[] = trim($q1->textContent);
            r4:
        }
        uU:
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($jE)
    {
        $this->notOnOrAfter = $jE;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Pq;
        }
        return TRUE;
        Pq:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $FE)
    {
        $ta = new DOMDocument();
        $Ii = $ta->createElement("\x72\157\157\164");
        $ta->appendChild($Ii);
        SAML2_Utils::addNameId($Ii, $this->nameId);
        $f1 = $Ii->firstChild;
        SAML2_Utils::getContainer()->debugMessage($f1, "\145\x6e\143\162\171\160\164");
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
            goto z7;
        }
        return;
        z7:
        $f1 = SAML2_Utils::decryptElement($this->encryptedNameId, $FE, $M5);
        SAML2_Utils::getContainer()->debugMessage($f1, "\x64\x65\143\x72\x79\x70\x74");
        $this->nameId = SAML2_Utils::parseNameId($f1);
        $this->encryptedNameId = NULL;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto wi;
        }
        throw new Exception("\x41\x74\x74\x65\x6d\160\x74\x65\144\x20\x74\157\x20\162\x65\164\162\x69\x65\166\145\40\x65\156\143\162\171\x70\164\x65\144\40\x4e\141\x6d\145\111\104\40\x77\151\x74\x68\x6f\x75\x74\x20\x64\x65\143\x72\x79\160\164\x69\156\147\40\x69\x74\40\x66\151\162\163\164\x2e");
        wi:
        return $this->nameId;
    }
    public function setNameId($f1)
    {
        $this->nameId = $f1;
    }
    public function getSessionIndexes()
    {
        return $this->sessionIndexes;
    }
    public function setSessionIndexes(array $x4)
    {
        $this->sessionIndexes = $x4;
    }
    public function getSessionIndex()
    {
        if (!empty($this->sessionIndexes)) {
            goto GZ;
        }
        return NULL;
        GZ:
        return $this->sessionIndexes[0];
    }
    public function setSessionIndex($q1)
    {
        if (is_null($q1)) {
            goto uT;
        }
        $this->sessionIndexes = array($q1);
        goto OO;
        uT:
        $this->sessionIndexes = array();
        OO:
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
    public function getDestination()
    {
        return $this->destination;
    }
    public function setDestination($b1)
    {
        $this->destination = $b1;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($Jq)
    {
        $this->issuer = $Jq;
    }
}
