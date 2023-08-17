<?php
require_once(__DIR__ . "/../../utils/xml/XMLUtils.php");
require_once(__DIR__ . "/../../utils/Utils.php");


/**
 * Class Request
 *
 * Model of a generic VPOS request
 *
 * @author Gabriel Raul Marini
 */
abstract class Request
{
    private const DATE_FORMAT = "Y-m-d\TH:i:s.v";
    private const REQ_REF_NUM_DATE_FORMAT = "Ymd";

    //fixed XML requests' values
    private const RELEASE = "02";

    //XML std tags' placeholders
    protected const OPERATION_TAG_VALUE = "[OPERATION]";
    public const MAC_TAG_VALUE = "[MAC]";
    protected const VARIABLE_REQUEST_TAG = "[REQUEST_TAG]";

    //XML tags names
    protected const OPEN_TAG = "BPWXmlRequest";
    protected const RELEASE_TAG = "Release";
    protected const REQUEST_TAG = "Request";
    protected const OPERATION_TAG = "Operation";
    protected const TIMESTAMP_TAG = "Timestamp";
    protected const MAC_TAG = "MAC";
    protected const DATA_TAG = "Data";
    protected const HEADER_TAG = "Header";
    protected const SHOP_ID_TAG = "ShopID";
    protected const OPERATOR_ID_TAG = "OperatorID";
    protected const REQ_REF_NUM_TAG = "ReqRefNum";
    protected const DATA_3DS_TAG = "Data3DS";
    protected const SERVICE_TAG = "Service";
    protected const ECI_TAG = "Eci";
    protected const XID_TAG = "Xid";
    protected const CAVV_TAG = "CAVV";
    protected const PARES_STATUS_TAG = "ParesStatus";
    protected const SC_ENROLL_STATUS_TAG = "ScEnrollStatus";
    protected const SIGNATURE_VERIFYTION_TAG = "SignatureVerifytion";
    protected const MASTERPASS_DATA_TAG = "MasterpassData";
    protected const PP_AUTHENTICATE_METHOD_TAG = "PP_AuthenticateMethod";
    protected const PP_CARD_ENROLL_METHOD_TAG = "PP_CardEnrollMethod";
    protected const ORDER_ID_TAG = "OrderId";
    protected const PAN_TAG = "Pan";
    protected const CVV2_TAG = "CVV2";
    protected const EXPDATE_TAG = "ExpDate";
    protected const AMOUNT_TAG = "Amount";
    protected const CURRENCY_TAG = "Currency";
    protected const EXPONENT_TAG = "Exponent";
    protected const ACCOUNTING_MODE_TAG = "AccountingMode";
    protected const NETWORK_TAG = "Network";
    protected const EMAIL_CH_TAG = "EmailCH";
    protected const USER_ID_TAG = "Userid";
    protected const PRODUCT_REF_TAG = "ProductRef";
    protected const NAME_TAG = "Name";
    protected const SURNAME_TAG = "Surname";
    protected const ORIGINAL_REQ_REF__NUM_TAG = "OriginalReqRefNum";
    protected const PARES_TAG = "PaRes";
    protected const ACQUIRER_TAG = "Acquirer";
    protected const PRODUCTREF_TAG = "ProductRef";
    protected const TRANSACTION_ID_TAG = "TransactionID";
    protected const OPDESCR_TAG = "OpDescr";
    protected const OPTIONS_TAG = "Options";
    protected const TAX_ID_TAG = "TaxID";
    protected const IN_PERSON_TAG = "InPerson";
    protected const MERCHANT_URL_TAG = "MerchantURL";
    protected const START_DATE_TAG = "StartDate";
    protected const END_DATE_TAG = "EndDate";
    protected const START_TIME_TAG = "StartTime";
    protected const END_TIME_TAG = "EndTime";
    protected const FILTER_TAG = "Filter";
    protected const CREATE_PAN_ALIAS_TAG = "CreatePanAlias";
    protected const NAME_CH_TAG = "NameCH";
    protected const IP_ADDRESS_TAG = "IpAddress";
    protected const USR_AUTH_FLAG_TAG = "UsrAuthFlag";
    protected const ANTIFRAUD_TAG = "Antifraud";
    protected const THREEDS_DATA_TAG = "ThreeDSData";
    protected const NOTIF_URL_TAG = "NotifUrl";
    protected const CHALLENGE_WIN_SIZE_TAG = "ChallengeWinsize";
    protected const CPROF_TAG = "CPROF";
    protected const THREEDS_MTD_NOTIF_URL = "ThreeDSMtdNotifUrl";
    protected const THREEDS_MTD_COMPL_IND_TAG = "ThreeDsMtdComplInd";
    protected const THREEDS_TRANS_ID_TAG = "ThreeDsTransID";
    protected const T_RECURR_TAG = "TRecurr";
    protected const C_RECURR_TAG = "CRecurr";
    protected const INSTALLMENTS_NUMBER_TAG = "InstallmentsNumber";



    //request's std attributes
    protected string $shopId;
    protected string $operatorId;
    protected string $reqRefNum;
    protected string $timestamp;
    protected ?string $options = null;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $time = time();
        $this->timestamp = date(self::DATE_FORMAT, $time);
        $this->reqRefNum = date(self::REQ_REF_NUM_DATE_FORMAT, $time);
        $this->reqRefNum .= Utils::generateRandomDigits();
    }

    /**
     * @param string $shopId
     */
    public function setShopId(string $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * @param string $operatorId
     */
    public function setOperatorId(string $operatorId): void
    {
        $this->operatorId = $operatorId;
    }

    /**
     * @param string $options
     */
    public function setOptions(string $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string std format of BPWXMLRequest initial part
     */
    protected function getXMLOpening(): string
    {
        $xml = "";
        XMLUtils::appendOpenTag($xml, self::OPEN_TAG);
        XMLUtils::appendTag($xml, self::RELEASE_TAG, self::RELEASE);

        XMLUtils::appendOpenTag($xml, self::REQUEST_TAG);
        XMLUtils::appendTag($xml, self::OPERATION_TAG, self::OPERATION_TAG_VALUE);
        XMLUtils::appendTag($xml, self::TIMESTAMP_TAG, $this->timestamp);
        XMLUtils::appendTag($xml, self::MAC_TAG, self::MAC_TAG_VALUE);
        XMLUtils::appendCloseTag($xml, self::REQUEST_TAG);

        XMLUtils::appendOpenTag($xml, self::DATA_TAG);
        XMLUtils::appendOpenTag($xml, self::VARIABLE_REQUEST_TAG);
        XMLUtils::appendOpenTag($xml, self::HEADER_TAG);
        XMLUtils::appendTag($xml, self::SHOP_ID_TAG, $this->shopId);
        XMLUtils::appendTag($xml, self::OPERATOR_ID_TAG, $this->operatorId);
        XMLUtils::appendTag($xml, self::REQ_REF_NUM_TAG, $this->reqRefNum);
        XMLUtils::appendCloseTag($xml, self::HEADER_TAG);

        return $xml;
    }

    /**
     * @return string closing a generic BPWXMLRequest
     */
    protected function getXMLClosing(): string
    {
        $xml = "";
        XMLUtils::appendCloseTag($xml, self::VARIABLE_REQUEST_TAG);
        XMLUtils::appendCloseTag($xml, self::DATA_TAG);
        XMLUtils::appendCloseTag($xml, self::OPEN_TAG);
        return $xml;
    }


    /**
     * @return string XML representation of the models instance
     */
    public abstract function getXML(): string;

    /**
     * @return array associative array filled with all the request fields used to
     * calculate the MAC message
     */
    public abstract function getMacArray(): array;
}
