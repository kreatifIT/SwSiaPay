<?php
require_once(__DIR__ . "/Request.php");


class Auth3DS2Step0 extends Request
{
    public const OPERATION = "THREEDSAUTHORIZATION0";
    private const AUTH3DS2STEP0_REQUEST_TAG = "ThreeDSAuthorization0Request";

    //compulsory
    private string $orderID;
    private string $pan;
    private string $expDate;
    private string $amount;
    private string $currency;


    private string $exponent;
    private string $accountingMode;
    private string $network;
    private string $emailCH;
    private string $nameCH;
    private string $threeDSData;

    //not compulsory
    private ?string $cvv2 = null;
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
    private ?string $createPanAlias = null;
    private ?string $notifURL = null;
    private ?string $cPROF = null;
    private ?string $threeDSMtdNotifURL = null;
    private ?string $challengeWinSize = null;
    private ?string $tRecurr = null;
    private ?string $cRecurr = null;
    private ?string $installmentsNumber = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getXML(): string
    {
        $xml = $this->getXMLOpening();

        //start from </Header>
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
        XMLUtils::appendTag($xml, self::NAME_CH_TAG, $this->nameCH);
        XMLUtils::appendTag($xml, self::USER_ID_TAG, $this->userID);
        XMLUtils::appendTag($xml, self::ACQUIRER_TAG, $this->acquirer);
        XMLUtils::appendTag($xml, self::OPDESCR_TAG, $this->opDescr);
        XMLUtils::appendTag($xml, self::IP_ADDRESS_TAG, $this->ipAddress);
        XMLUtils::appendTag($xml, self::USR_AUTH_FLAG_TAG, $this->usrAuthFlag);
        XMLUtils::appendTag($xml, self::ANTIFRAUD_TAG, $this->antifraud);
        XMLUtils::appendTag($xml, self::PRODUCTREF_TAG, $this->productRef);
        XMLUtils::appendTag($xml, self::NAME_TAG, $this->name);
        XMLUtils::appendTag($xml, self::SURNAME_TAG, $this->surname);
        XMLUtils::appendTag($xml, self::TAX_ID_TAG, $this->taxID);
        XMLUtils::appendTag($xml, self::THREEDS_DATA_TAG, $this->threeDSData);
        XMLUtils::appendTag($xml, self::NOTIF_URL_TAG, $this->notifURL);
        XMLUtils::appendTag($xml, self::CHALLENGE_WIN_SIZE_TAG, $this->challengeWinSize);
        XMLUtils::appendTag($xml, self::T_RECURR_TAG, $this->tRecurr);
        XMLUtils::appendTag($xml, self::C_RECURR_TAG, $this->cRecurr);
        XMLUtils::appendTag($xml, self::INSTALLMENTS_NUMBER_TAG, $this->installmentsNumber);
        XMLUtils::appendTag($xml, self::CPROF_TAG, $this->cPROF);
        XMLUtils::appendTag($xml, self::THREEDS_MTD_NOTIF_URL, $this->threeDSMtdNotifURL);
        XMLUtils::appendTag($xml, self::OPTIONS_TAG, $this->options);

        $xml .= $this->getXMLClosing();
        $xml = str_replace(static::OPERATION_TAG_VALUE, static::OPERATION, $xml);
        $xml = $xml = str_replace(static::VARIABLE_REQUEST_TAG, static::AUTH3DS2STEP0_REQUEST_TAG, $xml);
        return $xml;
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
            "USRAUTHFLAG" => $this->usrAuthFlag,
            "OPDESCR" => $this->opDescr,
            "OPTIONS" => $this->options,
            "ANTIFRAUD" => $this->antifraud,
            "PRODUCTREF" => $this->productRef,
            "NAME" => $this->name,
            "SURNAME" => $this->surname,
            "TAXID" => $this->taxID,
            "THREEDSDATA" => $this->threeDSData,
            "NAMECH" => $this->nameCH,
            "NOTIFURL" => $this->notifURL,
            "THREEDSMTDNOTIFURL" => $this->threeDSMtdNotifURL,
            "CHALLENGEWINSIZE" => $this->challengeWinSize,
            "TRECURR" => $this->tRecurr,
            "CRECURR" => $this->cRecurr,
            "INSTALLMENTSNUMBER" => $this->installmentsNumber
        );
    }

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
     * @return string
     */
    public function getEmailCH(): string
    {
        return $this->emailCH;
    }

    /**
     * @param string $emailCH
     */
    public function setEmailCH(string $emailCH): void
    {
        $this->emailCH = $emailCH;
    }

    /**
     * @return string
     */
    public function getNameCH(): string
    {
        return $this->nameCH;
    }

    /**
     * @param string $nameCH
     */
    public function setNameCH(string $nameCH): void
    {
        $this->nameCH = $nameCH;
    }

    /**
     * @return string
     */
    public function getThreeDSData(): string
    {
        return $this->threeDSData;
    }

    /**
     * @param string $threeDSData
     */
    public function setThreeDSData(string $threeDSData): void
    {
        $this->threeDSData = $threeDSData;
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
    public function getOptions(): ?string
    {
        return $this->options;
    }

    /**
     * @param string|null $options
     */
    public function setOptions(?string $options): void
    {
        $this->options = $options;
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
     * @return string|null
     */
    public function getNotifURL(): ?string
    {
        return $this->notifURL;
    }

    /**
     * @param string|null $notifURL
     */
    public function setNotifURL(?string $notifURL): void
    {
        $this->notifURL = $notifURL;
    }

    /**
     * @return string|null
     */
    public function getCPROF(): ?string
    {
        return $this->cPROF;
    }

    /**
     * @param string|null $cPROF
     */
    public function setCPROF(?string $cPROF): void
    {
        $this->cPROF = $cPROF;
    }

    /**
     * @return string|null
     */
    public function getThreeDSMtdNotifURL(): ?string
    {
        return $this->threeDSMtdNotifURL;
    }

    /**
     * @param string|null $threeDSMtdNotifURL
     */
    public function setThreeDSMtdNotifURL(?string $threeDSMtdNotifURL): void
    {
        $this->threeDSMtdNotifURL = $threeDSMtdNotifURL;
    }

    /**
     * @return string|null
     */
    public function getChallengeWinSize(): ?string
    {
        return $this->challengeWinSize;
    }

    /**
     * @param string|null $challengeWinSize
     */
    public function setChallengeWinSize(?string $challengeWinSize): void
    {
        $this->challengeWinSize = $challengeWinSize;
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

}
