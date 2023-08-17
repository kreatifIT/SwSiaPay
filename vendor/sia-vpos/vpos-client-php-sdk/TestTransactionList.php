<?php
require("utils/Utils.php");
require("models/request/TransactionListRequestDto.php");
require("client/VPOSClient.php");

const SHOP_ID = "129281292800109";
const PAN_ALIAS = "0000409500729966732";
const API_RESULT_KEY = "E-vmE-GHXmx73-Lfg24LztZ-7-yCyVsKn4QXphL5qzf-Kr-Cf-JWpZwZgaZRA5dR9V677xL4uCbc-Ce--8h2-tdrSu--QKjF-nZh";
const MAC_KEY_REDIRECT = "fU-9et-s-Sj8W---E8uhUDu9fEzqr8hH3L95s48r9nq-cq3cBXbp-tZsvGQU--t-nqmtaW-7x-7-C2PdcuFdbHuShQ-pYVWnr-4-";
const URL_WEB_API = "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app";


$vPOSClient = new VPOSClient(MAC_KEY_REDIRECT, API_RESULT_KEY, URL_WEB_API);
$response = $vPOSClient->getTransactionList(buildTransactionList());
var_dump($response);

function buildTransactionList()
{
    $dto = new TransactionListRequestDto();
    $dto->setShopId(SHOP_ID);
    $dto->setOperatorId("operator");
    $dto->setFilter("4");
    $dto->setStartDate("");
    $dto->setEndDate("");
    $dto->setTransactionId("");
    return $dto;
}

