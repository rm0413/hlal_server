<?php

namespace App\Repositories;

use App\Models\InspectionData;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\InspectionDataRepositoryContract;

class InspectionDataRepository extends BaseRepository implements InspectionDataRepositoryContract{

    protected $model;

    public function __construct(InspectionData $model ){
        $this->model = $model;
    }

}
