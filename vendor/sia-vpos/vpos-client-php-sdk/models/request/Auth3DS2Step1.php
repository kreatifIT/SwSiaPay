<?php
require_once(__DIR__ . "/Request.php");


class Auth3DS2Step1 extends Request
{

    public const OPERATION = "THREEDSAUTHORIZATION1";
    private const AUTH3DS2STEP1_REQUEST_TAG = "ThreeDSAuthorization1Request";

    private string $threeDSTransID;

    /**
     * @return string
     */
    public function getThreeDSTransID(): string
    {
        return $this->threeDSTransID;
    }

    /**
     * @param string $threeDSTransID
     */
    public function setThreeDSTransID(string $threeDSTransID): void
    {
        $this->threeDSTransID = $threeDSTransID;
    }

    /**
     * @return string
     */
    public function getThreeDsMtdComplInd(): string
    {
        return $this->threeDsMtdComplInd;
    }

    /**
     * @param string $threeDsMtdComplInd
     */
    public function setThreeDsMtdComplInd(string $threeDsMtdComplInd): void
    {
        $this->threeDsMtdComplInd = $threeDsMtdComplInd;
    }
    private string $threeDsMtdComplInd;

    public function __construct()
    {
        parent::__construct();
    }

    public function getXML(): string
    {
        $xml = $this->getXMLOpening();

        XMLUtils::appendTag($xml, self::THREEDS_TRANS_ID_TAG, $this->threeDSTransID);
        XMLUtils::appendTag($xml, self::THREEDS_MTD_COMPL_IND_TAG, $this->threeDsMtdComplInd);


        $xml .= $this->getXMLClosing();
        $xml = str_replace(static::OPERATION_TAG_VALUE, static::OPERATION, $xml);
        $xml = $xml = str_replace(static::VARIABLE_REQUEST_TAG, static::AUTH3DS2STEP1_REQUEST_TAG, $xml);
        return $xml;
    }

    public function getMacArray(): array
    {
        return array(
            "OPERATION"=>self::OPERATION,
            "TIMESTAMP"=> $this->timestamp,
            "SHOPID"=> $this->shopId,
            "OPERATORID"=> $this->operatorId,
            "REQREFNUM"=> $this->reqRefNum,
            "THREEDSTRANSID"=> $this->threeDSTransID,
            "THREEDSMTDCOMPLIND"=>$this->threeDsMtdComplInd
    );
    }
}