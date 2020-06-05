<?php

namespace carterdigital\commerce\merchantwarrior\omnipay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public function getName()
    {
        return 'Merchant Warrior';
    }

    /**
     * @var array
     */
    public function getDefaultParameters()
    {
        return [
            'merchantUUID' => '',
            'ApiKey' => '',
            'ApiPassphrase' => ''
        ];
    }

    /**
     * @var string
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
     * @var string
     */
    public function getApiKey()
    {
        return $this->getParameter('Apikey');
    }

    /**
     * @param string $value
     */
    public function setApiKey($value)
    {
        $this->setParameter('Apikey', $value);
    }

    /**
     * @var string
     */
    public function getApiPassphrase()
    {
        $this->getParameter('ApiPassphrase');
    }

    /**
     * @param string $value
     */
    public function setApiPassphrase($value)
    {
        $this->setParameter('ApiPassphrase', $value);
    }

    /**
     * Authorize an amount on the customers card
     * 
     * @param array $parameters
     * @return null
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(
            '\carterdigital\commerce\merchantwarrior\omnipay\messages\AuthorizeRequest',
            $parameters
        );
    }

    /**
     * Capture an amount you have previously authorized
     * 
     * @param array $parameters
     * @return null
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(
            '\carterdigital\commerce\merchantwarrior\omnipay\messages\CaptureRequest',
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
            '\carterdigital\commerce\merchantwarrior\omnipay\messages\PurchaseRequest',
            $parameters
        );
    }
}