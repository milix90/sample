<?php

namespace App\Repositories\Services;

use App\Helpers\Params;
use App\Models\Version;
use App\Modules\VersionIModifier\classes\AppFile;
use App\Modules\VersionIModifier\classes\ChangeLog;
use App\Modules\VersionIModifier\classes\Images;
use App\Modules\VersionIModifier\VersionModifier;
use App\Repositories\BaseService;
use App\Repositories\Interfaces\ApplicationRepository;
use App\Repositories\Interfaces\VersionRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class VersionService extends BaseService implements VersionRepository
{
    /**
     * @var Builder
     */
    public $model;
    /**
     * @var ApplicationRepository
     */
    private ApplicationRepository $application;

    /**
     * @param Version $model
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(
        Version               $model,
        ApplicationRepository $applicationRepository
    )
    {
        parent::__construct($model);
        $this->model = $model->query();
        $this->application = $applicationRepository;
    }

    /**
     * @param $request
     * @param $appCode
     * @return Model|Builder
     * @throws \Exception
     */
    public function createNewVersion($request, $appCode): Model|Builder
    {
        try {
            $item = $this->application->model->findOrFail($appCode);
            $res = $item->versions()->create(Params::VERSION_FEILDS);

            if (!in_array(null, $item->toArray())) {
                $item->update(['status' => 'in_progress']);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }

        return $res;
    }


    /**
     * @param $request
     * @param $version
     * @return void
     * @throws \Throwable
     */
    public function updateVersionParams($request, $version)
    {
        $item = $this->model->firstOrFail($version);
        /**
         * handle null columns which were not completed by client
         * observer pattern
         */
        $modifier = new VersionModifier($item, $request);
        $modifier->call(AppFile::class)
            ->call(Images::class)
            ->call(ChangeLog::class)
            ->modify();

        if (!in_array(null, $item->toArray())) {
            $item->updateOrFail(['status' => 'in_progress']);
        }
    }
}
