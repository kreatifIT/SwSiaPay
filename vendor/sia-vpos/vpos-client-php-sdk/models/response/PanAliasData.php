<?php

/**
 * Class PanAliasData
 */
class PanAliasData
{
    private ?string $panAlias = null;
    private ?string $panAliasRev = null;
    private ?string $panAliasExpDate = null;
    private ?string $panAliasTail = null;
    private ?string $mac = null;

    /**
     * PanAliasData constructor.
     * @param SimpleXMLElement $panAliasData xml model of the object
     */
    public function __construct(SimpleXMLElement $panAliasData)
    {
        $this->panAlias = $panAliasData->PanAlias;
        $this->panAliasRev = $panAliasData->PanAliasRev;
        $this->panAliasExpDate = $panAliasData->PanAliasExpDate;
        $this->panAliasTail = $panAliasData->PanAliasTail;
        $this->mac = $panAliasData->MAC;
    }

    /**
     * @return array used to perform integrity check
     */
    public function getMacArray()
    {
        return array(
            $this->panAlias,
            $this->panAliasRev,
            $this->panAliasExpDate,
            $this->panAliasTail
        );
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getPanAlias()
    {
        return $this->panAlias;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getPanAliasRev()
    {
        return $this->panAliasRev;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getPanAliasExpDate()
    {
        return $this->panAliasExpDate;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getPanAliasTail()
    {
        return $this->panAliasTail;
    }

    /**
     * @return SimpleXMLElement|string|null
     */
    public function getMac()
    {
        return $this->mac;
    }

}