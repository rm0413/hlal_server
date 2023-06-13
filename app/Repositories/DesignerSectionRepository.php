<?php

namespace App\Repositories;
use App\Repositories\BaseRepository;
use App\Models\DesignerSection;
use App\Repositories\Contracts\DesignerSectionRepositoryContract;

class DesignerSectionRepository extends BaseRepository implements DesignerSectionRepositoryContract
{
    protected $model;
    public function __construct(DesignerSection $model)
    {  
       $this->model = $model; 
    }
}