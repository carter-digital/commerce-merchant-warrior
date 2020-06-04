<?php

namespace carterdigital\commerce\merchantwarrior\omnipay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Merchant Warrior';
    }

    public function getDefaultParameters()
    {
        return [
            'MerchantUUID' => '',
            'ApiKey' => '',
            'ApiPassphrase' => ''
        ];
    }

    public function getMerchantUUID()
    {
        return $this->getParameter('MerchantUUID');
    }

    public function setMerchantUUID($value)
    {
        $this->setParameter('MerchantUUID', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('Apikey');
    }

    public function setApiKey($value)
    {
        $this->setParameter('Apikey', $value);
    }

    public function getApiPassphrase()
    {
        $this->getParameter('ApiPassphrase');
    }

    public function setApiPassphrase($value)
    {
        $this->setParameter('ApiPassphrase', $value);
    }

    /**
     * Authorize an amount on the customers card
     * @param array $parameters
     * @return null
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(
            '\Omnipay\MerchantWarrior\Message\AuthorizeRequest',
            $parameters
        );
    }

    /**
     * Capture an amount you have previously authorized
     * @param array $parameters
     * @return null
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(
            '\Omnipay\MerchantWarrior\Message\CaptureRequest',
            $parameters
        );
    }

    /**
     * Authorize and immediately capture an amount on the customers card
     * @param array $parameters
     * @return null
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(
            '\Omnipay\MerchantWarrior\Message\PurchaseRequest',
            $parameters
        );
    }
}