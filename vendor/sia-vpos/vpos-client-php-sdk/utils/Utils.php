<?php


/**
 * Class Utils
 *
 * General purpose utility class
 *
 * @author Gabriel Raul Marini
 */
class Utils
{
    private const MIN = 0;
    private const MAX = 9;
    private const LENGTH = 24;

    /**
     * @return string a random number of 24 digits
     */
    public static function generateRandomDigits()
    {
        $rnd = "";
        for ($i = 0; $i < self::LENGTH; $i++)
            $rnd .= rand(self::MIN, self::MAX);
        return $rnd;
    }
}