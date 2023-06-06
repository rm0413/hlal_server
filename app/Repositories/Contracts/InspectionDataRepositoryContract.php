<?php

namespace App\Repositories\Contracts;

interface InspectionDataRepositoryContract{
    public function store($data);
    public function loadInspectionData();
    public function update($id, $data);
}
