<?php

namespace App\Services;

use App\Services\Contracts\AgreementListServiceContract;
use App\Repositories\Contracts\AgreementListRepositoryContract;

class AgreementListService implements AgreementListServiceContract
{
    protected $agreement_list_contract;
    public function __construct(AgreementListRepositoryContract $agreement_list_contract)
    {
        $this->agreement_list_contract = $agreement_list_contract;
    }
    public function store($data)
    {
        return $this->agreement_list_contract->store($data);
    }
    public function loadAgreementListRequest()
    {
        return $this->agreement_list_contract->loadAgreementListRequest();
    }
}
