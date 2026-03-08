<?php

namespace App\Http\Controllers\Api;

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

    public function __construct(PaymentGatewayInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'payment_Data' => 'required|in:paypal,stripe',
            'amount' => 'required|numeric|min:1',
        ]);
        $payment_Data = $request->input('payment_Data');

        $amount = $request->input('amount');
        if (!$amount) {
            return response()->json([
                'success' => false,
                'message' => 'Amount is required',
            ], 400);
        }
        $result = $this->paymentService->createPayment($amount);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'url' => $result['url'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create payment',
        ], 400);
    }

    public function capturePayment(Request $request)
    {
        $result = $this->paymentService->capturePayment($request);

        if (isset($result['status']) && $result['status'] == 'COMPLETED') {

            $amount = $result['amount'];
            $paymentId = $result['id'];
            $payment_Data = $request->input('payment_Data');

            DB::transaction(function () use ($request, $result, $amount, $paymentId, $payment_Data) {
                $user = $request->user();

                $user->notify(new DepositSuccessful($amount, $paymentId));
                $user->increment('balance', $amount);

                deposit::create([
                    'user_id' => $user->id,
                    'payment_id' => $result['id'],
                    'currency' => $result['currency'],
                    'status' => $result['status'],
                    'method' => $payment_Data,
                    'amount' => $amount,
                    'type' => 'deposit',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Payment captured successfully',
                'amount' => $amount,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to capture payment',
        ], 400);
    }
}
