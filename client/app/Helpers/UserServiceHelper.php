<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

trait UserServiceHelper
{
    /**
     * @param string $verifyType
     * @param string $verificationCode
     * @return Builder|Model
     * @throws \Exception
     */
    private function verificationCodeHandler(string $verifyType, string $verificationCode): Builder|Model
    {
        $username = mex_decode($verificationCode);
        $user = $this->model->where('username', '=', $username)->firstOrFail();
        $redisVerifyKey = $user->username . '_' . $verifyType;

        if (Redis::get($redisVerifyKey) != $verificationCode) {
            throw new \Exception(__('custom.error.validation.verify'));
        }

        if (!Redis::exists($redisVerifyKey)) {
            throw new \Exception(__('custom.error.expire'));
        }

        return $user;
    }
}
