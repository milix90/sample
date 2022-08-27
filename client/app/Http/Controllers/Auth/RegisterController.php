<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Params;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UserRegisterRequest;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as RSP;

class RegisterController extends Controller
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

    public function register(UserRegisterRequest $request)
    {
        $this->user->registerNewUser($request->only(Params::REGISTER_FEILDS));

        return Response::success(
            __('custom.msg.register'),
            RSP::HTTP_CREATED
        );
    }
}
