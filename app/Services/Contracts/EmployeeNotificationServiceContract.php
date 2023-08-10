<?php

namespace App\Services\Contracts;

interface EmployeeNotificationServiceContract
{
    public function store($data);
    public function updateEmail($id, $data);
}
