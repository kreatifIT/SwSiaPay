<?php


/**
 * Class AESEncoder
 *
 * Utility class used to encrypt Data3DS field in redirect messages
 *
 * @author Gabriel Raul Marini
 */
class AESEncoder
{
	private const CIPHER = 'AES-128-CBC';

	/**
	 * Encrypt input text using AES-128-CBC algorithm
	 *
	 * @param string $secretKey 16/24/32 -characters secret password
	 * @param string $plainText Text for encryption
	 *
	 * @return self Self object instance with data or error message
	 */
	public static function encrypt($secretKey, $plainText): ?string
	{
		try {
			$secretKey = substr($secretKey, 0, 16);
			if (!static::isKeyLengthValid($secretKey)) {
				throw new \InvalidArgumentException("Secret key's length must be exactly 128 bits");
			}
			$initVector = null;
			// Encrypt input text
			$initVector = str_pad($initVector, 16, "\0");

			$raw    = openssl_encrypt(
				$plainText,
				static::CIPHER,
				$secretKey,
				OPENSSL_RAW_DATA,
				$initVector
			);
			$result = base64_encode($raw);
			if ($result === false) {
				// Operation failed
				return new static($initVector, null, openssl_error_string());
			}
			// Return successful encoded object
			return $result;
		} catch (\Exception $e) {
			return new static(isset($initVector), null, $e->getMessage());
		}
	}


	/**
	 * Check that secret password length is valid
	 *
	 * @param string $secretKey 16 -characters secret password
	 *
	 * @return bool
	 */
	public static function isKeyLengthValid($secretKey)
	{
		return strlen($secretKey) == 16;
	}

}
