<?php

namespace App\Repositories\Services;

use App\Models\Application;
use App\Repositories\BaseService;
use App\Repositories\Interfaces\ApplicationRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApplicationService extends BaseService implements ApplicationRepository
{
    public $model;

    public function __construct(Application $model)
    {
        parent::__construct($model);
        $this->model = $model->query();
    }

    /**
     * @param array $request
     * @return void
     * @throws \Exception
     */
    public function createAppItem(array $request)
    {
        $request['app_code'] = Str::uuid();

        try {
            auth()->user()->application()->create($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }
}
