<?php

namespace App\Http\Controllers;

use App\Models\deposit;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class DepositController extends Controller
{
    use Logs;

    public function depositnumber(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        session([
            'payment_amount' => $request->amount,
        ]);

        return redirect()->route('deposit')->with('success', 'دلوقتي هات فلوسك');
    }

    public function createPayment(Request $request)
    {
        $paymentAmount = session('payment_amount', 10.00);
        // تجهيز المكتبة
        $provider = new paypalClient;
        // تجهيز بيانات عملية الدفع
        $provider->setApiCredentials(config('paypal'));
        // تجهيز توكن الشراء
        $provider->getAccessToken();
        // انشاء طلب الدفع
        $response = $provider->createOrder([
            // نوع عملية الدفع
            'intent' => 'CAPTURE',
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

        // التحقق من نجاح عملية انشاء الطلب
        if (isset($response['id']) && $response['id'] != null) {
            // الرد لملف البليد
            return response()->json($response);
        }

        // في حال فشل انشاء الطلب
        return response()->json(['error' => 'somthing went wrong'], 500);
    }

    public function capturePayment(Request $request)
    {
        $orderID = $request->orderID;

        // تجهيز المكتبة
        $provider = new paypalClient;
        // تجهيز بيانات عملية الدفع
        $provider->setApiCredentials(config('paypal'));
        // تجهيز توكن الشراء
        $provider->getAccessToken();
        // سرقة الفلوس من العميل
        $result = $provider->capturePaymentOrder($orderID);
        // التحقق من نجاح عملية السرقة
        if (isset($result['status']) && $result['status'] == 'COMPLETED') {
            // رسالة نجاح لملف البليد
            // هنا يمكنك اضافة كود لتخزين بيانات العملية في قاعدة البيانات

            $amount = $result['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

            DB::transaction(function () use ($request, $result, $amount) {
                $user = $request->user();
                $user->increment('balance', $amount);
                deposit::create([
                    'user_id' => $user->id,
                    'payment_id' => $result['id'],
                    'currency' => $result['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                    'status' => $result['status'],
                    'method' => 'paypal',
                    'amount' => $amount,
                    'type' => 'deposit',
                ]);
            });

            return response()->json(['status' => 'Success', 'details' => $result]);
        }

        // في حال فشل السرقة
        return response()->json(['status' => 'Error', 'message' => 'Payment failed'], 500);
    }
}
