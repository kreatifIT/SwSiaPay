<?php
require_once(__DIR__ . "/Response.php");
require_once(__DIR__ . "/Authorization.php");
require_once(__DIR__ . "/PanAliasData.php");
require_once(__DIR__ ."/ThreeDSMethod.php");
require_once(__DIR__ ."/ThreeDSChallenge.php");



class Auth3DS2Step0Response extends Response
{
    private ?Authorization $authorization = null;
    private ?PanAliasData $panAliasData = null;
    private ?ThreeDSMethod $threeDsMethod = null;
    private ?ThreeDSChallenge $threeDSChallenge = null;

    /**
     * @return Authorization|null
     */
    public function getAuthorization(): ?Authorization
    {
        return $this->authorization;
    }

    /**
     * @param Authorization|null $authorization
     */
    public function setAuthorization(?Authorization $authorization): void
    {
        $this->authorization = $authorization;
    }

    /**
     * @return PanAliasData|null
     */
    public function getPanAliasData(): ?PanAliasData
    {
        return $this->panAliasData;
    }

    /**
     * @param PanAliasData|null $panAliasData
     */
    public function setPanAliasData(?PanAliasData $panAliasData): void
    {
        $this->panAliasData = $panAliasData;
    }

    /**
     * @return ThreeDSMethod|null
     */
    public function getThreeDsMethod(): ?ThreeDSMethod
    {
        return $this->threeDsMethod;
    }

    /**
     * @param ThreeDSMethod|null $threeDsMethod
     */
    public function setThreeDsMethod(?ThreeDSMethod $threeDsMethod): void
    {
        $this->threeDsMethod = $threeDsMethod;
    }

    /**
     * @return ThreeDSChallenge|null
     */
    public function getThreeDSChallenge(): ?ThreeDSChallenge
    {
        return $this->threeDSChallenge;
    }

    /**
     * @param ThreeDSChallenge|null $threeDSChallenge
     */
    public function setThreeDSChallenge(?ThreeDSChallenge $threeDSChallenge): void
    {
        $this->threeDSChallenge = $threeDSChallenge;
    }


    public function __construct(string $xml)
    {
        parent::__construct($xml);
        $response = new SimpleXMLElement($xml);
        if (isset($response->Data->ThreeDSMethod))
            $this->threeDsMethod = new ThreeDSMethod($response->Data->ThreeDSMethod);
        if (isset($response->Data->ThreeDSChallenge))
            $this->threeDSChallenge = new ThreeDSChallenge($response->Data->ThreeDSChallenge);
        if (isset($response->Data->Authorization))
            $this->authorization = new Authorization($response->Data->Authorization);
        if (isset($response->Data->PanAliasData))
            $this->panAliasData = new PanAliasData($response->Data->PanAliasData);
    }

}