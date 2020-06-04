<?php
namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

use GuzzleHttp\Client;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    /*
     * The API method for the request
     */
    protected $method = '';

    /*
     * Merchant Warrior API endpoints
     */
    protected $liveEndpoint = 'https://api.merchantwarrior.com/post/';
    protected $testEndPoint = 'https://base.merchantwarrior.com/post/';


    /**
     * This is your Merhcant ID assigned to you by merchant Warrior
     * @return string
     */
    public function getMerchantUUID()
    {
        return $this->getParameter('merchantUUID');
    }

    /**
     * Sets your MerchantUUID
     * @param string $value
     */
    public function setMerchantUUID($value)
    {
        $this->setParameter('merchantUUID', $value);
    }

    /**
     *  Example: 1a3b5c
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function getApiPassphrase()
    {
        return $this->getParameter('apiPassphrase');
    }

    public function setApiPassphrase($value)
    {
        $this->setParameter('apiPassphrase', $value);
    }

    /**
     *  Example: 1a3b5c
     *  Notes: The value of this parameter is assigned to you by Merchant Warrior
     * @param string $value
     */
    public function setApiKey($value)
    {
        $this->setParameter('apiKey', $value);
    }

    /**
     * Example: e9ddc296b76b3398934bfc06239073df
     * Notes: The verification hash is a combination of the MD5 of your API Passphrase
     * and specific parameters sent in the transaction.
     * @return string
     */
    public function getTransactionHash()
    {
        $currency = (is_null($this->getCurrency()))? 'AUD' : $this->getCurrency();
        $hash = md5(strtolower(md5($this->getApiPassphrase()) . $this->getMerchantUUID() . $this->getAmount() . $currency));
        return $hash;
    }

    public function getCustom1()
    {
        return $this->getParameter('custom1');
    }

    public function setCustom1($value)
    {
        $this->setParameter('custom1', $value);
    }

    public function getCustom2()
    {
        return $this->getParameter('custom2');
    }

    public function setCustom2($value)
    {
        $this->setParameter('custom2', $value);
    }

    public function getCustom3()
    {
        return $this->getParameter('custom3');
    }

    public function setCustom3($value)
    {
        $this->setParameter('custom3', $value);
    }

    /**
     * Gets the respective MW API endpoint
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? $this->testEndPoint : $this->liveEndpoint;
    }

    public function getStoreID(){
        return $this->getParameter('storeID');
    }

    public function setStoreID($value)
    {
        $this->setParameter('storeID', $value);
    }

    public function sendData($data)
    {
        $client = new Client();

        $response = $client->request('POST', $this->getEndPoint(), [
            'http_errors' => false,
            'allow_redirects' => [
                'max'   => 5,
                'strict' => true,
                'protocols' => ['http', 'https']
            ],
            'form_params' => $data
        ]);

        $content = (string) $response->getBody();
        $xml = simplexml_load_string($content);
        $this->response = new Response($this, $xml);

        return $this->response;
    }

    protected function getCardData()
    {
        $card = $this->getCard();

        $card->validate();

        $data = [
            'customerName' => $card->getName(),
            'customerCountry' => $card->getCountry(),
            'customerState' => $card->getState(),
            'customerCity' => $card->getCity(),
            'customerAddress' => $card->getAddress1(),
            'customerPostCode' => $card->getPostcode(),
            'paymentCardNumber' => $card->getNumber(),
            'paymentCardExpiry' => $card->getExpiryDate('my'),
            'paymentCardName' => $card->getName(),            
            'customerPhone' => $card->getPhone(),
            'customerEmail' => $card->getEmail(),
            'paymentCardCSC' => $card->getCvv()
        ];

        return $data;
    }
}