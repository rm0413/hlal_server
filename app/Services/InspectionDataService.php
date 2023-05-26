<?php

namespace App\Services;

use App\Services\Contracts\InspectionDataServiceContract;
use App\Repositories\Contracts\InspectionDataRepositoryContract;

class InspectionDataService implements InspectionDataServiceContract
{
    protected $inspection_data_repository_contract;
    public function __construct(InspectionDataRepositoryContract $inspection_data_repository_contract)
    {
        $this->inspection_data_repository_contract = $inspection_data_repository_contract;
    }
    public function store($data)
    {
        return $this->inspection_data_repository_contract->store($data);
    }
}
