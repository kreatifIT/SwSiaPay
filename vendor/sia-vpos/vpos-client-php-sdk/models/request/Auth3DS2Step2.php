<?php
require_once(__DIR__ . "/Request.php");


class Auth3DS2Step2 extends Request
{
    public const OPERATION = "THREEDSAUTHORIZATION2";
    private const AUTH3DS2STEP2_REQUEST_TAG = "ThreeDSAuthorization2Request";

    private string $threeDsTransId;

    /**
     * @return string
     */
    public function getThreeDsTransId(): string
    {
        return $this->threeDsTransId;
    }

    /**
     * @param string $threeDsTransId
     */
    public function setThreeDsTransId(string $threeDsTransId): void
    {
        $this->threeDsTransId = $threeDsTransId;
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function getXML(): string
    {
        $xml = $this->getXMLOpening();

        XMLUtils::appendTag($xml, self::THREEDS_TRANS_ID_TAG, $this->threeDsTransId);

        $xml .= $this->getXMLClosing();
        $xml = str_replace(static::OPERATION_TAG_VALUE, static::OPERATION, $xml);
        $xml = $xml = str_replace(static::VARIABLE_REQUEST_TAG, static::AUTH3DS2STEP2_REQUEST_TAG, $xml);
        return $xml;
    }

    public function getMacArray(): array
    {
        return array(
        "OPERATION"=> self::OPERATION,
            "TIMESTAMP"=> $this->timestamp,
            "SHOPID"=> $this->shopId,
            "OPERATORID"=> $this->operatorId,
            "REQREFNUM"=> $this->reqRefNum,
            "THREEDSTRANSID"=>$this-> threeDsTransId
        );


    }

}
