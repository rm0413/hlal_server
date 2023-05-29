<?php
namespace App\Repositories\Contracts;

interface AgreementListRepositoryContract {
public function store($data);
public function loadAgreementListRequest();
public function loadWithCodeRequest();
public function loadWithNoCodeRequest();
public function update($id, $data);
public function delete($id);
}


