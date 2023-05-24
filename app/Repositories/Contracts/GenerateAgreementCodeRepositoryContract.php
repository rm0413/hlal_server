<?php

namespace App\Repositories\Contracts;

interface GenerateAgreementCodeRepositoryContract{
    public function store($data);
    public function loadAll();
    public function loadGenaratedAgreementCode();
}
