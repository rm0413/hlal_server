<?php

namespace App\Services;

use App\Repositories\Contracts\DesignerSectionRepositoryContract;
use App\Services\Contracts\DesignerSectionServiceContract;

class DesignerSectionService implements DesignerSectionServiceContract
{
    protected $designer_section_contract;
    public function __construct(DesignerSectionRepositoryContract $designer_section_contract)
    {   
        $this->designer_section_contract = $designer_section_contract;
    }
    public function store($data)
    {
        return $this->designer_section_contract->store($data);
    }
    public function update($id, $data)
    {
        return $this->designer_section_contract->update($id, $data);
    }
}