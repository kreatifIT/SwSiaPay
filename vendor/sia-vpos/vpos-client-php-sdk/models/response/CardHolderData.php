<?php

/**
 * Class PanAliasData
 */
class CardHolderData
{

    private ?string $cardHolderName;
    private ?string $cardHolderEmail;
    private ?string $billingAddressPostalcode;
    private ?string $billingAddressCity;
    private ?string $billingAddressLine1;
    private ?string $billingAddressLine2;
    private ?string $billingAddressLine3;
    private ?string $billingAddressState;
    private ?string $billingAddressCountry;
    private ?string $mac = null;

    /**
     * PanAliasData constructor.
     * @param SimpleXMLElement $panAliasData xml model of the object
     */
    public function __construct(SimpleXMLElement $cardHolderData)
    {
        $this->cardHolderName = $cardHolderData->CardHolderName;
        $this->cardHolderEmail = $cardHolderData->CardHolderEmail;
        $this->billingAddressPostalcode = $cardHolderData->BillingAddressPostalcode;
        $this->billingAddressCity = $cardHolderData->BillingAddressCity;
        $this->billingAddressLine1 = $cardHolderData->BillingAddressLine1;
        $this->billingAddressLine2 = $cardHolderData->BillingAddressLine2;
        $this->billingAddressLine3 = $cardHolderData->BillingAddressLine3;
        $this->billingAddressState = $cardHolderData->BillingAddressState;
        $this->billingAddressCountry = $cardHolderData->BillingAddressCountry;
        $this->mac = $cardHolderData->MAC;
    }

    /**
     * @return array used to perform integrity check
     */
    public function getMacArray()
    {
        return array(
            $this->cardHolderName,
            $this->cardHolderEmail,
            $this->billingAddressPostalcode,
            $this->billingAddressCity,
            $this->billingAddressLine1,
            $this->billingAddressLine2,
            $this->billingAddressLine3,
            $this->billingAddressState,
            $this->billingAddressCountry
        );
    }

    /**
     * @return string|null
     */
    public function getCardHolderName(): ?string
    {
        return $this->cardHolderName;
    }

    /**
     * @param string|null $cardHolderName
     */
    public function setCardHolderName(?string $cardHolderName): void
    {
        $this->cardHolderName = $cardHolderName;
    }

    /**
     * @return string|null
     */
    public function getCardHolderEmail(): ?string
    {
        return $this->cardHolderEmail;
    }

    /**
     * @param string|null $cardHolderEmail
     */
    public function setCardHolderEmail(?string $cardHolderEmail): void
    {
        $this->cardHolderEmail = $cardHolderEmail;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressPostalcode(): ?string
    {
        return $this->billingAddressPostalcode;
    }

    /**
     * @param string|null $billingAddressPostalcode
     */
    public function setBillingAddressPostalcode(?string $billingAddressPostalcode): void
    {
        $this->billingAddressPostalcode = $billingAddressPostalcode;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressCity(): ?string
    {
        return $this->billingAddressCity;
    }

    /**
     * @param string|null $billingAddressCity
     */
    public function setBillingAddressCity(?string $billingAddressCity): void
    {
        $this->billingAddressCity = $billingAddressCity;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressLine1(): ?string
    {
        return $this->billingAddressLine1;
    }

    /**
     * @param string|null $billingAddressLine1
     */
    public function setBillingAddressLine1(?string $billingAddressLine1): void
    {
        $this->billingAddressLine1 = $billingAddressLine1;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressLine2(): ?string
    {
        return $this->billingAddressLine2;
    }

    /**
     * @param string|null $billingAddressLine2
     */
    public function setBillingAddressLine2(?string $billingAddressLine2): void
    {
        $this->billingAddressLine2 = $billingAddressLine2;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressLine3(): ?string
    {
        return $this->billingAddressLine3;
    }

    /**
     * @param string|null $billingAddressLine3
     */
    public function setBillingAddressLine3(?string $billingAddressLine3): void
    {
        $this->billingAddressLine3 = $billingAddressLine3;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressState(): ?string
    {
        return $this->billingAddressState;
    }

    /**
     * @param string|null $billingAddressState
     */
    public function setBillingAddressState(?string $billingAddressState): void
    {
        $this->billingAddressState = $billingAddressState;
    }

    /**
     * @return string|null
     */
    public function getBillingAddressCountry(): ?string
    {
        return $this->billingAddressCountry;
    }

    /**
     * @param string|null $billingAddressCountry
     */
    public function setBillingAddressCountry(?string $billingAddressCountry): void
    {
        $this->billingAddressCountry = $billingAddressCountry;
    }

}
