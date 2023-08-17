<?php


class ClientConfig
{
    public string $shopID;
    public string $startKey;
    public string $apiKey;
    public string $redirectUrl;
    public string $urlWebApi;

    /**
     * VPOSClient constructor.
     * @param string $startKey
     * @param string $apiKey
     * @param string $urlWebApi
     * @param string $shopID
     * @param string $redirectUrl
     */
    
    public function __construct(string $shopID, string $startKey, string $apiKey, string $urlWebApi, string $redirectUrl){
        $this->shopID = $shopID;
        $this->apiKey = $apiKey;
        $this->redirectUrl = $redirectUrl;
        $this->urlWebApi = $urlWebApi;
        $this->startKey = $startKey;
    }

}