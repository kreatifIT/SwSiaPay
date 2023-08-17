<?php


/**
 * Class MacCalculator
 *
 * Perform simple HMAC calculations to support integrity check with mutual authentication
 *
 * @author Gabriel Raul Marini
 */
class MacCalculator
{
    private string $algorithm;

    /**
     * MacCalculator constructor.
     * @param int $algorithmIndex use AlgorithmEnum to specify the hash algorithm
     */
    public function __construct(int $algorithmIndex)
    {
        $algorithmArray = hash_hmac_algos();
        $this->algorithm = $algorithmArray[$algorithmIndex];
    }

    /**
     * @param string $value input string from which MAC is calculated
     * @param string $key used to encode the string
     * @return string the MAC in HEX format
     */
    public function calculate(string $value, string $key)
    {
//        echo "Calculating MAC on: " . $value . "\n";
        $mac = hash_hmac($this->algorithm, $value, $key);
//        echo "Calculated MAC: " . $mac . "\n";
        return $mac;
    }
}
