<?php

namespace App\Services\Contracts;

interface DesignerSectionServiceContract
{
    public function store($data);
    public function update($id, $data);
    // public function loadCountResult($data);

}
