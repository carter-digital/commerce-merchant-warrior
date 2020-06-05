<?php

namespace carterdigital\commerce\merchantwarrior\omnipay\messages;

abstract class AbstractPaymentRequest extends AbstractRequest
{
    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function getTransactionProduct()
    {
        return $this->getParameter('transactionProduct');
    }

    /**
     * @param string $value
     */
    public function setTransactionProduct($value)
    {
        $this->setParameter('transactionProduct', $value);
    }

    /**
     * @return string
     */
    public function getCustomerIP()
    {
        return $this->getParameter('customerIP');
    }

    /**
     * @param string $value
     */
    public function setCustomerIP($value)
    {
        $this->setParameter('customerIP', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->setTransactionProduct($this->getDescription());
        $this->setCustomerIP($this->getParameter('clientIp'));

        $this->validate();

        $data = [
            'method' => $this->method,
            'merchantUUID' => $this->getMerchantUUID(),
            'apiKey' => $this->getApiKey(),
            'transactionAmount' => $this->getAmount(),
            'transactionCurrency' => (is_null($this->getCurrency()))? 'AUD' : $this->getCurrency(),
            'transactionProduct' => $this->getTransactionProduct(),
            'transactionReferenceID' => $this->getTransactionReference(),
            'customerIP' => $this->getCustomerIP(),
            'customerName' => $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName(),
            'storeID' => $this->getStoreID(),
            'custom1' => $this->getCustom1(),
            'custom2' => $this->getCustom2(),
            'custom3' => $this->getCustom3(),
            'hash' => $this->getTransactionHash()
        ];

        return array_merge($data, $this->getCardData());
    }
}