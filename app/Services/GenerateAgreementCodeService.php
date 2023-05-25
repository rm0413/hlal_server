<?php

namespace App\Services;

use App\Services\Contracts\GenerateAgreementCodeServiceContract;
use App\Repositories\Contracts\GenerateAgreementCodeRepositoryContract;

class GenerateAgreementCodeService implements GenerateAgreementCodeServiceContract
{
    protected $generate_agreement_code;
    public function __construct(GenerateAgreementCodeRepositoryContract $generate_agreement_code)
    {
        $this->generate_agreement_code = $generate_agreement_code;
    }
    public function store($data)
    {
        return $this->generate_agreement_code->store($data);
    }
    public function loadAll()
    {
      $result = $this->generate_agreement_code->loadAll();
      rsort($result);
      return $result;
    }
}
