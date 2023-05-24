<?php

namespace App\Services;

use App\Services\Contracts\AgreementListServiceContract;
use App\Repositories\Contracts\AgreementListRepositoryContract;

class AgreementListService implements AgreementListServiceContract
{
    protected $agreement_list_contract;
    public function __construct(AgreementListRepositoryContract $agreement_list_contract)
    {
        $this->agreement_list_contract = $agreement_list_contract;
    }
    public function store($data)
    {
        return $this->agreement_list_contract->store($data);
    }
    public function loadAgreementListRequest()
    {
        $result = $this->agreement_list_contract->loadAgreementListRequest();
        $datastorage = [];
        foreach ($result as $agreement_data) {
            $datastorage[] = [
                "agreement_id" => $agreement_data["id"],
                'trial_number' => $agreement_data['trial_number'],
                'request_date' => $agreement_data['request_date'],
                'additional_request_qty_date' => $agreement_data['additional_request_qty_date'],
                'tri_number' => $agreement_data['tri_number'],
                'tri_quantity' => $agreement_data['tri_quantity'],
                'request_person' => $agreement_data['request_person'],
                'superior_approval' => $agreement_data['superior_approval'],
                'supplier_name' => $agreement_data['supplier_name'],
                'part_number' => $agreement_data['part_number'],
                'sub_part_number' => $agreement_data['sub_part_number'],
                'revision' => $agreement_data['revision'],
                'coordinates' => $agreement_data['coordinates'],
                'dimension' => $agreement_data['dimension'],
                'actual_value' => $agreement_data['actual_value'],
                'critical_parts' => $agreement_data['critical_parts'],
                'critical_dimension' => $agreement_data['critical_dimension'],
                'request_type' => $agreement_data['request_type'],
                'request_value' => $agreement_data['request_value'],
                'request_quantity' => $agreement_data['request_quantity'],
                'unit_id' => $agreement_data['unit_id'],
                'unit_name' => $agreement_data->units['unit_name'],
                'unit_status' => $agreement_data->units['unit_status'],
                'unit_created_by' => $agreement_data->units['unit_created_by'],
                'requestor_employee_id' => $agreement_data['requestor_employee_id'],
                'requestor_full_name' => "{$agreement_data->hris_masterlist['emp_first_name']} {$agreement_data->hris_masterlist['emp_last_name']}",
            ];
        }
        return $datastorage;
    }
}
