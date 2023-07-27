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
    public function updateMultiple($data, $id)
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
    public function loadAgreementListRequest()
    {
        return $this->model->with('units')->get();
    }
    public function loadGenaratedAgreementCode()
    {
        return $this->model->with('agreement_list', 'generate_code')->get();
    }
    public function loadWithCodeRequest()
    {
        return $this->model->with('agreement_list_code.generate_code', 'hris_masterlist', 'designer_section_answer', 'attachment')
            ->whereHas('agreement_list_code', function ($q) {
            })
            ->get();
    }
    public function loadWithNoCodeRequest()
    {
        return $this->model->with('agreement_list_code.generate_code', 'hris_masterlist')
            ->doesntHave('agreement_list_code')

            ->get();
    }
    public function show($id, $where, $with, $whereHas)
    {
        return $this->model->with($with)->where($where)
            // ->whereHas($whereHas, function ($q) {
            // })
            ->get();
    }
    public function loadInspectionData()
    {
        return $this->model->with('agreement_list')->get();
    }
    public function loadCodeWithInspectionData()
    {
        return $this->model->with('agreement_list_code.generate_code', 'hris_masterlist', 'inspection_data')
            ->where(([['critical_parts', '=', 'Yes']]))
            ->whereHas('agreement_list_code', function ($q) {
            })
            ->get();
    }
    public function loadMonitoringList()
    {
        return $this->model->with('agreement_list_code', 'designer_section_answer', 'units')
            ->whereHas('designer_section_answer', function ($q) {
            })
            ->get();
    }
    public function loadCountResult($data)
    {
        return $this->model->with('designer_section_answer')
            // ->whereHas('designer_section_answer', function ($q) use ($data) {
                ->whereBetween('created_at', ["{$data['date_from']} 00:00:00", "{$data['date_to']} 24:00:00"])
            // })
            // ->orWhereDoesntHave('designer_section_answer', function ($q) use ($data) {
            //     $q->whereBetween('created_at', ["{$data['date_from']} ", "{$data['date_to']} "]);
            // })
            ->get();
    }
    //     public function loadCountResult()
    //     {
    //         return $this->model->with('designer_section_answer')
    //             // ->whereBetween('created_at', [$data['date_from'], $data['date_to']])
    //             ->get();
    //     }
    // }
}
