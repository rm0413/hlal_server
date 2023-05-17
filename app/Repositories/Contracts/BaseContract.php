<?php
namespace App\Repositories\Contracts;

interface BaseContract{
    public function loadAll();
    public function loadUserProfile();
    public function store($data);
    public function showProfile($id);
    public function update($id, $data);
    public function delete($id);


}
