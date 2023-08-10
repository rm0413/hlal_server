<?php

namespace App\Repositories\Contracts;

interface DesignerSectionRepositoryContract
{
    public function store($data);
    public function update($id, $data);
    public function loadCountResult($data);
    public function countRequest($data);
}
