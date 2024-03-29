<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ActivityLogRepository;
use App\Repositories\Contracts\ActivityLogRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UnitRepositoryContract;
use App\Repositories\UnitRepository;
use App\Repositories\AgreementListRepository;
use App\Repositories\AgreementListCodeRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\Contracts\AgreementListRepositoryContract;
use App\Repositories\Contracts\AgreementListCodeRepositoryContract;
use App\Repositories\Contracts\GenerateAgreementCodeRepositoryContract;
use App\Repositories\Contracts\InspectionDataRepositoryContract;
use App\Repositories\Contracts\AttachmentRepositoryContract;
use App\Repositories\Contracts\DesignerSectionRepositoryContract;
use App\Repositories\Contracts\EmployeeNotificationRepositoryContract;
use App\Repositories\DesignerSectionRepository;
use App\Repositories\EmployeeNotificationRepository;
use App\Repositories\GenerateAgreementCodeRepository;
use App\Repositories\InspectionDataRepository;

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
        $this->app->bind(
            InspectionDataRepositoryContract::class,
            InspectionDataRepository::class
        );
        $this->app->bind(
            AttachmentRepositoryContract::class,
            AttachmentRepository::class
        );
        $this->app->bind(
            DesignerSectionRepositoryContract::class,
            DesignerSectionRepository::class
        );
        $this->app->bind(
            ActivityLogRepositoryContract::class,
            ActivityLogRepository::class
        );
        $this->app->bind(
            EmployeeNotificationRepositoryContract::class,
            EmployeeNotificationRepository::class
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
