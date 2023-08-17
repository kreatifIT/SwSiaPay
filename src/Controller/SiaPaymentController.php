<?php

declare(strict_types=1);

namespace SwSiaPay\Controller;


use ClientConfig;
use GuzzleHttp\Client;
use OrderStatusRequest;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Controller\StorefrontController;
use SwSiaPay\Service\SiaPayment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use VPOSClient;


/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class SiaPaymentController extends StorefrontController
{
	private static $shopId         = '';
	private static $apiResultKey   = '';
	private static $macKeyRedirect = '';


	private EntityRepository   $orderRepository;
	private RouterInterface    $router;
	public SystemConfigService $systemConfigService;

	public function __construct(
		EntityRepository $orderRepository,
		RouterInterface $router,
		SystemConfigService $systemConfigService
	) {
		$this->orderRepository     = $orderRepository;
		$this->router              = $router;
		$this->systemConfigService = $systemConfigService;
	}

	/**
	 * @Route("/sia-payment-finalize", name="frontend.sia-payment-finalize", methods={"GET"})
	 */
	public function siaPaymentFinalize(Request $request, SalesChannelContext $context): Response
	{
		$redirectUrl = null;
		if ($request->get('RESULT') || $request->get('state')) {
			if ($request->get('ORDERID')) {
				$orderNumber = $request->get('ORDERID');
				$responseParams = $request->query->all();
				$criteria = new Criteria();
				$criteria->addFilter(new EqualsFilter('orderNumber', $orderNumber));
				$order = $this->orderRepository->search($criteria, $context->getContext())->first();

				$customFields = $order->getCustomFields();

				$newCustomFields = array_merge($customFields, $responseParams);

				$this->orderRepository->update(
					[
						[
							'id'           => $order->getId(),
							'customFields' => $newCustomFields,
						],
					],
					$context->getContext()
				);

				$finalizeUrl = $this->router->generate(
					'payment.finalize.transaction',
					[
						'_sw_payment_token' => $customFields['_sw_payment_token'],
					],
					UrlGeneratorInterface::ABSOLUTE_URL
				);

				if ($request->get('state') === 'canceled') {
					$redirectUrl = $finalizeUrl . '&state=canceled';
				} else {
					if ($request->get('RESULT') == '00') {
						// gegen Prüfung erstellen mit der Transaction ID ob die OrderNumber und der Betrag stimmen
						$check = $this->checkSiaPaymentStatus($orderNumber, $order->getAmountTotal(), $request->get('TRANSACTIONID'));
						if ($check) {
							// redirect to success page with payment_token and success
							$redirectUrl = $finalizeUrl . '&state=success';
						} else {
							$redirectUrl = $finalizeUrl . '&state=failed';
						}
					} else {
						// redirect to success page with payment_token and success
						$redirectUrl = $finalizeUrl . '&state=failed';
					}
				}
			}
		}
		return $redirectUrl ? $this->redirect($redirectUrl) : $this->redirectToRoute('frontend.home.page');
	}


	private function checkSiaPaymentStatus(string $orderNumber, $amount, string $transactionId)
	{
		if ($this->systemConfigService->get('SwSiaPay.config.siaPayUseSandbox')) {
			$siaPayWebUrl = 'https://atpostest.ssb.it/atpos/apibo/apiBOXML.app';
		} else {
			$siaPayWebUrl = SiaPayment::SIA_PAY_URL;
		}

		$useSandBox = $this->systemConfigService->get('SwSiaPay.config.siaPayUseSandbox');
		if ($useSandBox) {
			self::$shopId         = $this->systemConfigService->get('SwSiaPay.config.sandboxShopId');
			self::$macKeyRedirect = $this->systemConfigService->get('SwSiaPay.config.sandboxMacKeyRedirect');
			self::$apiResultKey   = $this->systemConfigService->get('SwSiaPay.config.sandboxApiResultKey');
		} else {
			self::$shopId         = $this->systemConfigService->get('SwSiaPay.config.shopId');
			self::$macKeyRedirect = $this->systemConfigService->get('SwSiaPay.config.macKeyRedirect');
			self::$apiResultKey   = $this->systemConfigService->get('SwSiaPay.config.apiResultKey');
		}

		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/client/ClientConfig.php';
		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/client/VPOSClient.php';

		date_default_timezone_set('Europe/Rome');
		$clientConfig  = new ClientConfig(self::$shopId, self::$macKeyRedirect, self::$apiResultKey, $siaPayWebUrl, '');
		$vPOSClient    = new VPOSClient($clientConfig);
		$requestParams = $this->buildOrderStatusDto($orderNumber);
		$response      = $vPOSClient->getOrderStatus($requestParams);
		if ($response->getNumberOfItems()) {
			$authorizations = $response->getAuthorizations();
			$total          = number_format($amount, 2, '', '');

			foreach ($authorizations as $authorization) {
				$transactionResult = $authorization->getTransactionResult();
				$authorizedAmount  = $authorization->getAuthorizedAmount();
				$_orderId          = $authorization->getOrderId();
				if ($transactionResult == '00' && $authorizedAmount === $total && $_orderId === $orderNumber) {
					return true;
				}
			}
		}
		return false;
	}

	private function buildOrderStatusDto($orderNumber): OrderStatusRequest
	{
		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/models/request/OrderStatusRequest.php';
		$dto = new OrderStatusRequest();
		$dto->setOrderId($orderNumber);
		$operatorId = $this->generateOperatorID(8, 16);
		$dto->setOperatorId($operatorId);
		return $dto;
	}

	private function generateOperatorID($minLength, $maxLength)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$length     = mt_rand($minLength, $maxLength);
		$operatorID = '';

		for ($i = 0; $i < $length; $i++) {
			$operatorID .= $characters[mt_rand(0, strlen($characters) - 1)];
		}

		return $operatorID;
	}
}

