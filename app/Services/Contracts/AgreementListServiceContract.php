<?php

namespace App\Services\Contracts;

interface AgreementListServiceContract{
    public function store($data);
    public function loadWithCodeRequest();
    public function loadWithNoCodeRequest();
    public function update($id, $data);
    public function delete($id);

}
