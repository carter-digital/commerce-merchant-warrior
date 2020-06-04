<?php
namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

use Omnipay\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CaptureRequest extends AbstractRequest
{
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);

        $this->method = 'processCapture';
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionID');
    }

    public function setTransactionID($value)
    {
        $this->setParameter('transactionID', $value);
    }


    public function getData()
    {
        $this->validate();

        $data = [
            'method' => $this->method,
            'merchantUUID' => $this->getMerchantUUID(),
            'apiKey' => $this->getApiKey(),
            'transactionAmount' => $this->getAmount(),
            'transactionCurrency' => (is_null($this->getCurrency()))? 'AUD' : $this->getCurrency(),
            'transactionReferenceID' => $this->getTransactionReference(),
            'captureAmount' => $this->getAmount(),
            'transactionID' => $this->getTransactionId(),
            'hash' => $this->getTransactionHash()
        ];

        return $data;
    }
}