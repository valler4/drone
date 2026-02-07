<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Srmklive\PayPal\Services\PayPal;

class paypal_service implements PaymentGatewayInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPal;
        $this->provider->setApiCredentials(config('payment.paypal'));
        $this->provider->getAccessToken();
    }

    public function createPayment($paymentAmount)
    {
        $response = $this->provider->createOrder([
            // نوع عملية الدفع
            'intent' => 'CAPTURE',
            // الروابط التي سيختارها المستخدم
            'application_context' => [
                'return_url' => route('paypal.capture'),
                'cancel_url' => route('deposit'),
            ],
            // الاشياء التي سيتم شرائها
            'purchase_units' => [
                [
                    // الكمية التي سيتم شراءها
                    'amount' => [
                        // العملة
                        'currency_code' => 'USD',
                        // السعر
                        'value' => $paymentAmount,
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // الرد لملف البليد
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

    public function capturePayment($orderID)
    {
        $result = $this->provider->capturePaymentOrder($orderID);

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
