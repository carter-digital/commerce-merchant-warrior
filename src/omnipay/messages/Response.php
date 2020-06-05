<?php

namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;

        if (empty($data)) {
            throw new InvalidResponseException();
        }

        $data = (array) $data;
        $this->data = $data;
    }

    // Public Methods
    // =========================================================================

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return (string) $this->data['transactionID'];
    }

    /**
     * @return string
     */
    public function getReceiptNo()
    {
        return (string) $this->data['receiptNo'];
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return (string) $this->data['authResponseCode'];
    }

    /**
     * @return string
     */
    public function getAuthCode()
    {
        return (string) $this->data['authCode'];
    }

    /**
     * @return string
     */
    public function getAuthSettledDate()
    {
        return (string) $this->data['authSettledDate'];
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return (string) $this->data['responseMessage'];
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return ((int)$this->data['responseCode'] === 0) ? true : false;
    }
}