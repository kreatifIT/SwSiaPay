<?php

require_once(__DIR__ . "/../models/request/RefundRequest.php");
require_once(__DIR__ . "/../models/request/CaptureRequest.php");
require_once(__DIR__ . "/../models/request/OrderStatusRequest.php");
require_once(__DIR__ . "/../models/response/Auth3DS2Step0Response.php");
require_once(__DIR__ . "/../models/response/Auth3DS2Step1Response.php");
require_once(__DIR__ . "/../models/response/Auth3DS2Step2Response.php");
require_once(__DIR__ . "/../models/response/OrderStatusResponse.php");
require_once(__DIR__ . "/../models/response/AuthorizeResponse.php");
require_once(__DIR__ . "/../models/response/Authorization.php");


require_once(__DIR__ . "/../utils/apos/RestClient.php");
require_once(__DIR__ . "/../utils/mac/Encoder.php");
require_once(__DIR__ . "/../utils/encryption/AESEncoder.php");
require_once(__DIR__ . "/../utils/HTMLGenerator.php");
require_once(__DIR__ . "/./ClientConfig.php");

/**
 * Class VPOSClient
 *
 * Client used to perform common requests to SIA VPOS.
 */
class VPOSClient
{
	private const MAC_NEUTRAL_VALUE     = "NULL";
	private const BAD_REQUEST           = "03";
	private const INCORRECT_MAC         = "04";
	private const MAC_EXCEPTION_MESSAGE = "Response MAC is not valid! Possible data corruption!";

	private string $shopID;
	private string $startKey;
	private string $apiKey;
	private string $redirectUrl;
	private string $urlWebApi;

	private RestClient    $restClient;
	private Encoder       $encoder;
	private HTMLGenerator $htmlUtils;

	/**
	 * VPOSClient constructor.
	 *
	 * @param ClientConfig $startKey
	 */
	public function __construct(ClientConfig $config)
	{
		$this->restClient  = new RestClient();
		$this->encoder     = new Encoder();
		$this->htmlUtils   = new HTMLGenerator();
		$this->shopID      = $config->shopID;
		$this->apiKey      = $config->apiKey;
		$this->redirectUrl = $config->redirectUrl;
		$this->urlWebApi   = $config->urlWebApi;
		$this->startKey    = $config->startKey;
	}

	/**
	 * KREATIF CUSTOM FUNCTION
	 */

	public function buildRedirectURL(PaymentInfo $info): string
	{
		$info->setShopId($this->shopID);
		$infoMap = $info->getMacArray();
		if (isset($infoMap["3DSDATA"])) {
			$infoMap["3DSDATA"] = AESEncoder::encrypt($this->apiKey, $infoMap["3DSDATA"]);
		}
		$infoMap["MAC"]     = $this->encoder->getRequestMac($infoMap, $this->startKey);
		$infoMap["URLBACK"] = $info->getUrlBack();

		//				dump($this->redirectUrl);
		//				dump($infoMap);
		//				$redirectUrl = $this->redirectUrl . '&' . html_entity_decode(http_build_query($infoMap));
		//				dump($redirectUrl);
		//				exit;
		return $this->redirectUrl . '&' . html_entity_decode(http_build_query($infoMap));
	}

	/**
	 * Create an HTML document ready to use for payment initiation. The method returns
	 * the custom template with an hidden form containing all the payment parameters in case of
	 * precedent HTML injection. Default template is returned otherwise.
	 *
	 * @param PaymentInfo $info    data transfer object containing all the payment parameters
	 * @param string      $urlApos VPOS redirect base path
	 *
	 * @return string the HTML document fragment
	 */
	public function BuildHtmlPaymentFragment(PaymentInfo $info): string
	{
		$info->setShopId($this->shopID);
		$infoMap = $info->getMacArray();
		if (isset($infoMap["3DSDATA"])) {
			$infoMap["3DSDATA"] = AESEncoder::encrypt($this->apiKey, $infoMap["3DSDATA"]);
		}
		$infoMap["MAC"]     = $this->encoder->getRequestMac($infoMap, $this->startKey);
		$infoMap["URLBACK"] = $info->getUrlBack();

		if (isset($infoMap["TOKEN"])) {
			return $this->htmlUtils->htmlOutput($this->redirectUrl, $infoMap, true);
		}
		return $this->htmlUtils->htmlOutput($this->redirectUrl, $infoMap, false);
	}

	/**
	 * Validate the result of a payment initiation verifying the integrity of the data contained in URMLS/URLDONE
	 *
	 * @param array  $values      parameters received from SIA VPOS
	 * @param string $receivedMac to compare with the calculated one
	 *
	 * @return bool true if data is intact, false otherwise
	 */
	public function verifyMAC(array $values, string $receivedMac): bool
	{
		$macArray = [
			"ORDERID"         => $values["ORDERID"],
			"SHOPID"          => $values["SHOPID"],
			"AUTHNUMBER"      => $values["AUTHNUMBER"],
			"AMOUNT"          => $values["AMOUNT"],
			"CURRENCY"        => $values["CURRENCY"],
			"EXPONENT"        => $values["EXPONENT"],
			"TRANSACTIONID"   => $values["TRANSACTIONID"],
			"ACCOUNTINGMODE"  => $values["ACCOUNTINGMODE"],
			"AUTHORMODE"      => $values["AUTHORMODE"],
			"RESULT"          => $values["RESULT"],
			"TRANSACTIONTYPE" => $values["TRANSACTIONTYPE"],
			"ISSUERCOUNTRY"   => $values["ISSUERCOUNTRY"],
			"AUTHCODE"        => $values["AUTHCODE"],
			"PAYERID"         => $values["PAYERID"],
			"PAYER"           => $values["PAYER"],
			"PAYERSTATUS"     => $values["PAYERSTATUS"],
			"HASHPAN"         => $values["HASHPAN"],
			"PANALIASREV"     => $values["PANALIASREV"],
			"PANALIAS"        => $values["PANALIAS"],
			"PANALIASEXPDATE" => $values["PANALIASEXPDATE"],
			"PANALIASTAIL"    => $values["PANALIASTAIL"],
			"MASKEDPAN"       => $values["MASKEDPAN"],
			"PANTAIL"         => $values["PANTAIL"],
			"PANEXPIRYDATE"   => $values["PANEXPIRYDATE"],
			"ACCOUNTHOLDER"   => $values["ACCOUNTHOLDER"],
			"IBAN"            => $values["IBAN"],
			"ALIASSTR"        => $values["ALIASSTR"],
			"ACQUIRERBIN"     => $values["ACQUIRERBIN"],
			"MERCHANTID"      => $values["MERCHANTID"],
			"CARDTYPE"        => $values["CARDTYPE"],
		];

		return $this->encoder->getRequestMac($macArray, $this->apiKey) === $receivedMac;
	}


	/**
	 * @param Authorize $dto data transfer object containing all the required parameters to perform the initial step of a 3DS2 authorization
	 *
	 * @return AuthorizeResponse the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function startAuthorize(Authorize $dto): AuthorizeResponse
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new AuthorizeResponse($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidAuthMac($response->getAuthorization()) || !$this->isValidPanAliasData($response->getPanAliasData())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}


	/**
	 * @param Auth3DS2Step0 $dto data transfer object containing all the required parameters to perform the initial step of a 3DS2 authorization
	 *
	 * @return Auth3DS2Step0Response the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function start3DS2Step0(Auth3DS2Step0 $dto): Auth3DS2Step0Response
	{
		$dto->setShopId($this->shopID);
		$dto->setThreeDSData(AESEncoder::encrypt($this->apiKey, $dto->getThreeDSData()));
		$xmlResponse = $this->performCall($dto);
		$response    = new Auth3DS2Step0Response($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidAuthMac($response->getAuthorization()) || !$this->isValidThreeDSMethod(
				$response->getThreeDsMethod()
			) || !$this->isValidThreeDSChallenge($response->getThreeDSChallenge()) || !$this->isValidPanAliasData($response->getPanAliasData())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}

	/**
	 * @param Auth3DS2Step1 $dto data transfer object containing all the required parameters to perform the following step of a 3DS2 authorization
	 *
	 * @return Auth3DS2Step1Response the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function start3DS2Step1(Auth3DS2Step1 $dto): Auth3DS2Step1Response
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new Auth3DS2Step1Response($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidAuthMac($response->getAuthorization()) || !$this->isValidThreeDSChallenge(
				$response->getThreeDSChallenge()
			) || !$this->isValidPanAliasData($response->getPanAliasData())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}

	/**
	 * @param Auth3DS2Step2 $dto data transfer object containing all the required parameters to perform the last step of a 3DS2 authorization
	 *
	 * @return Auth3DS2Step2Response the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function start3DS2Step2(Auth3DS2Step2 $dto): Auth3DS2Step2Response
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new Auth3DS2Step2Response($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidAuthMac($response->getAuthorization()) || !$this->isValidPanAliasData($response->getPanAliasData())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}

	/**
	 * @param CaptureRequest $dto data transfer object containing all the required parameters to perform a payment confirmation
	 *
	 * @return CaptureResponse the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function capture(CaptureRequest $dto): CaptureResponse
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new CaptureResponse($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidOperationMac($response->getOperation())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}


	/**
	 * @param RefundRequest $dto data transfer object containing all the required parameters to perform a payment refund
	 *
	 * @return RefundResponse the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function refundPayment(RefundRequest $dto): RefundResponse
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new RefundResponse($xmlResponse);
		if (!$this->isValidResponseMac($response) || !$this->isValidOperationMac($response->getOperation())) {
			throw new Exception(self::MAC_EXCEPTION_MESSAGE);
		}
		return $response;
	}

	/**
	 * @param OrderStatusRequest $dto data transfer object containing all the required parameters to perform an order status request
	 *
	 * @return OrderStatusResponse the outcome of the operation with the relative additional infos
	 * @throws Exception in case of data corruption
	 */
	public function getOrderStatus(OrderStatusRequest $dto): OrderStatusResponse
	{
		$dto->setShopId($this->shopID);
		$xmlResponse = $this->performCall($dto);
		$response    = new OrderStatusResponse($xmlResponse);
		if ($this->isValidResponseMac($response) && $this->isValidPanAliasData($response->getPanAliasData())) {
			for ($i = 0; $i < (int)$response->getNumberOfItems(); $i++) {
				if (!$this->isValidAuthMac($response->getAuthorizations()[$i])) {
					throw new Exception("Authorization with index " . $i . " has not a valid MAC");
				}
			}
			return $response;
		}
		throw new Exception(self::MAC_EXCEPTION_MESSAGE);
	}

	public function setProxy(string $proxyName, int $port)
	{
		$this->restClient->setProxy($proxyName, $port);
	}

	public function setProxyWithAuth(string $proxyName, int $port, string $user, string $password)
	{
		$this->restClient->setProxyWithAuth($proxyName, $port, $user, $password);
	}

	public function setBasicAuth(string $user, string $password)
	{
		$this->restClient->setBasicAuth($user, $password);
	}

	public function disableProxy()
	{
		$this->restClient->disableProxy();
	}

	public function disableBasicAuth()
	{
		$this->restClient->disableBasicAuth();
	}

	private function performCall(Request $dto): string
	{
		$xml = $dto->getXML();
		$xml = str_replace(Request::MAC_TAG_VALUE, $this->encoder->getRequestMac($dto->getMacArray(), $this->apiKey), $xml);
		return $this->restClient->callAPI($this->urlWebApi, urlencode($xml));
	}

	private function isValidResponseMac(?Response $response)
	{
		$calculatedMac = $this->encoder->getResponseMac($response->getMacArray(), $this->apiKey);
		return strcmp($response->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $response->getMac() || !$this->isMacComputable($response);
	}

	private function isValidAuthMac(?Authorization $authorization)
	{
		if (isset($authorization)) {
			$calculatedMac = $this->encoder->getResponseMac($authorization->getMacArray(), $this->apiKey);
			return strcmp($authorization->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $authorization->getMac();
		}
		return true;
	}


	private function isValidOperationMac(?Operation $operation)
	{
		if (isset($operation)) {
			$calculatedMac = $this->encoder->getResponseMac($operation->getMacArray(), $this->apiKey);
			return strcmp($operation->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $operation->getMac();
		}
		return true;
	}

	private function isValidVBVRedirectMac(?VBVRedirect $vbvRedirect)
	{
		if (isset($vbvRedirect)) {
			$calculatedMac = $this->encoder->getResponseMac($vbvRedirect->getMacArray(), $this->apiKey);
			return strcmp($vbvRedirect->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $vbvRedirect->getMac();
		}
		return true;
	}

	private function isValidPanAliasData(?PanAliasData $panAliasData)
	{
		if (isset($panAliasData)) {
			$calculatedMac = $this->encoder->getResponseMac($panAliasData->getMacArray(), $this->apiKey);
			return strcmp($panAliasData->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $panAliasData->getMac();
		}
		return true;
	}


	private function isValidThreeDSChallenge(?ThreeDSChallenge $threeDSChallenge)
	{
		if (isset($threeDSChallenge)) {
			$calculatedMac = $this->encoder->getResponseMac($threeDSChallenge->getMacArray(), $this->apiKey);
			return strcmp($threeDSChallenge->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $threeDSChallenge->getMac();
		}
		return true;
	}

	private function isValidThreeDSMethod(?ThreeDSMethod $threeDSMethod)
	{
		if (isset($threeDSMethod)) {
			$calculatedMac = $this->encoder->getResponseMac($threeDSMethod->getMacArray(), $this->apiKey);
			return strcmp($threeDSMethod->getMac(), self::MAC_NEUTRAL_VALUE) == 0 || $calculatedMac === $threeDSMethod->getMac();
		}
		return true;
	}

	private function isMacComputable(?Response $response)
	{
		if (isset($response)) {
			return strcmp($response->getResult(), self::INCORRECT_MAC) != 0 && strcmp($response->getResult(), self::BAD_REQUEST) != 0;
		}
		return false;
	}

}
