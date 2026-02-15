<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\Product;
use App\Models\Purchase;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDeposits = Deposit::sum('amount');
        $totalTransactions = Transaction::count();
        $totalPurchases = Purchase::count();
        $totalTickets = Ticket::count();
        $totalProducts = Product::count();

        return view('admin.index', compact(
            'totalUsers',
            'totalDeposits',
            'totalTransactions',
            'totalPurchases',
            'totalTickets',
            'totalProducts'
        ));
    }
}
