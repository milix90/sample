<?php

namespace App\Http\Controllers\v1;

use App\Helpers\Params;
use App\Http\Controllers\Controller;
use App\Http\Requests\version\NewVersionCreateOrUpdateRequest;
use App\Http\Resources\v1\VersionDetailsResource;
use App\Repositories\Interfaces\ApplicationRepository;
use App\Repositories\Interfaces\VersionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VersionController extends Controller
{

    /**
     * @var VersionRepository
     */
    private VersionRepository $version;
    private ApplicationRepository $application;

    /**
     * @param VersionRepository $versionRepository
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(
        VersionRepository     $versionRepository,
        ApplicationRepository $applicationRepository,
    )
    {
        $this->version = $versionRepository;
        $this->application = $applicationRepository;
    }

    /**
     * @param $app_code
     * @return JsonResponse
     */
    public function index($app_code): JsonResponse
    {
        $app = $this->application->model->findOrFail($app_code);
        $items = $app->load('versions')->versions;

        return Response::success(
            VersionDetailsResource::collection($items),
            Response::HTTP_OK
        );
    }

    /**
     * @param NewVersionCreateOrUpdateRequest $request
     * @param $app_code
     * @return JsonResponse
     */
    public function store(NewVersionCreateOrUpdateRequest $request, $app_code): JsonResponse
    {
        $this->version->createNewVersion(
            $request->only(Params::VERSION_FEILDS),
            $app_code
        );

        return Response::success(
            __('custom.crud.create', ['item' => "Version"]),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param $version
     * @return JsonResponse
     */
    public function show($version): JsonResponse
    {
        $item = $this->version->model->findOrFail($version);

        return Response::success(
            new VersionDetailsResource($item),
            Response::HTTP_OK
        );
    }

    /**
     * @param NewVersionCreateOrUpdateRequest $request
     * @param $version
     * @return JsonResponse
     */
    public function update(NewVersionCreateOrUpdateRequest $request, $version): JsonResponse
    {
        $this->version->updateVersionParams(
            $request->only(Params::VERSION_FEILDS),
            $version
        );

        return Response::success(
            __('custom.crud.update', ['item' => "Version"]),
            Response::HTTP_ACCEPTED
        );
    }


    public function destroy($version)
    {
        $this->version->deleteItem($version, 'version');

        return Response::success(
            __('custom.crud.delete', ['item' => "Version"]),
            Response::HTTP_OK
        );
    }
}
