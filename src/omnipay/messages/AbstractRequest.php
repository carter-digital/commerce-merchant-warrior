<?php
namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

use GuzzleHttp\Client;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    protected $method = '';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.merchantwarrior.com/post/';

    /**
     * @var string
     */
    protected $testEndPoint = 'https://base.merchantwarrior.com/post/';

    // Public Methods
    // =========================================================================

    /**
     * @return string
     */
    public function getMerchantUUID()
    {
        return $this->getParameter('merchantUUID');
    }

    /**
     * @param string $value
     */
    public function setMerchantUUID($value)
    {
        $this->setParameter('merchantUUID', $value);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Example: 1a3b5c
     * Notes: The value of this parameter is assigned to you by Merchant Warrior
     * 
     * @param string $value
     */
    public function setApiKey($value)
    {
        $this->setParameter('apiKey', $value);
    }

    /**
     * @return string
     */
    public function getApiPassphrase()
    {
        return $this->getParameter('apiPassphrase');
    }

    /**
     * @param string $value
     */
    public function setApiPassphrase($value)
    {
        $this->setParameter('apiPassphrase', $value);
    }

    /**
     * Example: e9ddc296b76b3398934bfc06239073df
     * Notes: The verification hash is a combination of the MD5 of your API Passphrase
     * and specific parameters sent in the transaction.
     * 
     * @return string
     */
    public function getTransactionHash()
    {
        $currency = (is_null($this->getCurrency()))? 'AUD' : $this->getCurrency();
        $hash = md5(strtolower(md5($this->getApiPassphrase()) . $this->getMerchantUUID() . $this->getAmount() . $currency));

        return $hash;
    }

    /**
     * @return string
     */
    public function getCustom1()
    {
        return $this->getParameter('custom1');
    }

    /**
     * @param string $value
     */
    public function setCustom1($value)
    {
        $this->setParameter('custom1', $value);
    }

    /**
     * @return string
     */
    public function getCustom2()
    {
        return $this->getParameter('custom2');
    }

    /**
     * @param string $value
     */
    public function setCustom2($value)
    {
        $this->setParameter('custom2', $value);
    }

    /**
     * @return string
     */
    public function getCustom3()
    {
        return $this->getParameter('custom3');
    }

    /**
     * @param string $value
     */
    public function setCustom3($value)
    {
        $this->setParameter('custom3', $value);
    }

    /**
     * Gets the respective MW API endpoint
     * 
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? $this->testEndPoint : $this->liveEndpoint;
    }

    /**
     * @return string
     */
    public function getStoreID()
    {
        return $this->getParameter('storeID');
    }

    /**
     * @param string $value
     */
    public function setStoreID($value)
    {
        $this->setParameter('storeID', $value);
    }

    /**
     * @param array $data
     * @return Response
     */
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

    /**
     * @return array
     */
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