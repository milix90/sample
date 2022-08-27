<?php

namespace App\Repositories\Services;

use App\Helpers\UserServiceHelper;
use App\Models\User;
use App\Notifications\v1\ResetPasswordNotification;
use App\Repositories\BaseService;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response as RSP;
use Tymon\JWTAuth\JWT;

class UserService extends BaseService implements UserRepository
{
    use UserServiceHelper;

    /**
     * @var Builder
     */
    public $model;
    /**
     * @var JWT
     */
    private JWT $jwt;

    /**
     * @param User $model
     * @param JWT $jwt
     */
    public function __construct(User $model, JWT $jwt)
    {
        parent::__construct($model);
        $this->model = $model->query();
        $this->jwt = $jwt;
    }

    /**
     * @param array $request
     * @return void
     * @throws \Exception
     */
    public function registerNewUser(array $request)
    {
        try {
            $request['username'] = hexdec(uniqid());
            $this->model->create($request);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * @param $username
     * @return Model|Builder
     */
    public function getUserByUsername($username): Model|Builder
    {
        return $this->model->where('email', '=', $username)
            ->orWhere('mobile', '=', $username)
            ->firstOrFail();
    }

    /**
     * @param string $verificationCode
     * @return void
     * @throws \Throwable
     */
    public function verifyUser(string $verificationCode)
    {
        $user = $this->verificationCodeHandler('verify_account', $verificationCode);

        if (!!$user->verify) {
            throw new \Exception(__('custom.error.verify'));
        }

        $user->updateOrFail(['verify' => true]);
    }

    /**
     * @param array $request
     * @return JsonResponse|string
     */
    public function jwtAuthentication(array $request): JsonResponse|string
    {
        $user = $this->getUserByUsername($request['username']);
        $credentials = ['email' => $user->email, 'password' => $request['password']];
        $token = auth()->setTTL(config('jwt.ttl'))->attempt($credentials);

        if (!$token) {
            return Response::error('Unauthorized', RSP::HTTP_UNAUTHORIZED);
        }

        return $token;
    }

    /**
     * @param string $username
     * @return void
     * @throws \Throwable
     */
    public function clientResetPassword(string $username)
    {
        $user = $this->getUserByUsername($username);

        try {
            $reset = mex_encode($user->username);
            Redis::setex($user->username . '_reset_password', config('redis.ttl'), $reset);
            $user->updateOrFail(['active' => false]);
            $user->notify(new ResetPasswordNotification($user, $reset));
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }


    /**
     * @param string $resetCode
     * @return mixed
     * @throws \Exception
     */
    public function verifyResetPassword(string $resetCode): mixed
    {
        $user = $this->verificationCodeHandler('reset_password', $resetCode);
        return $user->username;
    }

    /**
     * @param array $request
     * @return void
     * @throws \Throwable
     */
    public function updatePassword(array $request)
    {
        $user = $this->model->where('username', '=', $request['reset_payload'])->firstOrFail();
        $user->updateOrFail(['active' => true, 'password' => $request['password']]);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function invalidatingAuthToken()
    {
        try {
            $token = $this->jwt->getToken();
            $this->jwt->setToken($token)->invalidate(true);
        } catch (JWTException $e) {
            $this->jwt->parseToken()->unsetToken();
            throw new JWTException($e);
        }
    }
}
