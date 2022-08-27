<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Params;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UserLoginRequest;
use App\Http\Requests\auth\ActionsVerifyRequest;
use App\Http\Resources\v1\UserLoginResource;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as RSP;

class AuthController extends Controller
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
     * @param UserLoginRequest $request
     * @return mixed
     */
    public function login(UserLoginRequest $request)
    {
        $token = $this->user->jwtAuthentication($request->only(Params::LOGIN_FEILDS));

        return Response::success(
            new UserLoginResource($token),
            RSP::HTTP_OK
        );
    }


    /**
     * @return mixed
     */
    public function logout()
    {
        $this->user->invalidatingAuthToken();

        return Response::success(
            __('custom.msg.logout'),
            RSP::HTTP_ACCEPTED
        );
    }

    /**
     * @param ActionsVerifyRequest $request
     * @return JsonResponse
     */
    public function verifyCode(ActionsVerifyRequest $request): JsonResponse
    {
        $this->user->verifyUser($request->action);

        return Response::success(
            __('custom.msg.verify'),
            RSP::HTTP_ACCEPTED
        );
    }
}
