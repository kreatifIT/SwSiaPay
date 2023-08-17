<?php


class ThreeDSChallenge
{

    private string $threeDSTransId;
    private string $creq;
    private string $acsUrl;
    private string $mac;

    public function __construct(SimpleXMLElement $threeDSChallenge)
    {
        $this->threeDSTransId = $threeDSChallenge->ThreeDSTransId;
        $this->creq = $threeDSChallenge->CReq;
        $this->acsUrl = $threeDSChallenge->ACSUrl;
        $this->mac = $threeDSChallenge->MAC;
    }
    /**
     * @return array used to perform integrity check
     */
    public function getMacArray(){
        return array(
            $this->threeDSTransId,
            $this->creq,
            $this->acsUrl
        );
    }


    /**
     * @return string
     */
    public function getThreeDSTransId(): string
    {
        return $this->threeDSTransId;
    }

    /**
     * @param string $threeDSTransId
     */
    public function setThreeDSTransId(string $threeDSTransId): void
    {
        $this->threeDSTransId = $threeDSTransId;
    }

    /**
     * @return string
     */
    public function getCreq(): string
    {
        return $this->creq;
    }

    /**
     * @param string $creq
     */
    public function setCreq(string $creq): void
    {
        $this->creq = $creq;
    }

    /**
     * @return string
     */
    public function getAcsUrl(): string
    {
        return $this->acsUrl;
    }

    /**
     * @param string $acsUrl
     */
    public function setAcsUrl(string $acsUrl): void
    {
        $this->acsUrl = $acsUrl;
    }

    /**
     * @return string
     */
    public function getMac(): string
    {
        return $this->mac;
    }

    /**
     * @param string $mac
     */
    public function setMac(string $mac): void
    {
        $this->mac = $mac;
    }



}