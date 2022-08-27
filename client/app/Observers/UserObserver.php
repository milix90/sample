<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\v1\VerificationCodeNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class UserObserver
{
    /**
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function created(User $user)
    {
        try {
            $verification = mex_encode($user->username);
            Redis::setex($user->username . '_verify_account', config('redis.ttl.verify'), $verification);
            $user->notify(new VerificationCodeNotification($verification));
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
