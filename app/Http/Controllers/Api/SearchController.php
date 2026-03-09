<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required.',
            ], 400);
        }

        if (strlen($query) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Search query must be at least 3 characters long.',
            ], 400);
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

        return response()->json([
            'success' => true,
            'query' => $query,
            'products' => $products,
            'tickets' => $tickets,
            'users' => UserResource::collection($Users),
        ], 200);
    }
}
