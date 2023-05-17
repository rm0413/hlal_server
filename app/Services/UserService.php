<?php

namespace App\Services;

use App\Services\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;

class UserService implements UserServiceContract
{

    protected $user_repository_contract;

    public function __construct(UserRepositoryContract $user_repository_contract)
    {
        $this->user_repository_contract = $user_repository_contract;
    }
    public function loadAll()
    {
        return $this->user_repository_contract->loadAll();
    }
    public function loadUserProfile()
    {
        $result = $this->user_repository_contract->loadUserProfile();
        $datastorage = [];
        foreach($result as $users){
            $datastorage[] = [
                'user_id' => $users['id'],
                'emp_id' => $users['employee_id'],
                'role_access' => $users['role_access'],
                'emp_first_name' => $users->hris_masterlist['emp_first_name'],
                'emp_last_name' => $users->hris_masterlist['emp_last_name'],
                'emp_middle_name' => $users->hris_masterlist['emp_middle_name'],
                'emp_photo' => $users->hris_masterlist['emp_photo'],
                'emp_system_status' => $users->hris_masterlist['emp_system_status'],
                'position' => $users->hris_masterlist['position'],
                'section_code' => $users->hris_masterlist['section_code'],
            ];
        }
        return $datastorage;
    }
    public function store($data)
    {
        return $this->user_repository_contract->store($data);
    }
    public function showProfile($id)
    {
        return $this->user_repository_contract->showProfile($id);
    }
    public function update($id, $data){
        return $this->user_repository_contract->update($id, $data);
    }
    public function delete($id)
    {
        return $this->user_repository_contract->delete($id);
    }
}
