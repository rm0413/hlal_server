<?php

namespace App\Repositories\Contracts;

interface InspectionDataRepositoryContract{
    public function store($data);
    public function loadInspectionData();
    public function updateMultiple($id, $data);
    public function update($id, $data);
}
