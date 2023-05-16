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
