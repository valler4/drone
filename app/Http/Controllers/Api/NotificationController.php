<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $unread = request()->user()->unreadNotifications;
        return response()->json([
            'success' => true,
            'data' => $unread,
        ], 200);
    }
}
