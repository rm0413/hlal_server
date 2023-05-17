<?php

namespace App\Repositories\Contracts;

interface UnitRepositoryContract{

    public function loadUnits();
    public function store($data);

}
