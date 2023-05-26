<?php

namespace App\Services\Contracts;

interface AgreementListCodeServiceContract
{
    public function store($data);
    public function loadGenaratedAgreementCode();

    public function show($id, $where, $with);
}
