<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Srmklive\PayPal\Services\PayPal;

class paypal_service extends Base_Payment_Service implements PaymentGatewayInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPal;
        $this->provider->setApiCredentials(config('payment.paypal'));
        $this->provider->getAccessToken();
    }

    public function createPayment($paymentAmount, $returnUrl = null)
    {
        $url = $returnUrl ?? route('payment.capture', ['payment_data' => 'paypal', 'amount' => $paymentAmount]);

        $response = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => $url,
                'cancel_url' => route('deposit', ['payment_Data' => 'paypal', 'amount' => $paymentAmount]),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $paymentAmount,
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return [
                        'success' => true,
                        'url' => $link['href'],
                    ];
                }
            }
        }

        return ['success' => false];
    }

    public function capturePayment($request)
    {
        $result = $this->provider->capturePaymentOrder($request->token);

        if (isset($result['status']) && $result['status'] == 'COMPLETED') {
            return [
                'status' => 'COMPLETED',
                'id' => $result['id'],
                'amount' => $result['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'currency' => $result['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
            ];
        }

        return ['status' => 'FAILED'];
    }
}
