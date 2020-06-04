<?php

namespace carterdigital\commerce\merchantwarrior\requests;

abstract class AbstractPaymentRequest extends AbstractRequest
{
    /*
     * General payment transaction specific parameters
     */
    protected $transactionProduct = '';
    protected $transactionReferenceID = '';

    /*
     * Customer data
     */
    protected $customerName = '';
    protected $customerCountry = '';
    protected $customerState = '';
    protected $customerCity = '';
    protected $customerAddress = '';
    protected $customerPostCode = '';
    protected $customerPhone = '';
    protected $customerEmail = '';

    /*
     * Payment data
     */
    protected $paymentCardNumber = '';
    protected $paymentCardExpiry = '';
    protected $paymentCardName = '';
    protected $paymentCardCSC = '';

    /*
     * Form the request's data object
     */
    public function getData()
    {
        return [
            'method' => $this->method,
            'merchantUUID' => $this->merchantUUID,
            'apiKey' => $this->apiKey,
            'transactionAmount' => $this->transactionAmount,
            'transactionCurrency' => $this->transactionCurrency,
            'transactionProduct' => $this->transactionProduct,
            'customerName' => $this->customerName,
            'customerCountry' => $this->customerCountry,
            'customerState' => $this->customerState,
            'customerCity' => $this->customerCity,
            'customerAddress' => $this->customerAddress,
            'customerPostCode' => $this->customerPostCode,
            'customerPhone' => $this->customerPhone,
            'customerEmail' => $this->customerEmail,
            'paymentCardNumber' => $this->paymentCardNumber,
            'paymentCardExpiry' => $this->paymentCardExpiry,
            'paymentCardName' => $this->paymentCardName,
            'paymentCardCSC' => $this->paymentCardCSC,
            'storeID' => $this->storeID,
            'custom1' => $this->custom1,
            'custom2' => $this->custom2,
            'custom3' => $this->custom3,
            'hash' => $this->getTransactionHash(),
            'transactionReferenceID' => $this->transactionReferenceID,
        ];
    }
}