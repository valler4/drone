<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Traits\Logs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Logs;

    public function dashboard()
    {
        return view('user-dashboard', compact('user'));
    }

    public function logDashboard(Request $request)
    {
        $userLogs = Activity::where('user_id', $request->user()->id)->latest()->paginate(30);

        return view('dashboard.log-dashboard', compact('userLogs'));
    }
}
