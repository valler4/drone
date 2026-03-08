<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'total_users' => $totalUsers,
            'total_deposits' => $totalDeposits,
            'total_transactions' => $totalTransactions,
            'total_purchases' => $totalPurchases,
            'total_tickets' => $totalTickets,
            'total_products' => $totalProducts,
        ]);
    }
}
