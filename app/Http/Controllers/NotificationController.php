<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $unread = request()->user()->unreadNotifications;
        return view('notifications.index', compact('unread'));
    }
}
