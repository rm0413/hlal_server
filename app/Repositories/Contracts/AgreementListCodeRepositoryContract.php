<?php

namespace App\Repositories\Contracts;

interface AgreementListCodeRepositoryContract
{
    public function store($data);
    public function loadGenaratedAgreementCode();
    public function show($id, $where, $with);
}
