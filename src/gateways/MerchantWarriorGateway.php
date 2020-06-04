<?php

namespace carterdigital\commerce\merchantwarrior\gateways;

use yii\base\NotSupportedException;

use Craft;
use craft\web\Response as WebResponse;

use craft\commerce\base\Gateway;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\PaymentSource;
use craft\commerce\models\Transaction;
use craft\commerce\models\payments\BasePaymentForm;

use carterdigital\commerce\merchantwarrior\requests\PaymentRequest;

class MerchantWarriorGateway extends Gateway {
    
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    public $uuid;

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

    // Public methods
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

    /**
     * @inheritdoc
     */
    public function supportsAuthorize(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function authorize(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Authorization is not supported by this gateway'));
    }

    /**
     * @inheritdoc
     */
    public function supportsCapture(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function capture(Transaction $transaction, string $reference): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Capture is not supported by this gateway'));
    }

    /**
     * @inheritdoc
     */
    public function supportsCompleteAuthorize(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function completeAuthorize(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Complete Authorize is not supported by this gateway'));
    }

    /**
     * @inheritdoc
     */
    public function supportsCompletePurchase(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function completePurchase(Transaction $transaction): RequestResponseInterface
    {
        $orderTotal = (float)$transaction->getOrder()->totalPrice;
        $transactionTotal = (float)$transaction->paymentAmount;
    }

    /**
     * @inheritdoc
     */
    public function supportsPaymentSources(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function createPaymentSource(BasePaymentForm $sourceData, int $userId): PaymentSource
    {
        throw new NotSupportedException(Craft::t('commerce', 'Payment sources are not supported by this gateway'));
    }

    /**
     * @inheritdoc
     */
    public function supportsPurchase(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function purchase(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        /** @var Order $order */
        $order = $transaction->getOrder();

        $purchaseRequest = new PaymentRequest();
        $purchaseRequest->method = 'processCard';
        $purchaseRequest->merchantUUID = $this->uuid;
        $purchaseRequest->apiKey = $this->apiKey;
        $purchaseRequest->transactionAmount = (float) $order->totalPrice;
        $purchaseRequest->transactionCurrency = $order->currency;
        $purchaseRequest->transactionProduct = 'KHA' . $order->uid;
        $purchaseRequest->customerName = $order->billingAddress->firstName . ' ' . $order->billingAddress->lastName;
        $purchaseRequest->customerCountry = $order->billingAddress->country->iso;
        $purchaseRequest->customerState = $order->billingAddress->stateValue;
        $purchaseRequest->customerCity = $order->billingAddress->city;
        $purchaseRequest->customerAddress = $order->billingAddress->address1;
        $purchaseRequest->customerPostCode = $order->billingAddress->zipCode;
        $purchaseRequest->customerPhone = $order->billingAddress->phone;
        $purchaseRequest->customerEmail = $order->email;
        $purchaseRequest->customerIP = $order->billingAddress->custom1;
        $purchaseRequest->paymentCardName = 'Test Customer';
        $purchaseRequest->paymentCardNumber = '5123456789012346';
        $purchaseRequest->paymentCardExpiry = '0521';
        $purchaseRequest->paymentCardCSC = '123';
        $purchaseRequest->hash = $this->getTransactionHash();
    }

    /**
     * @inheritdoc
     */
    public function supportsRefund(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsPartialRefund(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function refund(BasePaymentForm $sourceData, int $userId): PaymentSource
    {
        throw new NotSupportedException(Craft::t('commerce', 'Payment sources are not supported by this gateway'));
    }

    /**
     * @inheritdoc
     */
    public function supportsWebhooks(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function processWebHook(): WebResponse
    {
        throw new NotSupportedException(Craft::t('commerce', 'Webhooks are not supported by this gateway'));
    }
}