<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deposit;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
        'totalUsers' => User::count(),
        'totalDeposits' => Deposit::sum('amount'),
        'recentTransactions' => Deposit::with('user')->latest()->take(30)->get(),
    ]);
    }
}
