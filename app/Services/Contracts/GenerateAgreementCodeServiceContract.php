<?php

namespace App\Services\Contracts;

interface GenerateAgreementCodeServiceContract{
    public function store($data);
    public function loadAll();

}
