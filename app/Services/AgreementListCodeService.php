<?php

namespace App\Services;

use App\Repositories\Contracts\AgreementListCodeRepositoryContract;
use App\Services\Contracts\AgreementListCodeServiceContract;

class AgreementListCodeService implements AgreementListCodeServiceContract
{

    protected $agreement_list_code_contract;
    public function __construct(AgreementListCodeRepositoryContract $agreement_list_code_contract)
    {
        $this->agreement_list_code_contract = $agreement_list_code_contract;
    }
    public function store($data)
    {
        return $this->agreement_list_code_contract->store($data);
    }
    public function loadGenaratedAgreementCode()
    {
        return $this->agreement_list_code_contract->loadGenaratedAgreementCode();
    }
}
