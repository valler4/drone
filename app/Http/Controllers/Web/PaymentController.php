<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

    public function PaymentData(Request $request)
    {
        $request->validate([
            'payment_data' => 'required|in:paypal,stripe',
            'amount' => 'required|numeric|min:1',
        ]);
        $payment_data = $request->input('payment_data');
        $amount = $request->input('amount');

        return redirect()->route('deposit', ['amount' => $amount, 'payment_data' => $payment_data])->with('success', 'now give me the money');
    }

    public function __construct(PaymentGatewayInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(Request $request)
    {
        $amount = $request->input('amount');
        if (!$amount) {
            return redirect()->route('deposit')->with('error', 'Amount is required');
        }
        $result = $this->paymentService->createPayment($amount);

        if ($result['success']) {
            return redirect()->away($result['url']);
        }

        return redirect()->route('deposit')->with('error', 'Failed to create payment request');
    }

    public function capturePayment(Request $request)
    {
        $result = $this->paymentService->capturePayment($request);

        if (isset($result['status']) && $result['status'] == 'COMPLETED') {

            $amount = $result['amount'];
            $paymentId = $result['id'];
            $payment_data = $request->input('payment_data');

            DB::transaction(function () use ($request, $result, $amount, $paymentId, $payment_data) {
                $user = $request->user();

                $user->notify(new DepositSuccessful($amount, $paymentId));
                $user->increment('balance', $amount);

                deposit::create([
                    'user_id' => $user->id,
                    'payment_id' => $result['id'],
                    'currency' => $result['currency'],
                    'status' => $result['status'],
                    'method' => $payment_data,
                    'amount' => $amount,
                    'type' => 'deposit',
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'the payment was successful');
        }

        return redirect()->route('deposit')->with('error', 'Failed to capture payment');
    }
}
