<?php
require_once(__DIR__ . "/MacCalculator.php");
require_once(__DIR__ . "/AlgorithmEnum.php");

/**
 * Class Encoder
 *
 * Utility class used to perform MAC calculations for request and response messages
 *
 * @author Gabriel Raul Marini
 */
class Encoder
{
    private MacCalculator $macCalculator;

    /**
     * Encoder constructor.
     */
    public function __construct()
    {
        $this->macCalculator = new MacCalculator(AlgorithmEnum::SHA_256);
    }

    /**
     * @param array $map of key -> values from which MAC string is built
     * @param string $key used in the HMAC digest calculation
     * @return string the MAC calculated from the input values
     */
    public function getRequestMac(array $map, string $key)
    {
        $macString = "";
        foreach ($map as $index => $value) {
            if (isset($map[$index]) && strlen($value) > 0) {
                $macString .= $index;
                $macString .= "=";
                $macString .= $value;
                $macString .= "&";
            }
        }

        $macString = substr($macString, 0, strlen($macString) - 1);
        return $this->macCalculator->calculate($macString, $key);
    }

    /**
     * @param array $values the values from which MAC string is built
     * @param string $key used to calculate the HMAC digest
     * @return string the MAC calculated on the values list
     */
    public function getResponseMac(array $values, string $key)
    {
        $macString = "";
        foreach ($values as $value) {
            if (isset($value) && strlen($value) > 0) {
                $macString .= trim($value);
                $macString .= "&";
            }
        }

        $macString = substr($macString, 0, strlen($macString) - 1);
        return $this->macCalculator->calculate($macString, $key);
    }

}
