<?php

namespace carterdigital\commerce\merchantwarrior\gateways;

use Craft;
use craft\commerce\omnipay\base\CreditCardGateway;

use Omnipay\Common\AbstractGateway;

use carterdigital\commerce\merchantwarrior\omnipay\Gateway as OmnipayGateway;

class Gateway extends CreditCardGateway
{   
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $merchantUUID;

    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $apiPassphrase;

    /**
     * @var string
     */
    public $testMode;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'Merchant Warrior');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml() 
    {
        return Craft::$app->getView()->renderTemplate('commerce-merchant-warrior/gatewaySettings.twig', ['gateway' => $this]);
    }
    
    /**
     * @inheritdoc
     */
   public function getPaymentTypeOptions(): array
   {
       return [
           'purchase' => Craft::t('commerce', 'Purchase (Authorize and Capture Immediately)'),
       ];
   }

   // Protected Methods
   // =========================================================================

   /**
   * @inheritdoc
   */
   protected function createGateway(): AbstractGateway
   {
       /** @var Gateway $gateway */
       $gateway = static::createOmnipayGateway($this->getGatewayClassName());

       $gateway->setMerchantUUID($this->merchantUUID);
       $gateway->setApiKey($this->apiKey);
       $gateway->setApiPassphrase($this->apiPassphrase);
       $gateway->setTestMode($this->testMode);

       return $gateway;
   }

   /**
   * @inheritdoc
   */
   protected function getGatewayClassName()
   {
       return '\\' . OmnipayGateway::class;
   }
}