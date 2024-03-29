<?php

namespace App\Services;

use App\Services\Contracts\UnitServiceContract;
use App\Repositories\Contracts\UnitRepositoryContract;
use Carbon\Carbon;
class UnitService implements UnitServiceContract
{

    protected $unit_repository_contract;

    public function __construct(UnitRepositoryContract $unit_repository_contract)
    {
        $this->unit_repository_contract = $unit_repository_contract;
    }

    public function loadUnits()
    {
        $result = $this->unit_repository_contract->loadUnits();
        $datastorage = [];
        foreach ($result as $unit_data) {
            $datastorage[] = [
                'unit_id' => $unit_data['id'],
                'unit_name' => $unit_data['unit_name'],
                'unit_created_date' => Carbon::parse($unit_data['created_at'])->format('m-d-Y H:i:s'),
                'emp_full_name' => "{$unit_data->hris_masterlist['emp_first_name']} {$unit_data->hris_masterlist['emp_last_name']}",
                'position' => $unit_data->hris_masterlist['position'],
                'section_code' => $unit_data->hris_masterlist['section_code'],
                'emp_email' => $unit_data->fdtp_portal_user['email'],
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function store($data)
    {
        return $this->unit_repository_contract->store($data);
    }
    public function delete($id)
    {
        return $this->unit_repository_contract->delete($id);
    }
    public function update($id, $data)
    {
        return $this->unit_repository_contract->update($id, $data);
    }
    public function show($id, $where, $with)
    {
        return $this->unit_repository_contract->show($id, $where, $with);
    }
}
