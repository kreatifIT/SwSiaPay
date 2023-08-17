<?php
require_once(__DIR__ . "/Response.php");
require_once(__DIR__ . "/Operation.php");

/**
 * Class RefundResponse
 */
class RefundResponse extends Response
{
    private ?string $plafondRestoringResult = null;
    private ?Operation $operation = null;

    /**
     * RefundResponse constructor.
     * @param string $xml representation of the object
     */
    public function __construct(string $xml)
    {
        parent::__construct($xml);
        $response = new SimpleXMLElement($xml);
        if (isset($response->Data->PlafondRestoringResult))
            $this->plafondRestoringResult = $response->Data->PlafondRestoringResult;
        if (isset($response->Data->Operation))
            $this->operation = new Operation($response->Data->Operation);
    }

    /**
     * @return string|null
     */
    public function getPlafondRestoringResult(): ?string
    {
        return $this->plafondRestoringResult;
    }

    /**
     * @return Operation|null
     */
    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

}