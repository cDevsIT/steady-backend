<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $paypal;

    public function __construct()
    {
        $this->paypal = new PayPalClient;
        $this->paypal->setApiCredentials(config('paypal'));
        $this->paypal->getAccessToken();
    }

    public function createPayment($amount)
    {
        $response =  $this->paypal->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $this->getApiUrl() . '/payments/paypal/success',
                "cancel_url" => $this->getApiUrl() . '/payments/paypal/cancel',
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount,
                    ],
                ],
            ],
        ]);

        return $response;
    }

    public function capturePayment($orderId)
    {
        $response = $this->paypal->capturePaymentOrder($orderId);

        return $response;
    }

    /**
     * Get frontend URL based on environment
     */
    private function getFrontendUrl()
    {
        return env('FRONTEND_URL', 'http://localhost:3000');
    }

    /**
     * Get API URL based on environment
     */
    private function getApiUrl()
    {
        return env('APP_URL', 'http://localhost:8000') . '/api';
    }
}
