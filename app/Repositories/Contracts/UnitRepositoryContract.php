<?php

namespace App\Repositories\Contracts;

interface UnitRepositoryContract
{

    public function loadUnits();
    public function store($data);
    public function update($id, $data);
    public function delete($id);
}
