<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Traits\Logs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Logs;

    public function dashboard(Request $request)
    {
        $money = number_format($request->user()->balance, 2);
        return response()->json([
            'success' => true,
            'data' => $money,
        ]);
    }

    public function logDashboard(Request $request)
    {
        $userLogs = Activity::where('user_id', $request->user()->id)->latest()->paginate(30);

        return response()->json([
            'success' => true,
            'data' => $userLogs,
        ]);
    }
}
