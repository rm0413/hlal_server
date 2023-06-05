<?php

namespace App\Repositories;

use App\Models\Attachement;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AttachmentRepositoryContract;

class AttachmentRepository extends BaseRepository implements AttachmentRepositoryContract
{
    protected $model;
    public function __construct(Attachement $model)
    {
        $this->model = $model;
    }
}