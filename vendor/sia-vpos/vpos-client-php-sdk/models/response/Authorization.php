<?php

/**
 * Class Authorization
 */
class Authorization
{
    private string $paymentType;
    private string $authorizationType;
    private string $transactionID;
    private string $network;
    private string $orderID;
    private string $transactionAmount;
    private string $authorizedAmount;
    private string $currency;
    private string $exponent;
    private string $accountedAmount;
    private string $refundedAmount;
    private string $transactionResult;
    private string $timestamp;
    private string $authorizationNumber;
    private string $acquirerBIN;
    private string $merchantID;
    private string $transactionStatus;
    private string $responseCodeISO;
    private string $panTail;
    private string $panExpiryDate;
    private string $paymentTypePP;
    private string $rRN;
    private string $cardType;
    private string $cardholderInfo;
    private string $installmentsNumber;
    private string $ticklerMerchantCode;
    private string $ticklerPlanCode;
    private string $ticklerSubscriptionCode;


    private string $mac;

    public function __construct(SimpleXMLElement $authorization)
    {
        $this->paymentType = $authorization->PaymentType;
        $this->authorizationType = $authorization->AuthorizationType;
        $this->transactionID = $authorization->TransactionID;
        $this->network = $authorization->Network;
        $this->orderID = $authorization->OrderId ?? $authorization->OrderID ?? " ";
        $this->transactionAmount = $authorization->TransactionAmount;
        $this->authorizedAmount = $authorization->AuthorizedAmount;
        $this->currency = $authorization->Currency;
        $this->exponent = $authorization->Exponent;
        $this->accountedAmount = $authorization->AccountedAmount;
        $this->refundedAmount = $authorization->RefundedAmount;
        $this->transactionResult = $authorization->TransactionResult;
        $this->timestamp = $authorization->Timestamp;
        $this->authorizationNumber = $authorization->AuthorizationNumber;
        $this->acquirerBIN = $authorization->AcquirerBIN;
        $this->merchantID = $authorization->MerchantID;
        $this->transactionStatus = $authorization->TransactionStatus;
        $this->responseCodeISO = $authorization->ResponseCodeISO;
        $this->panTail = $authorization->PanTail;
        $this->panExpiryDate = $authorization->PanExpiryDate;
        $this->paymentTypePP = $authorization->PaymentTypePP;
        $this->rRN = $authorization->RRN;
        $this->cardType = $authorization->CardType;
        $this->cardholderInfo = $authorization->CardholderInfo;
        $this->installmentsNumber = $authorization->InstallmentsNumber;
        $this->ticklerMerchantCode = $authorization->TicklerMerchantCode;
        $this->ticklerPlanCode = $authorization->TicklerPlanCode;
        $this->ticklerSubscriptionCode = $authorization->TicklerSubscriptionCode;
        $this->mac = $authorization->MAC;
    }

    public function getMacArray()
    {
        return array(
            $this->authorizationType,
            $this->transactionID,
            $this->network,
            $this->orderID,
            $this->transactionAmount,
            $this->authorizedAmount,
            $this->currency,
            $this->accountedAmount,
            $this->refundedAmount,
            $this->transactionResult,
            $this->timestamp,
            strlen($this->authorizationNumber) > 0 ? $this->authorizationNumber : " ",
            $this->acquirerBIN,
            $this->merchantID,
            $this->transactionStatus,
            $this->responseCodeISO,
            $this->panTail,
            $this->panExpiryDate,
            $this->paymentTypePP,
            $this->rRN,
            $this->cardType,
            $this->cardholderInfo,
            $this->installmentsNumber,
            $this->ticklerMerchantCode,
            $this->ticklerPlanCode,
            $this->ticklerSubscriptionCode
        );
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAuthorizationType()
    {
        return $this->authorizationType;
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
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAuthorizedAmount()
    {
        return $this->authorizedAmount;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAccountedAmount()
    {
        return $this->accountedAmount;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getRefundedAmount()
    {
        return $this->refundedAmount;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTransactionResult()
    {
        return $this->transactionResult;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAuthorizationNumber()
    {
        return $this->authorizationNumber;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getAcquirerBIN()
    {
        return $this->acquirerBIN;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getMerchantID()
    {
        return $this->merchantID;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getResponseCodeISO()
    {
        return $this->responseCodeISO;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getPanTail()
    {
        return $this->panTail;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getPanExpiryDate()
    {
        return $this->panExpiryDate;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getPaymentTypePP()
    {
        return $this->paymentTypePP;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getRRN()
    {
        return $this->rRN;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getMac()
    {
        return $this->mac;
    }

}
