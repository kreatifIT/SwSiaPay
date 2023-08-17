<?php
require_once(__DIR__ . "/Data3DSJson.php");

/**
 * Class PaymentInfo
 *
 * Data model used to build the payment initiation HTML
 *
 */
class PaymentInfo
{
    private string $amount;
    private string $currency;
    private string $exponent;
    private string $orderId;
    private string $shopId;
    private string $urlBack;
    private string $urlDone;
    private string $urlMs;
    private string $accountingMode;
    private string $authorMode;
    private string $mac;

    //not compulsory fields
    private ?string $lang = null;
    private ?string $shopEmail = null;
    private ?string $options = null;
    private ?string $lockcard = null;
    private ?string $commis = null;
    private ?string $email = null;
    private ?string $ordDescr = null;
    private ?string $vsid = null;
    private ?string $opDescr = null;
    private ?string $remainingDuration = null;
    private ?string $userId = null;
    private ?string $bpPostepay = null;
    private ?string $bpCards = null;
    private ?string $phoneNumber = null;
    private ?string $causation = null;
    private ?string $user = null;
    private ?string $name = null;
    private ?string $surname = null;
    private ?string $taxId = null;
    private ?string $productRef = null;
    private ?string $antiFraud = null;
    private ?string $trecurr = null;
    private ?string $crecurr = null;
    private ?string $token = null;
    private ?string $expDate = null;
    private ?string $network = null;
    private ?string $iban = null;
    private ?string $nameCH = null;
    private ?string $surnameCH = null;
    private ?string $data3DS = null;

    /**
     * @return string|null
     */
    public function getTrecurr(): ?string
    {
        return $this->trecurr;
    }

    /**
     * @param string|null $trecurr
     */
    public function setTrecurr(?string $trecurr): void
    {
        $this->trecurr = $trecurr;
    }

    /**
     * @return string|null
     */
    public function getCrecurr(): ?string
    {
        return $this->crecurr;
    }

    /**
     * @param string|null $crecurr
     */
    public function setCrecurr(?string $crecurr): void
    {
        $this->crecurr = $crecurr;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getExpDate(): ?string
    {
        return $this->expDate;
    }

    /**
     * @param string|null $expDate
     */
    public function setExpDate(?string $expDate): void
    {
        $this->expDate = $expDate;
    }

    /**
     * @return string|null
     */
    public function getNetwork(): ?string
    {
        return $this->network;
    }

    /**
     * @param string|null $network
     */
    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }

    /**
     * @return string|null
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @param string|null $iban
     */
    public function setIban(?string $iban): void
    {
        $this->iban = $iban;
    }

    /**
     * @return string|null
     */
    public function getNameCH(): ?string
    {
        return $this->nameCH;
    }

    /**
     * @param string|null $nameCH
     */
    public function setNameCH(?string $nameCH): void
    {
        $this->nameCH = $nameCH;
    }

    /**
     * @return string|null
     */
    public function getSurnameCH(): ?string
    {
        return $this->surnameCH;
    }

    /**
     * @param string|null $surnameCH
     */
    public function setSurnameCH(?string $surnameCH): void
    {
        $this->surnameCH = $surnameCH;
    }

    /**
     * @return array
     */
    public function getMacArray(): array
    {
        return array(
            "URLMS" => $this->urlMs,
            "URLDONE" => $this->urlDone,
            "ORDERID" => $this->orderId,
            "SHOPID" => $this->shopId,
            "AMOUNT" => $this->amount,
            "CURRENCY" => $this->currency,
            "EXPONENT" => $this->exponent,
            "ACCOUNTINGMODE" => $this->accountingMode,
            "AUTHORMODE" => $this->authorMode,
            "OPTIONS" => $this->options,
            "NAME" => strpos($this->options,"B") !== false?$this->name:null,
            "SURNAME" =>strpos($this->options,"B") !== false?$this->surname:null,
            "TAXID" => $this->taxId,
            "LOCKCARD" => $this->lockcard,
            "COMMIS" => strpos($this->options,"F") !== false?$this->commis:null,
            "ORDDESCR" => strpos($this->options,"O") !== false||strpos("V",$this->options) !== false?$this->ordDescr:null,
            "VSID" => $this->vsid,
            "OPDESCR" => $this->opDescr,
            "REMAININGDURATION" => strpos($this->options,"D") !== false?$this->remainingDuration:null,
            "USERID" => $this->userId,
            "BP_POSTEPAY" => $this->bpPostepay,
            "BP_CARDS" => $this->bpCards,
            "PHONENUMBER" => $this->network == "91"?$this->phoneNumber:null,
            "CAUSATION" => $this->network == "91"?$this->causation:null,
            "USER" => $this->network == "91"?$this->userId:null,
            "PRODUCTREF" => $this->productRef,
            "ANTIFRAUD" => $this->antiFraud,
            "3DSDATA" => $this->data3DS,
            "TRECURR" => $this->trecurr,
            "CRECURR" => $this->crecurr,
            "TOKEN" => $this->token,
            "EXPDATE" => $this->expDate,
            "NETWORK" => $this->network,
            "IBAN" => $this->iban,
            "LANG" => $this->lang,
            "SHOPEMAIL" => $this->shopEmail,
            "EMAIL" => $this->email,
            "NAMECH" => $this->nameCH,
            "SURNAMECH" => $this->surnameCH
        );
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
     * @param string $exponent
     */
    public function setExponent(string $exponent): void
    {
        $this->exponent = $exponent;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @param string $shopId
     */
    public function setShopId(string $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * @param string $urlBack
     */
    public function setUrlBack(string $urlBack): void
    {
        $this->urlBack = $urlBack;
    }

    public function getUrlBack(): ?string
    {
        return $this->urlBack;
    }

    /**
     * @param string $urlDone
     */
    public function setUrlDone(string $urlDone): void
    {
        $this->urlDone = $urlDone;
    }

    /**
     * @param string $urlMs
     */
    public function setUrlMs(string $urlMs): void
    {
        $this->urlMs = $urlMs;
    }

    /**
     * @param string $accountingMode
     */
    public function setAccountingMode(string $accountingMode): void
    {
        $this->accountingMode = $accountingMode;
    }

    /**
     * @param string $authorMode
     */
    public function setAuthorMode(string $authorMode): void
    {
        $this->authorMode = $authorMode;
    }

    /**
     * @param string $mac
     */
    public function setMac(string $mac): void
    {
        $this->mac = $mac;
    }

    /**
     * @param string|null $lang
     */
    public function setLang(?string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @param string|null $shopEmail
     */
    public function setShopEmail(?string $shopEmail): void
    {
        $this->shopEmail = $shopEmail;
    }

    /**
     * @param string|null $options
     */
    public function setOptions(?string $options): void
    {
        $this->options = $options;
    }

    /**
     * @param string|null $lockcard
     */
    public function setLockcard(?string $lockcard): void
    {
        $this->lockcard = $lockcard;
    }

    /**
     * @param string|null $commis
     */
    public function setCommis(?string $commis): void
    {
        $this->commis = $commis;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string|null $ordDescr
     */
    public function setOrdDescr(?string $ordDescr): void
    {
        $this->ordDescr = $ordDescr;
    }

    /**
     * @param string|null $vsid
     */
    public function setVsid(?string $vsid): void
    {
        $this->vsid = $vsid;
    }

    /**
     * @param string|null $opDescr
     */
    public function setOpDescr(?string $opDescr): void
    {
        $this->opDescr = $opDescr;
    }

    /**
     * @param string|null $remainingDuration
     */
    public function setRemainingDuration(?string $remainingDuration): void
    {
        $this->remainingDuration = $remainingDuration;
    }

    /**
     * @param string|null $userId
     */
    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param string|null $bpPostepay
     */
    public function setBpPostepay(?string $bpPostepay): void
    {
        $this->bpPostepay = $bpPostepay;
    }

    /**
     * @param string|null $bpCards
     */
    public function setBpCards(?string $bpCards): void
    {
        $this->bpCards = $bpCards;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @param string|null $causation
     */
    public function setCausation(?string $causation): void
    {
        $this->causation = $causation;
    }

    /**
     * @param string|null $user
     */
    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @param string|null $taxId
     */
    public function setTaxId(?string $taxId): void
    {
        $this->taxId = $taxId;
    }

    /**
     * @param string|null $productRef
     */
    public function setProductRef(?string $productRef): void
    {
        $this->productRef = $productRef;
    }

    /**
     * @param string|null $antiFraud
     */
    public function setAntiFraud(?string $antiFraud): void
    {
        $this->antiFraud = $antiFraud;
    }

    /**
     * @param Data3DSJson|null $data3DS
     */
    public function setData3DS(?Data3DSJson $data3DS): void
    {
        $this->data3DS = $data3DS;
    }

}
