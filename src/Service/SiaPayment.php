<?php declare(strict_types=1);

namespace SwSiaPay\Service;

use PaymentInfo;
use Shopware\Core\Checkout\Order\Aggregate\OrderCustomer\OrderCustomerEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\AsyncPaymentProcessException;
use Shopware\Core\Checkout\Payment\Exception\CustomerCanceledAsyncPaymentException;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\Language\LanguageEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;


class SiaPayment implements AsynchronousPaymentHandlerInterface
{

	const SIA_PAY_URL      = 'https://virtualpos.sia.eu/vpos/payments/main?PAGE=LAND';
	const SIA_PAY_URL_TEST = 'https://virtualpostest.sia.eu/vpos/payments/main?PAGE=LAND';

	private OrderTransactionStateHandler $transactionStateHandler;
	public SystemConfigService           $systemConfigService;
	private EntityRepository             $languageRepository;
	private EntityRepository             $orderRepository;
	private RouterInterface              $router;

	private static $shopId         = '';
	private static $apiResultKey   = '';
	private static $macKeyRedirect = '';

	public function __construct(
		OrderTransactionStateHandler $transactionStateHandler,
		SystemConfigService $systemConfigService,
		EntityRepository $languageRepository,
		EntityRepository $orderRepository,
		RouterInterface $router
	) {
		$this->transactionStateHandler = $transactionStateHandler;
		$this->systemConfigService     = $systemConfigService;
		$this->languageRepository      = $languageRepository;
		$this->orderRepository         = $orderRepository;
		$this->router                  = $router;
	}

	public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
	{
		ob_start();
		try {
			$redirectUrl = $this->sendReturnUrlToExternalGateway($transaction, $salesChannelContext);
		} catch (\Exception $e) {
			throw new AsyncPaymentProcessException(
				$transaction->getOrderTransaction()->getId(), 'An error occurred during the communication with external payment gateway' . PHP_EOL . $e->getMessage()
			);
		}
		ob_get_clean();
		return new RedirectResponse($redirectUrl);
	}

	public function finalize(AsyncPaymentTransactionStruct $transaction, Request $request, SalesChannelContext $salesChannelContext): void
	{
		$paymentState  = $request->query->get('state');
		$context       = $salesChannelContext->getContext();
		$transactionId = $transaction->getOrderTransaction()->getId();

		if ($paymentState == 'canceled') {
			$this->transactionStateHandler->fail($transaction->getOrderTransaction()->getId(), $context);
			throw new CustomerCanceledAsyncPaymentException(
				$transactionId, 'Customer canceled the payment on the SIA page'
			);
		}

		if ($paymentState === 'success') {
			// Payment completed, set transaction status to "paid"
			$this->transactionStateHandler->paid($transaction->getOrderTransaction()->getId(), $context);
		} else {
			// Payment not completed, set transaction status to "open"
			$this->transactionStateHandler->reopen($transaction->getOrderTransaction()->getId(), $context);
		}
	}

	private function prepareData($transaction, $salesChannelContext): PaymentInfo
	{
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
		if (self::$shopId == '' || self::$macKeyRedirect == '' || self::$apiResultKey == '') {
			throw new AsyncPaymentProcessException(
				$transaction->getOrderTransaction()->getId(),
				'An error occurred during the communication with external payment gateway' . PHP_EOL . 'Please check your configuration (shopId,macKeyRedirect, apiResultKey)'
			);
		}
		/** @var OrderEntity $order */
		$order = $transaction->getOrder();
		$total = number_format($order->getAmountTotal(), 2, '', '');

		$languageId = $order->getLanguageId();
		$language   = $this->getLanguage($languageId, $salesChannelContext);
		$langCode   = $language->getLocale()->getCode();
		$langCode   = explode('-', $langCode)[1];

		$currencyIsoCode = $order->getCurrency()->getIsoCode();
		if ($currencyIsoCode === 'EUR') {
			$currencyIsoCode = '978';
		} else {
			throw new AsyncPaymentProcessException(
				$transaction->getOrderTransaction()->getId(),
				'An error occurred during the communication with external payment gateway' . PHP_EOL . 'Currency not supported:  ' . $currencyIsoCode
			);
		}

		$transactionUrl = $transaction->getReturnUrl();
		$queryString    = parse_url($transactionUrl, PHP_URL_QUERY);
		parse_str($queryString, $queryParams);
		$customFields = $order->getCustomFields();
		if ($customFields == null) {
			$customFields = [];
		}

		$newCustomFields = array_merge($customFields, ['_sw_payment_token' => $queryParams['_sw_payment_token']]);

		$this->orderRepository->update(
			[
				[
					'id'           => $order->getId(),
					'customFields' => $newCustomFields,
				],
			],
			$salesChannelContext->getContext()
		);

		$urlBack = $this->getSiaPaymentFinalizeUrl() . '?state=canceled&ORDERID=' . $order->getOrderNumber();
		$urlDone = $this->getSiaPaymentFinalizeUrl();

		$shopMail = $this->systemConfigService->get('core.basicInformation.email');
		/** @var OrderCustomerEntity $orderCustomer */
		$orderCustomer = $order->getOrderCustomer();

		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/models/request/Data3DSJson.php';
		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/models/request/PaymentInfo.php';

		$data3ds        = new \Data3DSJson();
		$billingAddress = $order->getBillingAddress();
		$data3ds->setBillAddrCity($billingAddress->getCity());

		$paymentInfo = new PaymentInfo();
		$paymentInfo->setAmount($total);
		$paymentInfo->setCurrency($currencyIsoCode);
		$paymentInfo->setExponent("2");
		$paymentInfo->setOrderId($order->getOrderNumber());
		$paymentInfo->setShopId(self::$shopId);
		$paymentInfo->setUrlBack($urlBack);
		$paymentInfo->setUrlDone($urlDone);
		$paymentInfo->setAccountingMode('I');
		$paymentInfo->setAuthorMode('I');
		//		$paymentInfo->setShopEmail($shopMail);
		$paymentInfo->setOptions('B');
		//		$paymentInfo->setEmail($orderCustomer->getEmail());
		//		$paymentInfo->setUserId($orderCustomer->getCustomerId());
		$paymentInfo->setName($orderCustomer->getFirstName());
		$paymentInfo->setSurname($orderCustomer->getLastName());
		$paymentInfo->setUrlMs('https://test.kreatif.it/bachmann_shop/public/api/siaPayCheck');
		$paymentInfo->setData3DS($data3ds);

		return $paymentInfo;
	}

	private function getSiaPaymentFinalizeUrl()
	{
		return $this->router->generate('frontend.sia-payment-finalize', [], UrlGeneratorInterface::ABSOLUTE_URL);
	}

	private function getLanguage($languageId, $salesChannelContext): LanguageEntity
	{
		$criteria = new Criteria([$languageId]);
		$criteria->addAssociation('locale');
		$criteria->addAssociation('translationCode');
		return $this->languageRepository->search($criteria, $salesChannelContext->getContext())->first();
	}

	private function sendReturnUrlToExternalGateway($transaction, $salesChannelContext): string
	{
		$paymentInfo = $this->prepareData($transaction, $salesChannelContext);


		if ($this->systemConfigService->get('SwSiaPay.config.siaPayUseSandbox')) {
			$siaPayWebUrl = self::SIA_PAY_URL_TEST;
		} else {
			$siaPayWebUrl = self::SIA_PAY_URL;
		}

		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/client/ClientConfig.php';
		require_once __DIR__ . '/../../vendor/sia-vpos/vpos-client-php-sdk/client/VPOSClient.php';

		$clientConfig = new \ClientConfig(self::$shopId, self::$macKeyRedirect, self::$apiResultKey, '', $siaPayWebUrl);
		$vPOSClient   = new \VPOSClient($clientConfig);
		return $vPOSClient->buildRedirectURL($paymentInfo);
	}
}
