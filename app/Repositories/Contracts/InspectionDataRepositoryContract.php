<?php

namespace App\Repositories\Contracts;

interface InspectionDataRepositoryContract{
    public function store($data);
    public function loadInspectionData();
}
