<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract {
    public function loadAll();
    public function loadUserProfile();
    public function store($data);
    public function showProfile($id);
    public function update($id, $data);
    public function updateUserPortal($id, $data);
    public function delete($id);
}
