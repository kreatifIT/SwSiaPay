<?php

/**
 * Class Operation
 */
class Operation
{
    private string $transactionID;
    private string $timestampReq;
    private string $timestampElab;
    private string $srcType;
    private string $amount;
    private string $result;
    private string $status;
    private string $opDescr;
    private string $mac;
    private Authorization $authorization;

    public function __construct(SimpleXMLElement $operation)
    {
        $this->transactionID = $operation->TransactionID;
        $this->timestampReq = $operation->TimestampReq;
        $this->timestampElab = $operation->TimestampElab;
        $this->srcType = $operation->SrcType;
        $this->amount = $operation->Amount;
        $this->result = $operation->Result;
        $this->status = $operation->Status;
        $this->opDescr = $operation->OpDescr;
        $this->mac = $operation->MAC;
        if (isset($operation->Authorization))
            $this->authorization = new Authorization($operation->Authorization);
    }

    public function getMacArray()
    {
        return array(
            $this->transactionID,
            $this->timestampReq,
            $this->timestampElab,
            $this->srcType,
            $this->amount,
            $this->result,
            $this->status,
            $this->opDescr
        );
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTimestampReq()
    {
        return $this->timestampReq;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTimestampElab()
    {
        return $this->timestampElab;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getSrcType()
    {
        return $this->srcType;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getOpDescr()
    {
        return $this->opDescr;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * @return Authorization
     */
    public function getAuthorization(): Authorization
    {
        return $this->authorization;
    }

}