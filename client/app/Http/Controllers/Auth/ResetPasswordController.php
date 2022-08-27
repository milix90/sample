<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Params;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\ActionsVerifyRequest;
use App\Http\Requests\auth\ConfirmResetPasswordRequest;
use App\Http\Requests\auth\ResetPasswordRequest;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as RSP;

class ResetPasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    public $user;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    /**
     * @param ResetPasswordRequest $request
     * @return mixed
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->user->clientResetPassword($request->username);

        return Response::success(
            __('custom.msg.reset'),
            RSP::HTTP_OK
        );
    }

    /**
     * @param ActionsVerifyRequest $request
     * @return mixed
     */
    public function verifyResetPassword(ActionsVerifyRequest $request)
    {
        $username = $this->user->verifyResetPassword($request->acttion);

        return Response::success(
            ['reset_payload' => $username],
            RSP::HTTP_OK
        );
    }

    /**
     * @param ConfirmResetPasswordRequest $request
     * @return mixed
     */
    public function changePassword(ConfirmResetPasswordRequest $request)
    {
        $this->user->updatePassword($request->only(Params::RESET_PASSWORD_FEILDS));

        return Response::success(
            __('custom.crud.update', ['item' => 'Your password']),
            RSP::HTTP_OK
        );
    }
}
