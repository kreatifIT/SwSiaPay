<?php
require("client/VPOSClient.php");
require("models/request/PaymentInfo.php");
require_once("utils/Utils.php");

const SHOP_ID = "129281292800013";
const PAN_ALIAS = "0000409500729966732";
const API_RESULT_KEY = "dnC8ybnbPaBSNYHsN5vq-pcaf5QXV2YHpFStxjGfY3wftC-7-PZkL5dbhP--em-DV24-YeCKMKr-ENZ-nE3JHMvqeyYDKJ3wK8b2";
const MAC_KEY_REDIRECT = "qJS-dSZx7DG-dyetrvTyS-a4CGLkBkCxY-n-SuCb-sdUbhgv5Ghea7tuXap-m4cC-RM-q-a8JGRPA-zV-dSLwnpGs4VkkrNU-Jqz";
const URL_REDIRECT = "https://atpostest.ssb.it/atpos/pagamenti/main";
const URL_DONE = "http://localhost:8080/payment-gateway/vpos/tokenize";
const URL_BACK = "http://localhost:8080/payment-gateway/vpos/tokenize";
const URLMS = "https://te.t-frutta.eu/TImooneyWS/app_api/v10/payment/cardData?consumerId=3b350c34-d923-4552-91bf-67bc4f99da92";
const URL_WEB_API = "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app";
const OPERATOR_ID = "John Doe";

$clientConfig = new ClientConfig(SHOP_ID,MAC_KEY_REDIRECT,API_RESULT_KEY,URL_WEB_API,URL_REDIRECT);

$vPOSClient = new VPOSClient($clientConfig);

echo $vPOSClient->BuildHtmlPaymentFragment(buildPaymentInfo());

function buildPaymentInfo(){
  $dataJson = new Data3DSJson();
  $dataJson->setBillAddrCity("Gotham City");
    $paymentInfo = new PaymentInfo();
    $paymentInfo->setAmount("10000");
    $paymentInfo->setCurrency("978");
    $paymentInfo->setExponent("2");
    $paymentInfo->setOrderId(Utils::generateRandomDigits());
    $paymentInfo->setShopId(SHOP_ID);
    $paymentInfo->setUrlBack(URL_BACK);
    $paymentInfo->setUrlDone(URL_DONE);
    $paymentInfo->setUrlMs(URLMS);
    $paymentInfo->setData3DS($dataJson);
    $paymentInfo->setOptions("B");
    $paymentInfo->setName("Will");
    $paymentInfo->setSurname("Smith");
    $paymentInfo->setAccountingMode("I");
    $paymentInfo->setAuthorMode("I");
    return $paymentInfo;
}
