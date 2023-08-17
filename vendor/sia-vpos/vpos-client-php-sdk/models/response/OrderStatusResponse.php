<?php
require_once(__DIR__ . "/Response.php");
require_once(__DIR__ . "/PanAliasData.php");
require_once(__DIR__ . "/CardHolderData.php");

/**
 * Class OrderStatusResponse
 */
class OrderStatusResponse extends Response
{
    private ?string $productRef = null;
    private ?string $numberOfItems = null;
    private ?array $authorizations = null;
    private ?PanAliasData $panAliasData = null;
    private ?CardHolderData $cardHolderData = null;

    /**
     * OrderStatusResponse constructor.
     * @param string $xml representation of the object
     */
    public function __construct(string $xml)
    {
        parent::__construct($xml);
        $response = new SimpleXMLElement($xml);
        $this->productRef = $response->Data->ProductRef;
        $this->numberOfItems = $response->Data->NumberOfItems;
        for ($i = 0; $i < (int)$this->numberOfItems; $i++)
            if (isset($response->Data->Authorization[$i]))
                $this->authorizations[$i] = new Authorization($response->Data->Authorization[$i]);
        if ($response->Data->PanAliasData)
            $this->panAliasData = new PanAliasData($response->Data->PanAliasData);
        if ($response->Data->CardHolderData)
            $this->cardHolderData = new CardHolderData($response->Data->CardHolderData);
    }

    /**
     * @return string|null
     */
    public function getProductRef(): ?string
    {
        return $this->productRef;
    }

    /**
     * @return int|null
     */
    public function getNumberOfItems(): ?string
    {
        return $this->numberOfItems;
    }

    /**
     * @return array|null
     */
    public function getAuthorizations(): ?array
    {
        return $this->authorizations;
    }

    /**
     * @return PanAliasData|null
     */
    public function getPanAliasData(): ?PanAliasData
    {
        return $this->panAliasData;
    }

    /**
     * @return CardHolderData|null
     */
    public function getCardHolderData(): ?CardHolderData
    {
        return $this->cardHolderData;
    }

}
