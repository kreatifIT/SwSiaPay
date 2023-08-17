<?php
require_once(__DIR__ . "/Request.php");

class CaptureRequest extends Request
{
    private const OPERATION = "ACCOUNTING";
    private const ACCOUNTING_REQUEST_TAG = "Accounting";

    private string $transactionId;
    private string $orderId;
    private string $amount;
    private string $currency;

    private ?string $exponent = null;
    private ?string $opDescr = null;

    /**
     * CaptureRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getXML(): string
    {
        $xml = $this->getXMLOpening();

        //start from </Header>
        XMLUtils::appendTag($xml, self::TRANSACTION_ID_TAG, $this->transactionId);
        XMLUtils::appendTag($xml, self::ORDER_ID_TAG, $this->orderId);
        XMLUtils::appendTag($xml, self::AMOUNT_TAG, $this->amount);
        XMLUtils::appendTag($xml, self::CURRENCY_TAG, $this->currency);
        XMLUtils::appendTag($xml, self::EXPONENT_TAG, $this->exponent);
        XMLUtils::appendTag($xml, self::OPDESCR_TAG, $this->opDescr);
        XMLUtils::appendTag($xml, self::OPTIONS_TAG, $this->options);

        $xml .= $this->getXMLClosing();
        $xml = str_replace(static::OPERATION_TAG_VALUE, static::OPERATION, $xml);
        $xml = $xml = str_replace(static::VARIABLE_REQUEST_TAG, static::ACCOUNTING_REQUEST_TAG, $xml);
        return $xml;
    }

    public function getMacArray(): array
    {
        return array(
            "OPERATION" => self::OPERATION,
            "TIMESTAMP" => $this->timestamp,
            "SHOPID" => $this->shopId,
            "OPERATORID" => $this->operatorId,
            "REQREFNUM" => $this->reqRefNum,
            "TRANSACTIONID" => $this->transactionId,
            "ORDERID" => $this->orderId,
            "AMOUNT" => $this->amount,
            "CURRENCY" => $this->currency,
            "EXPONENT" => $this->exponent,
            "OPDESCR" => $this->opDescr,
            "OPTIONS" => $this->options
        );
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @param string|null $exponent
     */
    public function setExponent(?string $exponent): void
    {
        $this->exponent = $exponent;
    }

    /**
     * @param string|null $opDescr
     */
    public function setOpDescr(?string $opDescr): void
    {
        $this->opDescr = $opDescr;
    }

}