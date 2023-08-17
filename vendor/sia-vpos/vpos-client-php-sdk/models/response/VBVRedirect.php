<?php

/**
 * Class VBVRedirect
 */
class VBVRedirect
{
    private ?string $paReq = null;
    private ?string $acsURL = null;
    private ?string $mac = null;

    /**
     * VBVRedirect constructor.
     * @param SimpleXMLElement $vbvRedirect
     */
    public function __construct(SimpleXMLElement $vbvRedirect)
    {
        $this->paReq = $vbvRedirect->PaReq;
        $this->acsURL = $vbvRedirect->AcsURL;
        $this->mac = $vbvRedirect->MAC;
    }

    public function getMacArray()
    {
        return array(
            $this->paReq,
            $this->acsURL
        );
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getPaReq()
    {
        return $this->paReq;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getAcsURL()
    {
        return $this->acsURL;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getMac()
    {
        return $this->mac;
    }

}