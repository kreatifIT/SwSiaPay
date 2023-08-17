<?php


/**
 * Class RestClient
 *
 * Simple REST client used in the context of MERCHANT --> VPOS communication
 *
 * @author Gabriel Raul Marini
 */
class RestClient
{
    private const CONTENT_TYPE = "application/x-www-form-urlencoded";
    private const POST_METHOD = "POST";
    private const PUT_METHOD = "PUT";

    private bool $basicAuth;
    private bool $proxy;

    private int $proxyPort;
    private string $proxyName;
    private string $proxyUser;
    private string $proxyPPP;
    private string $basicAuthUser;
    private string $basicAuthPPP;


    public function __construct()
    {
        $this->basicAuth = false;
        $this->proxy = false;
    }

    /**
     * Performs a generic call in POST|PUT
     *
     * @param string $url of the endpoint
     * @param string body of the request
     * @return bool|string outcome of the performed call | response's body
     */
    public function callAPI(string $url, string $xmlData)
    {
        $method = self::POST_METHOD;
        //echo $xmlData;
        $data = "data=" . $xmlData;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT_METHOD);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: ' . static::CONTENT_TYPE
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->setCurlOptions($curl);

        // EXECUTE:
        $result = curl_exec($curl);
       // echo "Response from VPOS is: \n" . $result;
        if (!$result) {
            echo curl_error($curl);
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

    private function setCurlOptions($curl)
    {
        if ($this->proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $this->proxyName . ":" . $this->proxyPort);
            if (isset($this->proxyUser) && isset($this->proxyPPP))
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, trim($this->proxyUser) . ":" . trim($this->proxyPPP));
        }
        if ($this->basicAuth) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, trim($this->basicAuthUser) . ":" . trim($this->basicAuthPPP));
        }
    }

    public function setBasicAuth(string $user, string $password)
    {
        $this->basicAuth = true;
        $this->basicAuthUser = $user;
        $this->basicAuthPPP = $password;
    }

    public function setProxy(string $proxyName, int $proxyPort)
    {
        $this->proxy = true;
        $this->proxyName = $proxyName;
        $this->proxyPort = $proxyPort;
    }

    public function setProxyWithAuth(string $proxyName, int $proxyPort, string $proxyUser, string $proxyPw)
    {
        $this->proxy = true;
        $this->proxyName = $proxyName;
        $this->proxyPort = $proxyPort;
        $this->proxyUser = $proxyUser;
        $this->proxyPPP = $proxyPw;
    }

    public function disableProxy()
    {
        $this->proxy = false;
    }

    public function disableBasicAuth()
    {
        $this->basicAuth = false;
    }

}
