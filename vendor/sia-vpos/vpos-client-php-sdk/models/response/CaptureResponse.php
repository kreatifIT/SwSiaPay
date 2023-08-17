<?php
require_once(__DIR__ . "/Response.php");
require_once(__DIR__ . "/Operation.php");

/**
 * Class CaptureResponse
 */
class CaptureResponse extends Response
{
    private ?Operation $operation = null;

    /**
     * CaptureResponse constructor.
     * @param string $xml representation of the object
     */
    public function __construct(string $xml)
    {
        parent::__construct($xml);
        $response = new SimpleXMLElement($xml);
        if (isset($response->Data->Operation))
            $this->operation = new Operation($response->Data->Operation);
    }

    /**
     * @return Operation|null
     */
    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

}