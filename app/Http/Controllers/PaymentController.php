<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\deposit;
use App\Notifications\DepositSuccessful;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    use Logs;

    protected $paymentService;

    public function depositnumber(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:paypal,stripe',
        ]);
        session([
            'payment_amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('deposit')->with('success', 'دلوقتي هات فلوسك');
    }

    // انشاء الطلب تلقائي عند تشغيل الكونترولر
    public function __construct(PaymentGatewayInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // انشاء طلب الدفع
    public function createPayment(Request $request)
    {   // مبلغ الدفع
        $paymentAmount = session('payment_amount', 10.00);
        // رد طلب الدفع
        $result = $this->paymentService->createPayment($paymentAmount);

        // التحقق من وجود رابط توجيه (سواء من PayPal أو Stripe مستقبلاً)
        if ($result['success']) {
            return redirect()->away($result['url']);
        }

        // في حال فشل انشاء الطلب
        return redirect()->route('deposit')->with('error', 'فشل انشاء طلب الدفع');
        // todo add error log . json_encode($response)
    }

    public function capturePayment(Request $request)
    {
        // التحقق من نجاح عملية الدفع
        $result = $this->paymentService->capturePayment($request->token);

        if (isset($result['status']) && $result['status'] == 'COMPLETED') {
            $amount = $result['amount'];
            $paymentId = $result['id'];
            // لتخزين بيانات العملية في قاعدة البيانات
            DB::transaction(function () use ($request, $result, $amount, $paymentId) {
                $user = $request->user();

                $user->notify(new DepositSuccessful($amount, $paymentId));
                $user->increment('balance', $amount);

                deposit::create([
                    'user_id' => $user->id,
                    'payment_id' => $result['id'],
                    'currency' => $result['currency'],
                    'status' => $result['status'],
                    'method' => session('payment_method', 'paypal'),
                    'amount' => $amount,
                    'type' => 'deposit',
                ]);
            });

            // رسالة نجاح لملف البليد
            return redirect()->route('dashboard')->with('success', 'تم شحن الرصيد بنجاح!');
        }

        // في حال فشل السرقة
        return redirect()->route('deposit')->with('error', 'فشل السرقة');
    }
}
