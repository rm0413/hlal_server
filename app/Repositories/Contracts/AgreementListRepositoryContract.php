<?php
namespace App\Repositories\Contracts;

interface AgreementListRepositoryContract {
public function store($data);
public function loadAgreementListRequest();
}
