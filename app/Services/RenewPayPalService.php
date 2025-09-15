<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class RenewPayPalService
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
                "return_url" => route('renew.success'),
                "cancel_url" => route('renew.cancel'),
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
}
