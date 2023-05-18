<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UnitRepositoryContract;
use App\Repositories\UnitRepository;
use App\Repositories\AgreementListRepository;
use App\Repositories\Contracts\AgreementListRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryContract::class,
            UserRepository::class
        );
        $this->app->bind(
            UnitRepositoryContract::class,
            UnitRepository::class
        );
        $this->app->bind(
            AgreementListRepositoryContract::class,
            AgreementListRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
