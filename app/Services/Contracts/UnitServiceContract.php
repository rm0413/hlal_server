<?php
namespace App\Services\Contracts;

interface UnitServiceContract{

    public function loadUnits();
    public function store($data);
}
