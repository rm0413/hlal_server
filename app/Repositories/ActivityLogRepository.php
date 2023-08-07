<?php

namespace App\Repositories;

use App\Models\ActivityLogs;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ActivityLogRepositoryContract;

class ActivityLogRepository extends BaseRepository implements ActivityLogRepositoryContract
{
    protected $model;

    public function __construct(ActivityLogs $model)
    {
        $this->model = $model;
    }
}
