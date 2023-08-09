<?php


include_once "\x55\164\x69\154\x69\164\x69\145\163\x2e\160\x68\160";
include_once "\x78\155\x6c\x73\145\143\154\x69\142\x73\56\160\x68\x70";
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
    public function __construct(DOMElement $DH = NULL)
    {
        $this->tagName = "\114\x6f\147\157\165\164\122\145\x71\165\145\x73\x74";
        $this->id = Utilities::generateID();
        $this->issueInstant = time();
        $this->certificates = array();
        $this->validators = array();
        if (!($DH === NULL)) {
            goto ju;
        }
        return;
        ju:
        if ($DH->hasAttribute("\111\104")) {
            goto HH;
        }
        throw new Exception("\115\x69\x73\x73\x69\x6e\147\40\111\104\40\141\x74\x74\x72\x69\142\165\x74\x65\40\x6f\156\x20\x53\101\x4d\x4c\x20\155\x65\x73\163\x61\147\x65\x2e");
        HH:
        $this->id = $DH->getAttribute("\111\104");
        if (!($DH->getAttribute("\126\145\x72\x73\151\157\x6e") !== "\x32\56\60")) {
            goto FV;
        }
        throw new Exception("\x55\156\163\165\x70\x70\x6f\x72\164\145\x64\40\x76\x65\x72\x73\x69\x6f\x6e\72\x20" . $DH->getAttribute("\x56\145\162\163\x69\157\156"));
        FV:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($DH->getAttribute("\x49\x73\163\165\145\x49\156\x73\164\141\156\164"));
        if (!$DH->hasAttribute("\x44\145\163\x74\151\156\x61\164\x69\157\156")) {
            goto IL;
        }
        $this->destination = $DH->getAttribute("\104\x65\x73\x74\x69\x6e\141\164\151\157\156");
        IL:
        $NK = Utilities::xpQuery($DH, "\x2e\x2f\x73\141\x6d\154\137\141\163\x73\145\x72\164\x69\x6f\x6e\x3a\x49\x73\x73\x75\145\162");
        if (empty($NK)) {
            goto V9;
        }
        $this->issuer = trim($NK[0]->textContent);
        V9:
        try {
            $Sj = Utilities::validateElement($DH);
            if (!($Sj !== FALSE)) {
                goto Zw;
            }
            $this->certificates = $Sj["\103\x65\x72\x74\151\146\151\x63\141\164\145\x73"];
            $this->validators[] = array("\106\x75\156\x63\x74\x69\157\x6e" => array("\x55\x74\151\x6c\x69\x74\151\145\163", "\166\x61\154\151\x64\141\x74\x65\123\151\147\x6e\141\x74\165\x72\145"), "\104\141\x74\141" => $Sj);
            Zw:
        } catch (Exception $aW) {
        }
        $this->sessionIndexes = array();
        if (!$DH->hasAttribute("\x4e\157\x74\117\156\x4f\x72\x41\x66\x74\145\162")) {
            goto GM;
        }
        $this->notOnOrAfter = Utilities::xsDateTimeToTimestamp($DH->getAttribute("\x4e\157\x74\117\x6e\117\x72\101\x66\164\x65\162"));
        GM:
        $k9 = Utilities::xpQuery($DH, "\x2e\x2f\163\x61\x6d\154\x5f\141\163\163\x65\x72\x74\x69\157\x6e\x3a\x4e\x61\x6d\145\x49\104\x20\x7c\x20\x2e\57\x73\141\x6d\x6c\x5f\141\x73\x73\145\162\164\x69\x6f\x6e\72\x45\x6e\x63\x72\171\160\x74\145\x64\x49\x44\x2f\170\x65\x6e\143\72\105\x6e\143\x72\x79\x70\x74\145\144\x44\141\x74\x61");
        if (empty($k9)) {
            goto Cq;
        }
        if (count($k9) > 1) {
            goto ho;
        }
        goto UP;
        Cq:
        throw new Exception("\x4d\151\163\163\x69\x6e\x67\40\x3c\x73\x61\155\154\72\x4e\x61\155\145\111\104\x3e\x20\157\162\x20\74\163\x61\155\x6c\x3a\x45\x6e\143\162\171\160\164\145\x64\x49\104\x3e\40\151\156\40\74\163\141\x6d\x6c\160\x3a\x4c\x6f\x67\157\165\164\122\145\161\165\x65\x73\x74\x3e\56");
        goto UP;
        ho:
        throw new Exception("\x4d\x6f\x72\x65\x20\164\x68\x61\x6e\x20\157\156\145\x20\x3c\163\141\155\154\72\x4e\x61\155\x65\111\104\76\40\157\x72\x20\x3c\x73\x61\155\154\x3a\x45\156\143\162\x79\160\x74\x65\144\104\x3e\x20\151\156\x20\x3c\163\x61\155\x6c\x70\72\x4c\157\147\x6f\x75\x74\122\145\x71\x75\x65\163\164\x3e\56");
        UP:
        $k9 = $k9[0];
        if ($k9->localName === "\x45\156\x63\x72\x79\x70\164\x65\x64\104\141\x74\x61") {
            goto Dj;
        }
        $this->nameId = Utilities::parseNameId($k9);
        goto Xn;
        Dj:
        $this->encryptedNameId = $k9;
        Xn:
        $TI = Utilities::xpQuery($DH, "\x2e\57\x73\141\x6d\x6c\x5f\160\x72\x6f\164\157\x63\x6f\x6c\72\x53\x65\163\x73\x69\x6f\x6e\x49\156\144\145\x78");
        foreach ($TI as $ri) {
            $this->sessionIndexes[] = trim($ri->textContent);
            cq:
        }
        mq:
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($Xh)
    {
        $this->notOnOrAfter = $Xh;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto LG;
        }
        return TRUE;
        LG:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $ez)
    {
        $gQ = new DOMDocument();
        $WB = $gQ->createElement("\162\x6f\157\x74");
        $gQ->appendChild($WB);
        SAML2_Utils::addNameId($WB, $this->nameId);
        $k9 = $WB->firstChild;
        SAML2_Utils::getContainer()->debugMessage($k9, "\x65\x6e\143\162\171\160\x74");
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
            goto tj;
        }
        return;
        tj:
        $k9 = SAML2_Utils::decryptElement($this->encryptedNameId, $ez, $Re);
        SAML2_Utils::getContainer()->debugMessage($k9, "\144\145\x63\162\171\160\164");
        $this->nameId = SAML2_Utils::parseNameId($k9);
        $this->encryptedNameId = NULL;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Lw;
        }
        throw new Exception("\101\x74\164\x65\155\160\164\x65\x64\40\164\157\x20\x72\x65\164\x72\151\145\166\x65\40\145\x6e\x63\162\x79\160\164\x65\x64\x20\116\141\155\145\x49\104\40\x77\151\164\150\x6f\x75\x74\40\x64\x65\143\162\x79\x70\164\151\x6e\147\x20\151\x74\x20\146\x69\x72\163\164\x2e");
        Lw:
        return $this->nameId;
    }
    public function setNameId($k9)
    {
        $this->nameId = $k9;
    }
    public function getSessionIndexes()
    {
        return $this->sessionIndexes;
    }
    public function setSessionIndexes(array $TI)
    {
        $this->sessionIndexes = $TI;
    }
    public function getSessionIndex()
    {
        if (!empty($this->sessionIndexes)) {
            goto H8;
        }
        return NULL;
        H8:
        return $this->sessionIndexes[0];
    }
    public function setSessionIndex($ri)
    {
        if (is_null($ri)) {
            goto CG;
        }
        $this->sessionIndexes = array($ri);
        goto NN;
        CG:
        $this->sessionIndexes = array();
        NN:
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
    public function getDestination()
    {
        return $this->destination;
    }
    public function setDestination($c9)
    {
        $this->destination = $c9;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($NK)
    {
        $this->issuer = $NK;
    }
}
