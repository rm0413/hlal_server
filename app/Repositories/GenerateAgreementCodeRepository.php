<?php

namespace App\Repositories;

use App\Models\GenerateAgreementCode;
use App\Repositories\Contracts\GenerateAgreementCodeRepositoryContract;
use App\Repositories\BaseRepository;

class GenerateAgreementCodeRepository extends BaseRepository implements GenerateAgreementCodeRepositoryContract
{
    protected $model;

    public function __construct(GenerateAgreementCode $model)
    {
        $this->model = $model;
    }
}
