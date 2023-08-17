<?php
require_once("utils/Utils.php");
require_once("models/request/Auth3DS2Step0.php");
require_once("client/VPOSClient.php");
require_once("client/ClientConfig.php");


const SHOP_ID = "129281292800013";
const PAN_ALIAS = "0000298241731500671";
const API_RESULT_KEY = "dnC8ybnbPaBSNYHsN5vq-pcaf5QXV2YHpFStxjGfY3wftC-7-PZkL5dbhP--em-DV24-YeCKMKr-ENZ-nE3JHMvqeyYDKJ3wK8b2";
const MAC_KEY_REDIRECT = "dnC8ybnbPaBSNYHsN5vq-pcaf5QXV2YHpFStxjGfY3wftC-7-PZkL5dbhP--em-DV24-YeCKMKr-ENZ-nE3JHMvqeyYDKJ3wK8b2";
const URL_WEB_API = "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app";
const URL_REDIRECT = "https://atpostest.ssb.it/atpos/pagamenti/main";

date_default_timezone_set('Europe/Rome');
$config = new ClientConfig(SHOP_ID, MAC_KEY_REDIRECT, API_RESULT_KEY, URL_WEB_API, URL_REDIRECT);
$vPOSClient = new VPOSClient($config);
$response = $vPOSClient->start3DS2Step0(buildAuth3DSStep0());
var_dump($response);


function buildAuth3DSStep0()
{
    $dto = new Auth3DS2Step0();
    $dto->setOperatorId("jondoeee");
    $dto -> setAmount("660");
    $dto -> setAccountingMode("D");
    $dto->setPan("4118830900940017");
    $dto->setExpDate("2112");
    $dto -> setCvv2("111");
    $dto->setCurrency("978");
    $dto -> setNetwork("01");
    $dto->setEmailCH("asjas@dfd.it");
    $dto->setExponent("2");
    $dto ->setNameCH("mario");
    $dto -> setOrderID("123448244447691");
    $dto->setNotifURL("https://atpostest.ssb.it/atpos/apibo/en/3ds-notification.html");
    $dto -> setThreeDSMtdNotifURL("https://atpostest.ssb.it/atpos/apibo/en/3ds-notification.html");
    $dto -> setThreeDSData('{"addrMatch":"N","chAccAgeInd":"04","chAccChange":"20190211","chAccChangeInd":"03","chAccDate":"20190210","chAccPwChange":"20190214","chAccPwChangeInd":"04","nbPurchaseAccount":"1000","txnActivityDay":"100","txnActivityYear":"100","shipAddressUsage":"20181220","shipAddressUsageInd":"03","shipNameIndicator":"01","billAddrCity":"billAddrCity","billAddrCountry":"004","billAddrLine1":"billAddrLine1","billAddrLine2":"billAddrLine2","billAddrLine3":"billAddrLine3","billAddrPostCode":"billAddrPostCode","billAddrState":"11","homePhone":"039-321818198111","mobilePhone":"33-312","shipAddrCity":"zio","shipAddrCountry":"008","shipAddrLine1":"shipAddrLine1","shipAddrLine2":"shipAddrLine2","shipAddrLine3":"shipAddrLine3","shipAddrPostCode":"shipAddrPostCode","shipAddrState":"222","workPhone":"39-0321818198","deliveryEmailAddress":"a-b@example.com","deliveryTimeframe":"02","preOrderDate":"20181220","preOrderPurchaseInd":"01","reorderItemsInd":"02","shipIndicator":"01","browserAcceptHeader":"text/html,application/xhtml+xml,application/xml;","browserIP":"10.42.195.152","browserJavaEnabled":"true","browserLanguage":"it-IT","browserColorDepth":"16","browserScreenHeight":"1024","browserScreenWidth":"1920","browserTZ":"-120","browserUserAgent":"Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0"}');

    return $dto;
}



