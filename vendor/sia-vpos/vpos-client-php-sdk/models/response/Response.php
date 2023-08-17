<?php

/**
 * Class Response
 */
abstract class Response
{
    public string $timestamp;
    public string $result;
    public string $mac;

    /**
     * Response constructor.
     * @param string $xml representation of the object
     */
    public function __construct(string $xml)
    {
        $response = new SimpleXMLElement($xml);
        $this->timestamp = $response->Timestamp;
        $this->result = $response->Result;
        $this->mac = $response->MAC;
    }

    public function getMacArray()
    {
        return array($this->timestamp, $this->result);
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
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return SimpleXMLElement|string
     */
    public function getMac()
    {
        return $this->mac;
    }

}