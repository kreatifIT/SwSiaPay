
<?php


/**
 * Class Data3DSJson
 *
 * Model of Data3DS field used in payment operation via redirect url.
 *
 */
class Data3DSJson
{
    private ?string  $threeDSRequestorChallengeInd = null;
    private ?string  $addrMatch = null;
    private ?string  $chAccAgeInd = null;
    private ?string  $chAccChange = null;
    private ?string  $chAccChangeInd = null;
    private ?string  $chAccDate = null;
    private ?string  $chAccPwChange = null;
    private ?string  $chAccPwChangeInd = null;
    private ?string  $nbPurchaseAccount = null;
    private ?string  $txnActivityDay = null;
    private ?string  $txnActivityYear = null;
    private ?string  $shipAddressUsage = null;
    private ?string  $shipAddressUsageInd = null;
    private ?string  $shipNameIndicator = null;
    private ?string  $acctID = null;
    private ?string  $billAddrCity = null;
    private ?string  $billAddrCountry = null;
    private ?string  $billAddrLine1 = null;
    private ?string  $billAddrLine2 = null;
    private ?string  $billAddrLine3 = null;
    private ?string  $billAddrPostCode = null;
    private ?string  $billAddrState = null;
    private ?string  $homePhone = null;
    private ?string  $mobilePhone = null;
    private ?string  $shipAddrCity = null;
    private ?string  $shipAddrCountry = null;
    private ?string  $shipAddrLine1 = null;
    private ?string  $shipAddrLine2 = null;
    private ?string  $shipAddrLine3 = null;
    private ?string  $shipAddrPostCode = null;
    private ?string  $shipAddrState = null;
    private ?string  $workPhone = null;
    private ?string  $deliveryEmailAddress = null;
    private ?string  $deliveryTimeframe = null;
    private ?string  $preOrderDate = null;
    private ?string  $preOrderPurchaseInd = null;

    public function __toString()
    {
        $json = "{";
        foreach (get_object_vars($this) as $name => $value) {
            if (!is_null($value)) {
                $json .= "\"" . $name . "\"";
                $json .= ":";
                $json .= "\"" . $value . "\"";
                $json .= ",";
            }
        }
        $json = substr($json, 0, strlen($json) - 1);
        $json .= "}";
        return $json;
    }

    /**
     * @param string|null $threeDSRequestorChallengeInd
     */
    public function setThreeDSRequestorChallengeInd(?string $threeDSRequestorChallengeInd): void
    {
        $this->threeDSRequestorChallengeInd = $threeDSRequestorChallengeInd;
    }

    /**
     * @param string|null $addrMatch
     */
    public function setAddrMatch(?string $addrMatch): void
    {
        $this->addrMatch = $addrMatch;
    }

    /**
     * @param string|null $chAccAgeInd
     */
    public function setChAccAgeInd(?string $chAccAgeInd): void
    {
        $this->chAccAgeInd = $chAccAgeInd;
    }

    /**
     * @param string|null $chAccChange
     */
    public function setChAccChange(?string $chAccChange): void
    {
        $this->chAccChange = $chAccChange;
    }

    /**
     * @param string|null $chAccChangeInd
     */
    public function setChAccChangeInd(?string $chAccChangeInd): void
    {
        $this->chAccChangeInd = $chAccChangeInd;
    }

    /**
     * @param string|null $chAccDate
     */
    public function setChAccDate(?string $chAccDate): void
    {
        $this->chAccDate = $chAccDate;
    }

    /**
     * @param string|null $chAccPwChange
     */
    public function setChAccPwChange(?string $chAccPwChange): void
    {
        $this->chAccPwChange = $chAccPwChange;
    }

    /**
     * @param string|null $chAccPwChangeInd
     */
    public function setChAccPwChangeInd(?string $chAccPwChangeInd): void
    {
        $this->chAccPwChangeInd = $chAccPwChangeInd;
    }

    /**
     * @param string|null $nbPurchaseAccount
     */
    public function setNbPurchaseAccount(?string $nbPurchaseAccount): void
    {
        $this->nbPurchaseAccount = $nbPurchaseAccount;
    }

    /**
     * @param string|null $txnActivityDay
     */
    public function setTxnActivityDay(?string $txnActivityDay): void
    {
        $this->txnActivityDay = $txnActivityDay;
    }

    /**
     * @param string|null $txnActivityYear
     */
    public function setTxnActivityYear(?string $txnActivityYear): void
    {
        $this->txnActivityYear = $txnActivityYear;
    }

    /**
     * @param string|null $shipAddressUsage
     */
    public function setShipAddressUsage(?string $shipAddressUsage): void
    {
        $this->shipAddressUsage = $shipAddressUsage;
    }

    /**
     * @param string|null $shipAddressUsageInd
     */
    public function setShipAddressUsageInd(?string $shipAddressUsageInd): void
    {
        $this->shipAddressUsageInd = $shipAddressUsageInd;
    }

    /**
     * @param string|null $shipNameIndicator
     */
    public function setShipNameIndicator(?string $shipNameIndicator): void
    {
        $this->shipNameIndicator = $shipNameIndicator;
    }

    /**
     * @param string|null $acctID
     */
    public function setAcctID(?string $acctID): void
    {
        $this->acctID = $acctID;
    }

    /**
     * @param string|null $billAddrCity
     */
    public function setBillAddrCity(?string $billAddrCity): void
    {
        $this->billAddrCity = $billAddrCity;
    }

    /**
     * @param string|null $billAddrCountry
     */
    public function setBillAddrCountry(?string $billAddrCountry): void
    {
        $this->billAddrCountry = $billAddrCountry;
    }

    /**
     * @param string|null $billAddrLine1
     */
    public function setBillAddrLine1(?string $billAddrLine1): void
    {
        $this->billAddrLine1 = $billAddrLine1;
    }

    /**
     * @param string|null $billAddrLine2
     */
    public function setBillAddrLine2(?string $billAddrLine2): void
    {
        $this->billAddrLine2 = $billAddrLine2;
    }

    /**
     * @param string|null $billAddrLine3
     */
    public function setBillAddrLine3(?string $billAddrLine3): void
    {
        $this->billAddrLine3 = $billAddrLine3;
    }

    /**
     * @param string|null $billAddrPostCode
     */
    public function setBillAddrPostCode(?string $billAddrPostCode): void
    {
        $this->billAddrPostCode = $billAddrPostCode;
    }

    /**
     * @param string|null $billAddrState
     */
    public function setBillAddrState(?string $billAddrState): void
    {
        $this->billAddrState = $billAddrState;
    }

    /**
     * @param string|null $homePhone
     */
    public function setHomePhone(?string $homePhone): void
    {
        $this->homePhone = $homePhone;
    }

    /**
     * @param string|null $mobilePhone
     */
    public function setMobilePhone(?string $mobilePhone): void
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @param string|null $shipAddrCity
     */
    public function setShipAddrCity(?string $shipAddrCity): void
    {
        $this->shipAddrCity = $shipAddrCity;
    }

    /**
     * @param string|null $shipAddrCountry
     */
    public function setShipAddrCountry(?string $shipAddrCountry): void
    {
        $this->shipAddrCountry = $shipAddrCountry;
    }

    /**
     * @param string|null $shipAddrLine1
     */
    public function setShipAddrLine1(?string $shipAddrLine1): void
    {
        $this->shipAddrLine1 = $shipAddrLine1;
    }

    /**
     * @param string|null $shipAddrLine2
     */
    public function setShipAddrLine2(?string $shipAddrLine2): void
    {
        $this->shipAddrLine2 = $shipAddrLine2;
    }

    /**
     * @param string|null $shipAddrLine3
     */
    public function setShipAddrLine3(?string $shipAddrLine3): void
    {
        $this->shipAddrLine3 = $shipAddrLine3;
    }

    /**
     * @param string|null $shipAddrPostCode
     */
    public function setShipAddrPostCode(?string $shipAddrPostCode): void
    {
        $this->shipAddrPostCode = $shipAddrPostCode;
    }

    /**
     * @param string|null $shipAddrState
     */
    public function setShipAddrState(?string $shipAddrState): void
    {
        $this->shipAddrState = $shipAddrState;
    }

    /**
     * @param string|null $workPhone
     */
    public function setWorkPhone(?string $workPhone): void
    {
        $this->workPhone = $workPhone;
    }

    /**
     * @param string|null $deliveryEmailAddress
     */
    public function setDeliveryEmailAddress(?string $deliveryEmailAddress): void
    {
        $this->deliveryEmailAddress = $deliveryEmailAddress;
    }

    /**
     * @param string|null $deliveryTimeframe
     */
    public function setDeliveryTimeframe(?string $deliveryTimeframe): void
    {
        $this->deliveryTimeframe = $deliveryTimeframe;
    }

    /**
     * @param string|null $preOrderDate
     */
    public function setPreOrderDate(?string $preOrderDate): void
    {
        $this->preOrderDate = $preOrderDate;
    }

    /**
     * @param string|null $preOrderPurchaseInd
     */
    public function setPreOrderPurchaseInd(?string $preOrderPurchaseInd): void
    {
        $this->preOrderPurchaseInd = $preOrderPurchaseInd;
    }

}
