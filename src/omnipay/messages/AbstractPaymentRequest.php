<?php

namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

abstract class AbstractPaymentRequest extends AbstractRequest
{
    /**
     * @return mixed
     */
    public function getTransactionProduct()
    {
        return $this->getParameter('transactionProduct');
    }

    /**
     * @param $value
     */
    public function setTransactionProduct($value)
    {
        $this->setParameter('transactionProduct', $value);
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
            'transactionProduct' => $this->getTransactionProduct(),
            'transactionReferenceID' => $this->getTransactionReference(),
            'storeID' => $this->getStoreID(),
            'custom1' => $this->getCustom1(),
            'custom2' => $this->getCustom2(),
            'custom3' => $this->getCustom3(),
            'hash' => $this->getTransactionHash()
        ];

        return array_merge($data, $this->getCardData());
    }
}