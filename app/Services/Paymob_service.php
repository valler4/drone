<?php
/*
namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class Paymob_service extends Base_Payment_Service implements PaymentGatewayInterface
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = config('payment.paymob.base_url');
    }

    public function createPayment($amount)
    {
        try {
            // الخطوة 1: الحصول على الـ Authentication Token
            // بنرسل الـ API Key لـ Paymob عشان يقولوا لنا "تمام أنتم مين"
            $authResponse = Http::post("{$this->base_url}/auth/tokens", [
                'api_key' => config('payment.paymob.api_key'),
            ]);

            if (! $authResponse->successful()) {
                return ['success' => false, 'message' => 'Auth Failed'];
            }

            $token = $authResponse->json()['token'];

            // الخطوة 2: إنشاء طلب (Order Registration)
            // بنعرف Paymob إن فيه عملية شراء جديدة هتحصل وبكام
            $orderResponse = Http::post("{$this->base_url}/ecommerce/orders", [
                'auth_token' => $token,
                'delivery_needed' => 'false',
                'amount_cents' => $amount * 100,
                'currency' => 'EGP',
                'items' => [],
            ]);

            if (! $orderResponse->successful()) {
                return ['success' => false, 'message' => 'Order creation Failed'];
            }

            $orderID = $orderResponse->json()['id'];

            // الخطوة 3: الحصول على مفتاح الدفع (Payment Key)
            // دي أهم خطوة، بنحدد فيها طريقة الدفع وبيانات العميل
            $paymentKeyResponse = Http::post("{$this->base_url}/acceptance/payment_keys", [
                'auth_token' => $token,
                'amount_cents' => $amount * 100,
                'expiration' => 3600,
                'order_id' => $orderID,
                'billing_data' => [
                    'first_name' => auth()->user()->name ?? 'Guest',
                    'last_name' => 'User',
                    'email' => auth()->user()->email ?? 'test@example.com',
                    'phone_number' => '01000000000', // لازم رقم تليفون
                    'city' => 'Cairo',
                    'country' => 'EG',
                    'street' => 'NA',
                    'building' => 'NA',
                    'floor' => 'NA',
                    'apartment' => 'NA',
                ],
                'currency' => 'EGP',
                'integration_id' => config('payment.paymob.integration_id'),
            ]);

            if (! $paymentKeyResponse->successful()) {
                return ['success' => false, 'message' => 'payment key Failed'];
            }

            $paymentToken = $paymentKeyResponse->json()['token'];

            $result = [
                'success' => true,
                'url' => 'https://accept.paymob.com/api/acceptance/iframes/'.config('payment.paymob.iframe_id').'?payment_token='.$paymentToken,
            ];

            return $result;
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage(), json_encode($e)];
        }
    }

    public function capturePayment($request)
    {
        $isSuccess = ($request['success'] === 'true' || $request['success'] === true);
        $isPending = ($request['pending'] === 'true' || $request['pending'] === true);

        if ($isSuccess && ! $isPending) {
            $result = [
                'status' => 'COMPLETED',
                'id' => $request['order_id'],
                'amount' => $request['amount_cents'] / 100,
                'currency' => $request['currency'],
                'success' => true,
            ];

            return $result;
        }

        return [
            'status' => 'FAILED',
            'success' => false,
        ];

    }
}
*/
