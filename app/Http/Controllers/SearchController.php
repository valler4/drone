<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        if (strlen($query) < 3) {
            return redirect()->back()->with('error', 'Search query must be at least 3 characters long.');
        }

        $products = Product::search($query)
            ->where('status', 'open')
            ->paginate(30, 'products_page')
            ->appends(['q' => $query]);

        $tickets = Ticket::search($query)
            ->where('user_id', Auth::id())
            ->paginate(30, 'tickets_page')
            ->appends(['q' => $query]);

        $Users = User::search($query)
            ->paginate(30, 'users_page')
            ->appends(['q' => $query]);

        return view('search.results', compact('query', 'products', 'tickets', 'Users'));
    }
}
