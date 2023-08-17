<?php


class ThreeDSMethod
{
    private string $threeDSTransId;
    private string $threeDSMethodData;
    private string $threeDSMethodUrl;
    private string $mac;

    public function __construct(SimpleXMLElement $threeDSMethod)
    {
        $this->threeDSTransId = $threeDSMethod->ThreeDSTransId;
        $this->threeDSMethodData  = $threeDSMethod->ThreeDSMethodData;
        $this->threeDSMethodUrl  = $threeDSMethod->ThreeDSMethodUrl;
        $this->mac  = $threeDSMethod->MAC;

    }

    /**
     * @return array used to perform integrity check
     */
    public function getMacArray(){
        return array(
            $this->threeDSTransId,
            $this->threeDSMethodData,
            $this->threeDSMethodUrl
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
    public function getThreeDSMethodData(): string
    {
        return $this->threeDSMethodData;
    }

    /**
     * @param string $threeDSMethodData
     */
    public function setThreeDSMethodData(string $threeDSMethodData): void
    {
        $this->threeDSMethodData = $threeDSMethodData;
    }

    /**
     * @return string
     */
    public function getThreeDSMethodUrl(): string
    {
        return $this->threeDSMethodUrl;
    }

    /**
     * @param string $threeDSMethodUrl
     */
    public function setThreeDSMethodUrl(string $threeDSMethodUrl): void
    {
        $this->threeDSMethodUrl = $threeDSMethodUrl;
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