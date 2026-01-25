<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Log;

trait Logs
{

    public function logActivity($action, $description)
    {
        $user = request()->user();

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/user_activity.log'),
        ])->info("user_id: {$user->id} | action: {$action} | desc: {$description}");

        Activity::create([
            'user_id'    => $user->id,
            'action'     => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
