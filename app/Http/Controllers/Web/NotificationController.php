<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $unread = request()->user()->unreadNotifications;
        return view('notifications.index', compact('unread'));
    }
}
