<?php

namespace App\Providers\Custom;

use App\Repositories\BaseRepository;
use App\Repositories\BaseService;
use App\Repositories\Interfaces\ApplicationRepository;
use App\Repositories\Interfaces\PaymentRepository;
use App\Repositories\Interfaces\ProcessHistoryRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\VersionRepository;
use App\Repositories\Services\ApplicationService;
use App\Repositories\Services\PaymentService;
use App\Repositories\Services\ProcessHistoryService;
use App\Repositories\Services\UserService;
use App\Repositories\Services\VersionService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepository::class, BaseService::class);
        $this->app->bind(ApplicationRepository::class, ApplicationService::class);
        $this->app->bind(PaymentRepository::class, PaymentService::class);
        $this->app->bind(ProcessHistoryRepository::class, ProcessHistoryService::class);
        $this->app->bind(UserRepository::class, UserService::class);
        $this->app->bind(VersionRepository::class, VersionService::class);
    }
}
