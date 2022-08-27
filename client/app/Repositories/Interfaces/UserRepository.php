<?php

namespace App\Repositories\Interfaces;

use App\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function registerNewUser(array $request);

    public function verifyUser(string $verificationCode);

    public function getUserByUsername(string $username);

    public function jwtAuthentication(array $request);

    public function clientResetPassword(string $username);

    public function verifyResetPassword(string $resetCode);

    public function updatePassword(array $request);

    public function invalidatingAuthToken();
}
