<?php
namespace App\Services\Contracts;

interface UserServiceContract {
    public function loadAll();
    public function store($data);
    public function showProfile($id);
    public function update($id, $data);
    public function delete($id);
}
