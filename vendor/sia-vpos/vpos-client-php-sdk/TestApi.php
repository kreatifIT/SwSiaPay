<?php
require("client/VPOSClient.php");
require("models/PaymentInfo.php");
require_once("utils/Utils.php");

const SHOP_ID = "129281292800013";
const PAN_ALIAS = "0000409500729966732";
const API_RESULT_KEY = "E-vmE-GHXmx73-Lfg24LztZ-7-yCyVsKn4QXphL5qzf-Kr-Cf-JWpZwZgaZRA5dR9V677xL4uCbc-Ce--8h2-tdrSu--QKjF-nZh";
const MAC_KEY_REDIRECT = "fU-9et-s-Sj8W---E8uhUDu9fEzqr8hH3L95s48r9nq-cq3cBXbp-tZsvGQU--t-nqmtaW-7x-7-C2PdcuFdbHuShQ-pYVWnr-4-";
const URL_REDIRECT = "https://atpostest.ssb.it/atpos/pagamenti/main";
const URL_DONE = "http://localhost:8080/payment-gateway/vpos/tokenize";
const URL_BACK = "http://localhost:8080/payment-gateway/vpos/tokenize";
const URLMS = "https://te.t-frutta.eu/TImooneyWS/app_api/v10/payment/cardData?consumerId=3b350c34-d923-4552-91bf-67bc4f99da92";
const URL_WEB_API = "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app";
const OPERATOR_ID = "John Doe";

$vPOSClient = new VPOSClient(MAC_KEY_REDIRECT, API_RESULT_KEY, URL_WEB_API);

$vPOSClient->startAuth3DS(buildAuth3DSTest1());


function buildRefundTest()
{
    return new RefundRequestDto(SHOP_ID, "operator",
        "8032112928AT1ep4n2gzown54", "726527839399",
        "100", "978", "2", "jopokokok");
}

function buildAuth3DSTest1()
{
    $dto = new Auth3DSDto();
    $dto->setIsMasterpass(false);
    $dto->setOrderId(Utils::generateRandomDigits());
    $dto->setPan(PAN_ALIAS);
    $dto->setExpDate("2112");
    $dto->setAmount("2000");
    $dto->setCurrency("978");
    $dto->setCvv2("111");
    $dto->setAccountingMode("I");
    $dto->setNetwork("98");
    $dto->setShopId(SHOP_ID);
    $dto->setOperatorId("operator");
    return $dto;
}

function buildVerifyTest()
{
    $dto = new VerifyRequestDto();
    $dto->setOriginalReqRefNum("20200128979407875088471785269188");
    $dto->setShopId(SHOP_ID);
    $dto->setOperatorId("Giammaicol");
    return $dto;
}

function buildConfirmTest()
{
    $dto = new ConfirmRequestDto();
    $dto->setShopId(SHOP_ID);
    $dto->setOperatorId("Giammaicol");
    $dto->setTransactionId("8032112928AT1i3e29q9u4yv4");
    $dto->setOrderId("424882487593");
    $dto->setAmount("200");
    $dto->setCurrency("978");
    $dto->setExponent("2");
    $dto->setAccountingMode("I");
    $dto->setCloseOrder("S");
    return $dto;
}

function buildOrderStatusTest()
{
    $dto = new OrderStatusRequestDto(SHOP_ID, "Giammaicol",
        "424882487593", "dedetv435t4ff4f", "");
    return $dto;
}
