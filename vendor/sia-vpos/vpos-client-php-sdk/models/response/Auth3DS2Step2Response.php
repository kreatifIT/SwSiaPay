<?php
require_once(__DIR__ . "/Response.php");
require_once(__DIR__ . "/Authorization.php");
require_once(__DIR__ . "/PanAliasData.php");


class Auth3DS2Step2Response extends Response
{

    private ?Authorization $authorization = null;
    private ?PanAliasData $panAliasData = null;

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

    public function __construct(string $xml)
    {
        parent::__construct($xml);
        $response = new SimpleXMLElement($xml);
        if (isset($response->Data->Authorization))
            $this->authorization = new Authorization($response->Data->Authorization);
            $this->vbvRedirect = new VBVRedirect($response->Data->VBVRedirect);
        if (isset($response->Data->PanAliasData))
            $this->panAliasData = new PanAliasData($response->Data->PanAliasData);
    }

}