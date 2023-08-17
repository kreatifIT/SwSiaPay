<?php
require("utils/mac/MacCalculator.php");
require("utils/mac/AlgorithmEnum.php");
require("utils/HTMLGenerator.php");
require("utils/encryption/AESEncoder.php");
require("utils/Utils.php");
require("utils/apos/RestClient.php");
require("client/VPOSClient.php");



$macCalculator = new MacCalculator(AlgorithmEnum::SHA_256);
$htmlGenerator = new HTMLGenerator();

//echo($macCalculator->calculate("URLMS=https://te.t-frutta.eu/TImooneyWS/app_api/v10/payment/cardData?consumerId=3b350c34-d923-4552-91bf-67bc4f99da92&URLDONE=http://localhost:8080/payment-gateway/vpos/tokenize&ORDERID=s564c564c6as54as654c65as4&SHOPID=129281292800104&AMOUNT=10&CURRENCY=978&ACCOUNTINGMODE=D&AUTHORMODE=I&OPTIONS=GM", "CNCuDT5Vyws2v9t--RhDdtCwstaV2tqVeqfE-D8G-S-Ds--C-fFkSBxw-3wWBqBC--U9hwN-H-Mj4ZZHMr--YSHLdU5WKLx-cT-T"));
//echo($htmlGenerator->generateParamsHtml(array("ORDERID" => "45646", "OPERATORID" => "mkdsm")));
//echo ($htmlGenerator->base64ToHtml("PGh0bWw+PGJvZHk+PC9ib2R5PjwvaHRtbD4K", 500));
//echo $htmlGenerator->htmlToBase64("null", array("ORDERID"=>"12345678"));
//echo AESEncoder::encrypt("aaaaaaaaaaaaaaaa", "ciao");
//echo Utils::generateRandomDigits();
//echo $macCalculator->calculate("OPERATION=AUTHORIZATION3DSSTEP1&TIMESTAMP=2020-01-27T15:01:56.000&SHOPID=129281292800109&ORDERID=413999151994&OPERATORID=operator&REQREFNUM=20200127471727070197783123084621&PAN=0000409500729966732&CVV2=111&EXPDATE=2112&AMOUNT=2000&CURRENCY=978&ACCOUNTINGMODE=D&NETWORK=98", "E-vmE-GHXmx73-Lfg24LztZ-7-yCyVsKn4QXphL5qzf-Kr-Cf-JWpZwZgaZRA5dR9V677xL4uCbc-Ce--8h2-tdrSu--QKjF-nZh");

$restClient = new RestClient();
testGetXMLAuth3DS();

$dataJson = new Data3DSJson();
$dataJson->setAcctID("fdsfkjds");
$dataJson->setAddrMatch("sfdsad");

//echo $dataJson->__toString();
////testGetXMLAuth3DSStep2();


function testGetXMLAuth3DS():void{
    $auth3DS = new Auth3DSDto();
    $vposClient = new VPOSClient("E-vmE-GHXmx73-Lfg24LztZ-7-yCyVsKn4QXphL5qzf-Kr-Cf-JWpZwZgaZRA5dR9V677xL4uCbc-Ce--8h2-tdrSu--QKjF-nZh", "https://atpostest.ssb.it/atpos/apibo/apiBOXML.app");

    $auth3DS->setIsMasterpass(false);
    $auth3DS->setShopId("129281292800109");
    $auth3DS->setOperatorId("operator");

//    $auth3DS->setService("service");
//    $auth3DS->setEci("eci");
//    $auth3DS->setXId("xid");
//    $auth3DS->setCavv("cavv");
//    $auth3DS->setParesStatus("paresStatus");
//    $auth3DS->setScenRollStatus("scEnrollStatus");
//    $auth3DS->setSignatureVerification("signatureVerifytion");
//    $auth3DS->setPpAuthenticateMethod("ppAuthenticationMode");
//    $auth3DS->setCardEnrollMethod("ppACardEnrollMethod");
    $auth3DS->setOrderId(substr(Utils::generateRandomDigits(), 0, 12));
    $auth3DS->setPan("0000409500729966732");
    $auth3DS->setCvv2("111");
    $auth3DS->setExpDate("2112");
    $auth3DS->setAmount("2000");
    $auth3DS->setCurrency("978");
//    $auth3DS->setExponent("exponent");
    $auth3DS->setAccountingMode("D");
    $auth3DS->setNetwork("98");
//   $auth3DS->setEmailCh("email@libero.it");
//    $auth3DS->setUserId("userId");
//    $auth3DS->setProductRef("productRef");
//    $auth3DS->setName("name");
//    $auth3DS->setSurname("surname");

    $vposClient->startAuth3DS($auth3DS);
}
//
//function testGetXMLAuth3DSStep2():void{
//    $auth3DS = new Auth3DSStep2RequestDto();
//    $auth3DS->setShopId("12345678");
//    $auth3DS->setOperatorId("operator");
//    $auth3DS->setOriginalRefReqNum("dgbsdhgfiudf");
//    $auth3DS->setPaRes("Ssdfljlkj45098asdkgr09adsflkj9v26sfaheu73tags52gq7asgdhsdhvadghasags");
////    $auth3DS->setAcquirer("acuqirer");
//
//    echo $auth3DS->getXML();
//}