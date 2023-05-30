<?php

namespace App\Services;

use App\Services\Contracts\AttachmentServiceContract;
use App\Repositories\Contracts\AttachmentRepositoryContract;

class AttachmentService implements AttachmentServiceContract
{
    protected $attachment_contract;
    public function __construct(AttachmentRepositoryContract $attachment_contract)
    {
        $this->attachment_contract = $attachment_contract;
    }
    public function store($data)
    {
        return $this->attachment_contract->store($data);
    }
}