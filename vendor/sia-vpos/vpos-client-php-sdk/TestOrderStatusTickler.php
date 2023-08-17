<?php
require_once("utils/Utils.php");
require_once("models/request/OrderStatusRequest.php");
require_once("client/VPOSClient.php");
require_once("client/ClientConfig.php");


const SHOP_ID = "123451231231231";
const PAN_ALIAS = "0000298241731500671";
const API_RESULT_KEY = "RsZ-cNF32-rKb-Gy-xxzb2W-b9p-Cz--Q4F3GhXS-EDgz---t-g4fKwSWeWgMWkhw-R-ZLjstQcDmBc-Aamg-LLngtdJBf2LV-MR";
const MAC_KEY_REDIRECT = "RsZ-cNF32-rKb-Gy-xxzb2W-b9p-Cz--Q4F3GhXS-EDgz---t-g4fKwSWeWgMWkhw-R-ZLjstQcDmBc-Aamg-LLngtdJBf2LV-MR";
const URL_WEB_API = "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app";
const URL_REDIRECT = "https://atpostest.ssb.it/atpos/pagamenti/main";

date_default_timezone_set('Europe/Rome');
$config = new ClientConfig(SHOP_ID, MAC_KEY_REDIRECT, API_RESULT_KEY, URL_WEB_API, URL_REDIRECT);
$vPOSClient = new VPOSClient($config);
$response = $vPOSClient->getOrderStatus(buildOrderStatusRequest());
var_dump($response);


function buildOrderStatusRequest()
{
    $dto = new OrderStatusRequest();
    $dto->setOperatorId("jondoeee");
    $dto -> setOrderId("test20210518112729594");
    return $dto;
}



