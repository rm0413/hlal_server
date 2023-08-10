<?php

namespace App\Services;

use App\Services\Contracts\EmployeeNotificationServiceContract;
use App\Repositories\Contracts\EmployeeNotificationRepositoryContract;

class EmployeeNotificationService implements EmployeeNotificationServiceContract
{
    protected $employee_notification_contract;
    public function __construct(EmployeeNotificationRepositoryContract $employee_notification_contract)
    {
        $this->employee_notification_contract = $employee_notification_contract;
    }
    public function store($data)
    {
        return $this->employee_notification_contract->store($data);
    }
    public function updateEmail($id, $data)
    {
        return $this->employee_notification_contract->updateEmail($id, $data);
    }
}
