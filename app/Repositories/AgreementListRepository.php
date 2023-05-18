<?php

namespace App\Repositories;

use App\Models\AgreementList;
use App\Repositories\BaseRepository;
use App\Repositories\contracts\AgreementListRepositoryContract;

class AgreementListRepository extends BaseRepository implements AgreementListRepositoryContract
{
    protected $model;
    public function __construct(AgreementList $model)
    {
        $this->model = $model;
    }
}
