<?php

namespace App\Http\Controllers\v1;

use App\Helpers\Params;
use App\Http\Controllers\Controller;
use App\Http\Requests\application\ApplicationCreateRequest;
use App\Http\Requests\application\ApplicationUpdateRequest;
use App\Http\Resources\v1\ApplicationResource;
use App\Repositories\Interfaces\ApplicationRepository;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    /**
     * @var ApplicationRepository
     */
    public ApplicationRepository $application;
    /**
     * @var UserRepository
     */
    private UserRepository $user;

    /**
     * @param ApplicationRepository $applicationRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        ApplicationRepository $applicationRepository,
        UserRepository        $userRepository
    )
    {
        $this->application = $applicationRepository;
        $this->user = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = auth()->user()->with('applications')->get();
        return Response::success(
            ApplicationResource::collection($user->applications),
            Response::HTTP_OK
        );
    }

    /**
     * @param ApplicationCreateRequest $request
     * @return JsonResponse
     */
    public function store(ApplicationCreateRequest $request): JsonResponse
    {
        $this->application->createAppItem($request->only(Params::APP_FEILDS));

        return Response::success(
            __('custom.crud.create', ['item' => "Application"]),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param $app_code
     * @return JsonResponse
     */
    public function show($app_code): JsonResponse
    {
        $item = $this->application->model
            ->with('versions')
            ->findOrFail($app_code);

        return Response::success(
            new ApplicationResource($item),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param ApplicationUpdateRequest $request
     * @param $app_code
     * @return JsonResponse
     */
    public function update(ApplicationUpdateRequest $request, $app_code): JsonResponse
    {
        $this->application->updateItem($request->only(Params::APP_FEILDS), $app_code, 'app_code');

        return Response::success(
            __('custom.crud.update', ['item' => "Application"]),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param $app_code
     * @return JsonResponse
     */
    public function destroy($app_code): JsonResponse
    {
        $this->application->deleteItem($app_code, 'app_code');

        return Response::success(
            __('custom.crud.delete', ['item' => "Application"]),
            Response::HTTP_OK
        );
    }
}
