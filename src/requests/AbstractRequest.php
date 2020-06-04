<?php

namespace carterdigital\commerce\merchantwarrior\requests;

use GuzzleHttp\Client;

abstract class AbstractRequest
{
    /*
     * Merchant Warrior API URLs
     */
    protected $inTestMode = true;

    /*
     * Merchant Warrior API URLs
     */
    protected $testUrl = 'https://base.merchantwarrior.com/post/';
    protected $liveUrl = 'https://api.merchantwarrior.com/post/';

    /*
     * The API method for the request
     */
    protected $method = '';

    /*
     * Request credentials
     */
    protected $merchantUUID = '';
    protected $apiKey = '';
    protected $apiPassphrase = '';

    /*
     * Transaction details
     */
    protected $transactionCurrency = 'AUD';
    protected $transactionAmount = '0.00';

    /*
     * Custom parameters
     */
    protected $custom1 = '';
    protected $custom2 = '';
    protected $custom3 = '';

    /*
     * Other parameters
     */
    protected $storeID = '';

    /**
     * Determine the transaction environment and returns API URL
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->inTestMode ? $this->testUrl : $this->liveUrl;
    }
    
    /**
     * The verification hash is a combination of the MD5 of your API Passphrase, and specific parameters sent in the transaction.
     * 
     * @return string
     */
    public function getTransactionHash()
    {
        $hash = md5(strtolower(md5($this->apiPassphrase) . $this->merchantUuid . $this->amount . $this->currency));

        return $hash;
    }
    
    /**
     * Send request using Guzzle
     * 
     * @return array
     */
    public function sendData($data)
    {
        $client = new Client();
        $response = $client->request('POST', $this->getUrl(), [
            'http_errors' => false,
            'allow_redirects' => [
                'max' => 5,
                'strict' => true,
                'protocols' => ['http', 'https'],
            ],
            'form_params' => $data,
        ]);

        $content = (string) $response->getBody();
        $xml = simplexml_load_string($content);

        return (array) $xml;
    }
}