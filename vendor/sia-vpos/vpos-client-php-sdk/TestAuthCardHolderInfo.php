<?php
require_once("utils/Utils.php");
require_once("models/request/Authorize.php");
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
$response = $vPOSClient->startAuthorize(buildAuth());
var_dump($response);


function buildAuth()
{
    $dto = new Authorize();
    $dto->setOperatorId("jondoeee");
    $dto -> setAmount("660");
    $dto -> setAccountingMode("D");
    $dto->setPan("5577231205012597");
    $dto->setExpDate("2212");
    $dto -> setCvv2("111");
    $dto->setCurrency("978");
    $dto -> setNetwork("02");
    $dto->setEmailCH("asjas@dfd.it");
    $dto->setExponent("2");
    $dto->setOrderID("8734443444785426");

    return $dto;
}



