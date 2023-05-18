<?php

namespace App\Services\Contracts;

interface UnitServiceContract
{

    public function loadUnits();
    public function store($data);
    public function delete($id);
    public function update($id, $data);
}
