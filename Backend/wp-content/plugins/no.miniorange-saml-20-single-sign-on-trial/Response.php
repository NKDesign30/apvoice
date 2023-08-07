<?php


include "\101\163\x73\145\x72\x74\151\157\156\56\160\150\x70";
class SAML2_Response
{
    private $assertions;
    private $destination;
    private $certificates;
    private $signatureData;
    public function __construct(DOMElement $rd = NULL, $nZ)
    {
        $this->assertions = array();
        $this->certificates = array();
        if (!($rd === NULL)) {
            goto K8W;
        }
        return;
        K8W:
        $OP = Utilities::validateElement($rd);
        if (!($OP !== FALSE)) {
            goto OW_;
        }
        $this->certificates = $OP["\x43\x65\x72\164\x69\146\151\143\x61\x74\x65\x73"];
        $this->signatureData = $OP;
        OW_:
        if (!$rd->hasAttribute("\104\x65\x73\x74\151\x6e\x61\164\x69\157\156")) {
            goto wzd;
        }
        $this->destination = $rd->getAttribute("\x44\145\163\164\x69\156\x61\x74\151\x6f\x6e");
        wzd:
        $xi = $rd->firstChild;
        zLp:
        if (!($xi !== NULL)) {
            goto nuy;
        }
        if (!($xi->namespaceURI !== "\165\x72\x6e\72\x6f\141\x73\151\163\72\156\x61\155\145\x73\72\x74\143\72\123\x41\x4d\114\x3a\x32\x2e\x30\72\141\x73\x73\145\162\164\151\x6f\156")) {
            goto PP5;
        }
        goto Iq1;
        PP5:
        if (!($xi->localName === "\x41\163\163\145\x72\x74\151\x6f\x6e" || $xi->localName === "\x45\x6e\143\x72\171\160\x74\x65\144\x41\163\163\x65\162\x74\x69\x6f\156")) {
            goto a2U;
        }
        $this->assertions[] = new SAML2_Assertion($xi, $nZ);
        a2U:
        Iq1:
        $xi = $xi->nextSibling;
        goto zLp;
        nuy:
    }
    public function getAssertions()
    {
        return $this->assertions;
    }
    public function setAssertions(array $UR)
    {
        $this->assertions = $UR;
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
