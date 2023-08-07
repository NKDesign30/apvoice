<?php


include "\101\163\163\145\162\164\x69\157\x6e\x2e\x70\150\160";
class SAML2_Response
{
    private $assertions;
    private $destination;
    private $certificates;
    private $signatureData;
    public function __construct(DOMElement $DH = NULL, $Af)
    {
        $this->assertions = array();
        $this->certificates = array();
        if (!($DH === NULL)) {
            goto kct;
        }
        return;
        kct:
        $Sj = Utilities::validateElement($DH);
        if (!($Sj !== FALSE)) {
            goto Kw2;
        }
        $this->certificates = $Sj["\x43\x65\162\x74\151\146\x69\143\x61\x74\x65\x73"];
        $this->signatureData = $Sj;
        Kw2:
        if (!$DH->hasAttribute("\104\145\163\x74\x69\x6e\141\x74\x69\x6f\156")) {
            goto OjY;
        }
        $this->destination = $DH->getAttribute("\x44\x65\x73\x74\151\x6e\x61\x74\x69\x6f\x6e");
        OjY:
        $m8 = $DH->firstChild;
        c6U:
        if (!($m8 !== NULL)) {
            goto lqx;
        }
        if (!($m8->namespaceURI !== "\165\x72\156\72\x6f\x61\163\x69\x73\x3a\156\x61\155\x65\163\72\x74\x63\72\123\101\115\114\72\62\56\x30\x3a\141\163\163\145\x72\x74\151\x6f\156")) {
            goto zr5;
        }
        goto Rfm;
        zr5:
        if (!($m8->localName === "\101\x73\163\145\x72\164\151\157\156" || $m8->localName === "\105\156\143\162\x79\x70\164\145\x64\101\x73\x73\x65\x72\164\151\x6f\x6e")) {
            goto Vzg;
        }
        $this->assertions[] = new SAML2_Assertion($m8, $Af);
        Vzg:
        Rfm:
        $m8 = $m8->nextSibling;
        goto c6U;
        lqx:
    }
    public function getAssertions()
    {
        return $this->assertions;
    }
    public function setAssertions(array $np)
    {
        $this->assertions = $np;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
}
