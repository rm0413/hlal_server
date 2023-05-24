<?php

namespace App\Repositories;
use App\Repositories\BaseRepository;
use App\Models\AgreementListCode;
use App\Repositories\Contracts\AgreementListCodeRepositoryContract;

class AgreementListCodeRepository extends BaseRepository implements AgreementListCodeRepositoryContract{
    protected $model;
    public function __construct(AgreementListCode $model)
    {
        $this->model = $model;
    }
}
