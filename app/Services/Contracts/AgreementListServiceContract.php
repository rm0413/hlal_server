<?php

namespace App\Services\Contracts;

interface AgreementListServiceContract{
    public function store($data);
    public function loadAgreementListRequest();

}
