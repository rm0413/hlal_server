<?php

namespace App\Repositories\Contracts;

interface UnitRepositoryContract
{

    public function loadUnits();
    public function store($data);
    public function update($id, $data);
    public function show($id, $where, $with);
    public function delete($id);
}
