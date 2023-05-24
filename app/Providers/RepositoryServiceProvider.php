<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UnitRepositoryContract;
use App\Repositories\UnitRepository;
use App\Repositories\AgreementListRepository;
use App\Repositories\AgreementListCodeRepository;
use App\Repositories\Contracts\AgreementListRepositoryContract;
use App\Repositories\Contracts\AgreementListCodeRepositoryContract;
use App\Repositories\Contracts\GenerateAgreementCodeRepositoryContract;
use App\Repositories\GenerateAgreementCodeRepository;

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
        $this->app->bind(
            AgreementListCodeRepositoryContract::class,
            AgreementListCodeRepository::class
        );
        $this->app->bind(
            GenerateAgreementCodeRepositoryContract::class,
            GenerateAgreementCodeRepository::class
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
