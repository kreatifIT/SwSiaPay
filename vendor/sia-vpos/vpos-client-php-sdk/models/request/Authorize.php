<?php
require_once(__DIR__ . "/Request.php");


class Authorize extends Request
{

    public const OPERATION = "AUTHORIZATION";
    private const AUTHORIZE_REQUEST_TAG = "AuthorizationRequest";

    private string $orderID;
    private string $pan;
    private ?string $cvv2 = null;
    private string $expDate;
    private ?string $createPanAlias = null;
    private string $amount;
    private string $currency;
    private string $exponent;
    private string $accountingMode;
    private string $network;
    private ?string $tRecurr = null;
    private ?string $cRecurr = null;
    private ?string $installmentsNumber = null;
    private ?string $emailCH = null;

    /**
     * @return string
     */
    public function getOrderID(): string
    {
        return $this->orderID;
    }

    /**
     * @param string $orderID
     */
    public function setOrderID(string $orderID): void
    {
        $this->orderID = $orderID;
    }

    /**
     * @return string
     */
    public function getPan(): string
    {
        return $this->pan;
    }

    /**
     * @param string $pan
     */
    public function setPan(string $pan): void
    {
        $this->pan = $pan;
    }

    /**
     * @return string|null
     */
    public function getCvv2(): ?string
    {
        return $this->cvv2;
    }

    /**
     * @param string|null $cvv2
     */
    public function setCvv2(?string $cvv2): void
    {
        $this->cvv2 = $cvv2;
    }

    /**
     * @return string
     */
    public function getExpDate(): string
    {
        return $this->expDate;
    }

    /**
     * @param string $expDate
     */
    public function setExpDate(string $expDate): void
    {
        $this->expDate = $expDate;
    }

    /**
     * @return string|null
     */
    public function getCreatePanAlias(): ?string
    {
        return $this->createPanAlias;
    }

    /**
     * @param string|null $createPanAlias
     */
    public function setCreatePanAlias(?string $createPanAlias): void
    {
        $this->createPanAlias = $createPanAlias;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getExponent(): string
    {
        return $this->exponent;
    }

    /**
     * @param string $exponent
     */
    public function setExponent(string $exponent): void
    {
        $this->exponent = $exponent;
    }

    /**
     * @return string
     */
    public function getAccountingMode(): string
    {
        return $this->accountingMode;
    }

    /**
     * @param string $accountingMode
     */
    public function setAccountingMode(string $accountingMode): void
    {
        $this->accountingMode = $accountingMode;
    }

    /**
     * @return string
     */
    public function getNetwork(): string
    {
        return $this->network;
    }

    /**
     * @param string $network
     */
    public function setNetwork(string $network): void
    {
        $this->network = $network;
    }

    /**
     * @return string|null
     */
    public function getEmailCH(): ?string
    {
        return $this->emailCH;
    }

    /**
     * @param string|null $emailCH
     */
    public function setEmailCH(?string $emailCH): void
    {
        $this->emailCH = $emailCH;
    }

    /**
     * @return string|null
     */
    public function getUserID(): ?string
    {
        return $this->userID;
    }

    /**
     * @param string|null $userID
     */
    public function setUserID(?string $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return string|null
     */
    public function getAcquirer(): ?string
    {
        return $this->acquirer;
    }

    /**
     * @param string|null $acquirer
     */
    public function setAcquirer(?string $acquirer): void
    {
        $this->acquirer = $acquirer;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @param string|null $ipAddress
     */
    public function setIpAddress(?string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string|null
     */
    public function getUsrAuthFlag(): ?string
    {
        return $this->usrAuthFlag;
    }

    /**
     * @param string|null $usrAuthFlag
     */
    public function setUsrAuthFlag(?string $usrAuthFlag): void
    {
        $this->usrAuthFlag = $usrAuthFlag;
    }

    /**
     * @return string|null
     */
    public function getOpDescr(): ?string
    {
        return $this->opDescr;
    }

    /**
     * @param string|null $opDescr
     */
    public function setOpDescr(?string $opDescr): void
    {
        $this->opDescr = $opDescr;
    }

    /**
     * @return string|null
     */
    public function getAntifraud(): ?string
    {
        return $this->antifraud;
    }

    /**
     * @param string|null $antifraud
     */
    public function setAntifraud(?string $antifraud): void
    {
        $this->antifraud = $antifraud;
    }

    /**
     * @return string|null
     */
    public function getProductRef(): ?string
    {
        return $this->productRef;
    }

    /**
     * @param string|null $productRef
     */
    public function setProductRef(?string $productRef): void
    {
        $this->productRef = $productRef;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getTaxID(): ?string
    {
        return $this->taxID;
    }

    /**
     * @param string|null $taxID
     */
    public function setTaxID(?string $taxID): void
    {
        $this->taxID = $taxID;
    }

    /**
     * @return string|null
     */
    public function getTRecurr(): ?string
    {
        return $this->tRecurr;
    }

    /**
     * @param string|null $tRecurr
     */
    public function setTRecurr(?string $tRecurr): void
    {
        $this->tRecurr = $tRecurr;
    }

    /**
     * @return string|null
     */
    public function getCRecurr(): ?string
    {
        return $this->cRecurr;
    }

    /**
     * @param string|null $cRecurr
     */
    public function setCRecurr(?string $cRecurr): void
    {
        $this->cRecurr = $cRecurr;
    }

    /**
     * @return string|null
     */
    public function getInstallmentsNumber(): ?string
    {
        return $this->installmentsNumber;
    }

    /**
     * @param string|null $installmentsNumber
     */
    public function setInstallmentsNumber(?string $installmentsNumber): void
    {
        $this->installmentsNumber = $installmentsNumber;
    }


    private ?string $userID = null;
    private ?string $acquirer = null;
    private ?string $ipAddress = null;
    private ?string $usrAuthFlag = null;
    private ?string $opDescr = null;
    private ?string $antifraud = null;
    private ?string $productRef = null;
    private ?string $name = null;
    private ?string $surname = null;
    private ?string $taxID = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getXML(): string
    {
        $xml = $this->getXMLOpening();

        XMLUtils::appendTag($xml, self::ORDER_ID_TAG, $this->orderID);
        XMLUtils::appendTag($xml, self::PAN_TAG, $this->pan);
        XMLUtils::appendTag($xml, self::CVV2_TAG, $this->cvv2);
        XMLUtils::appendTag($xml, self::CREATE_PAN_ALIAS_TAG, $this->createPanAlias);
        XMLUtils::appendTag($xml, self::EXPDATE_TAG, $this->expDate);
        XMLUtils::appendTag($xml, self::AMOUNT_TAG, $this->amount);
        XMLUtils::appendTag($xml, self::CURRENCY_TAG, $this->currency);
        XMLUtils::appendTag($xml, self::EXPONENT_TAG, $this->exponent);
        XMLUtils::appendTag($xml, self::ACCOUNTING_MODE_TAG, $this->accountingMode);
        XMLUtils::appendTag($xml, self::NETWORK_TAG, $this->network);
        XMLUtils::appendTag($xml, self::EMAIL_CH_TAG, $this->emailCH);
        XMLUtils::appendTag($xml, self::USER_ID_TAG, $this->userID);
        XMLUtils::appendTag($xml, self::ACQUIRER_TAG, $this->acquirer);
        XMLUtils::appendTag($xml, self::USR_AUTH_FLAG_TAG, $this->usrAuthFlag);
        XMLUtils::appendTag($xml, self::OPDESCR_TAG, $this->opDescr);
        XMLUtils::appendTag($xml, self::OPTIONS_TAG, $this->options);
        XMLUtils::appendTag($xml, self::ANTIFRAUD_TAG, $this->antifraud);
        XMLUtils::appendTag($xml, self::PRODUCTREF_TAG, $this->productRef);
        XMLUtils::appendTag($xml, self::NAME_TAG, $this->name);
        XMLUtils::appendTag($xml, self::SURNAME_TAG, $this->surname);
        XMLUtils::appendTag($xml, self::TAX_ID_TAG, $this->taxID);
        XMLUtils::appendTag($xml, self::T_RECURR_TAG, $this->tRecurr);
        XMLUtils::appendTag($xml, self::C_RECURR_TAG, $this->cRecurr);
        XMLUtils::appendTag($xml, self::INSTALLMENTS_NUMBER_TAG, $this->installmentsNumber);

        $xml .= $this->getXMLClosing();
        $xml = str_replace(static::OPERATION_TAG_VALUE, static::OPERATION, $xml);
        return str_replace(static::VARIABLE_REQUEST_TAG, static::AUTHORIZE_REQUEST_TAG, $xml);
    }

    public function getMacArray(): array
    {
        return array(
            "OPERATION" => self::OPERATION,
            "TIMESTAMP" => $this->timestamp,
            "SHOPID" => $this->shopId,
            "ORDERID" => $this->orderID,
            "OPERATORID" => $this->operatorId,
            "REQREFNUM" => $this->reqRefNum,
            "PAN" => $this->pan,
            "CVV2" => $this->cvv2,
            "EXPDATE" => $this->expDate,
            "AMOUNT" => $this->amount,
            "CURRENCY" => $this->currency,
            "EXPONENT" => $this->exponent,
            "ACCOUNTINGMODE" => $this->accountingMode,
            "NETWORK" => $this->network,
            "EMAILCH" => $this->emailCH,
            "USERID" => $this->userID,
            "ACQUIRER" => $this->acquirer,
            "IPADDRESS" => $this->ipAddress,
            "OPDESCR" => $this->opDescr,
            "USRAUTHFLAG" => $this->usrAuthFlag,
            "OPTIONS" => $this->options,
            "ANTIFRAUD" => $this->antifraud,
            "PRODUCTREF" => $this->productRef,
            "NAME" => $this->name,
            "SURNAME" => $this->surname,
            "TAXID" => $this->taxID,
            "TRECURR" => $this->tRecurr,
            "CRECURR" => $this->cRecurr,
            "INSTALLMENTSNUMBER" => $this->installmentsNumber
        );
    }
}
