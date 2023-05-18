<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseContract;

abstract class BaseRepository implements BaseContract
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function loadAll()
    {
        return $this->model->get();
    }
    public function loadUserProfile()
    {
        return $this->model->with('hris_masterlist', 'fdtp_portal_user')->get();
    }
    public function store($data)
    {
        return $this->model->create($data);
    }
    public function showProfile($id)
    {
        return $this->model->with('hris_masterlist', 'fdtp_portal_user')->find($id);
    }
    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function updateUserPortal($id, $data)
    {
        return $this->model->where('employee_id', $id)->update($data);
    }
    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
    public function loadUnits()
    {
        return $this->model->with('hris_masterlist', 'fdtp_portal_user')->get();
    }
}
