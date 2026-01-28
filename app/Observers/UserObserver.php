<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\Logs;

class UserObserver
{
    use Logs;
    public function created(User $user): void
    {
        //
    }

    public function updated(User $user): void
    {
        $changes = $user->getChanges();

        $sensitivefields = ['password', 'remember_token', 'pin_code'];

        $ignoredfields = ['updated_at', 'last_login', 'balance'];

        foreach ($changes as $change => $newvalue) {
            if (in_array($change, $ignoredfields)) continue;
            if (in_array($change, $sensitivefields)) {
                $oldvalue = $user->getOriginal($change);
                $this->logActivity(
                    "security update",
                    "{$change} updated successfully",
                    "id: {$user->id} user {$user->user_name} updated his {$change}"
                );
            } else {
                $oldvalue = $user->getOriginal($change);
                $this->logActivity(
                    "updated {$change}",
                    "{$change} updated from: {$oldvalue} to {$newvalue}",
                    "id: {$user->id} user {$user->user_name} updated his {$change} from: {$oldvalue} to {$newvalue}"
                );
            }
        }
    }

    public function deleted(User $user): void
    {
        //
    }

    public function restored(User $user): void
    {
        //
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
