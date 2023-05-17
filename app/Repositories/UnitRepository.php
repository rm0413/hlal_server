<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UnitRepositoryContract;

class UnitRepository extends BaseRepository implements UnitRepositoryContract
{
    protected $model;
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }
}
