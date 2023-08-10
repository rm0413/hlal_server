<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\EmployeeNotification;
use App\Repositories\Contracts\EmployeeNotificationRepositoryContract;

class EmployeeNotificationRepository extends BaseRepository implements EmployeeNotificationRepositoryContract
{
    protected $model;
    public function __construct(EmployeeNotification $model)
    {
        $this->model = $model;
    }
}
