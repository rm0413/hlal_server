<?php

namespace App\Repositories\Contracts;

interface EmployeeNotificationRepositoryContract
{
    public function store($data);
    public function updateEmail($id, $data);
}
