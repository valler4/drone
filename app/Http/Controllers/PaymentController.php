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

    public function PaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:paypal,stripe',
            'amount' => 'required|numeric|min:1',
        ]);
        $payment_method = $request->input('payment_method');
        $amount = $request->input('amount');

        return redirect()->route('deposit', ['amount' => $amount, 'payment_method' => $payment_method])->with('success', 'دلوقتي هات فلوسك');
    }

    public function __construct(PaymentGatewayInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(Request $request)
    {
        $amount = $request->input('amount');
        if (!$amount) {
            return redirect()->route('deposit')->with('error', 'المبلغ غير موجود');
        }
        $result = $this->paymentService->createPayment($amount);

        if ($result['success']) {
            return redirect()->away($result['url']);
        }

        return redirect()->route('deposit')->with('error', 'فشل انشاء طلب الدفع');
    }

    public function capturePayment(Request $request)
    {
        $result = $this->paymentService->capturePayment($request);

        if (isset($result['status']) && $result['status'] == 'COMPLETED') {

            $amount = $result['amount'];
            $paymentId = $result['id'];
            $payment_method = $request->input('payment_method');

            DB::transaction(function () use ($request, $result, $amount, $paymentId, $payment_method) {
                $user = $request->user();

                $user->notify(new DepositSuccessful($amount, $paymentId));
                $user->increment('balance', $amount);

                deposit::create([
                    'user_id' => $user->id,
                    'payment_id' => $result['id'],
                    'currency' => $result['currency'],
                    'status' => $result['status'],
                    'method' => $payment_method,
                    'amount' => $amount,
                    'type' => 'deposit',
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'تم شحن الرصيد بنجاح!');
        }

        return redirect()->route('deposit')->with('error', 'فشل السرقة');
    }
}
