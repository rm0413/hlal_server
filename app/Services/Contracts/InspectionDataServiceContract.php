<?php
namespace App\Services\Contracts;

interface InspectionDataServiceContract{
    public function store($data);
    public function loadInspectionData();
    public function update($id, $data);

}
