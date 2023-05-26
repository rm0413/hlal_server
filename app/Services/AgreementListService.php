<?php

namespace App\Services;

use App\Services\Contracts\AgreementListServiceContract;
use App\Repositories\Contracts\AgreementListRepositoryContract;
use Carbon\Carbon;

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
    public function loadWithNoCodeRequest()
    {
        $result =  $this->agreement_list_contract->loadWithNoCodeRequest();
        $datastorage = [];
        foreach($result as $data_with_code){
            $datastorage[] = [
                "agreement_id_pk" => $data_with_code["id"],
                'trial_number' => $data_with_code['trial_number'],
                'request_date' => Carbon::parse( $data_with_code['request_date'])->format('Y/m/d'),
                'additional_request_qty_date' =>  Carbon::parse($data_with_code['additional_request_qty_date'])->format('Y/m/d'),
                'tri_number' => $data_with_code['tri_number'],
                'tri_quantity' => $data_with_code['tri_quantity'],
                'request_person' => $data_with_code['request_person'],
                'superior_approval' => $data_with_code['superior_approval'],
                'supplier_name' => $data_with_code['supplier_name'],
                'part_number' => $data_with_code['part_number'],
                'sub_part_number' => $data_with_code['sub_part_number'],
                'revision' => $data_with_code['revision'],
                'coordinates' => $data_with_code['coordinates'],
                'dimension' => $data_with_code['dimension'],
                'actual_value' => $data_with_code['actual_value'],
                'critical_parts' => $data_with_code['critical_parts'],
                'critical_dimension' => $data_with_code['critical_dimension'],
                'request_type' => $data_with_code['request_type'],
                'request_value' => $data_with_code['request_value'],
                'request_quantity' => $data_with_code['request_quantity'],
                'unit_id' => $data_with_code['unit_id'],
                'requestor_employee_id' => $data_with_code['requestor_employee_id'],
                'requestor_full_name' => "{$data_with_code->hris_masterlist['emp_first_name']} {$data_with_code->hris_masterlist['emp_last_name']}",
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadWithCodeRequest()
    {
        $result = $this->agreement_list_contract->loadWithCodeRequest();
        $datastorage = [];
        foreach($result as $data_with_code){
            $datastorage[] = [
                "agreement_id_pk" => $data_with_code["id"],
                'trial_number' => $data_with_code['trial_number'],
                'request_date' => Carbon::parse( $data_with_code['request_date'])->toDateString(),
                'additional_request_qty_date' =>  Carbon::parse($data_with_code['additional_request_qty_date'])->toDateString(),
                'tri_number' => $data_with_code['tri_number'],
                'tri_quantity' => $data_with_code['tri_quantity'],
                'request_person' => $data_with_code['request_person'],
                'superior_approval' => $data_with_code['superior_approval'],
                'supplier_name' => $data_with_code['supplier_name'],
                'part_number' => $data_with_code['part_number'],
                'sub_part_number' => $data_with_code['sub_part_number'],
                'revision' => $data_with_code['revision'],
                'coordinates' => $data_with_code['coordinates'],
                'dimension' => $data_with_code['dimension'],
                'actual_value' => $data_with_code['actual_value'],
                'critical_parts' => $data_with_code['critical_parts'],
                'critical_dimension' => $data_with_code['critical_dimension'],
                'request_type' => $data_with_code['request_type'],
                'request_value' => $data_with_code['request_value'],
                'request_quantity' => $data_with_code['request_quantity'],
                'unit_id' => $data_with_code['unit_id'],
                'requestor_employee_id' => $data_with_code['requestor_employee_id'],
                'requestor_full_name' => "{$data_with_code->hris_masterlist['emp_first_name']} {$data_with_code->hris_masterlist['emp_last_name']}",
                'agreement_list_code_id_pk' => $data_with_code->agreement_list_code['id'],
                'agreement_request_id_fk' => $data_with_code->agreement_list_code['agreement_request_id'],
                'code_id_fk' => $data_with_code->agreement_list_code['code_id'],
                'generate_code_id_pk' => $data_with_code->agreement_list_code->generate_code['id'],
                'code' => $data_with_code->agreement_list_code->generate_code['code'],
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadAgreementListRequest()
    {
        $result = $this->agreement_list_contract->loadAgreementListRequest();
        $datastorage = [];
        foreach ($result as $agreement_data) {
            $datastorage[] = [
                "agreement_id" => $agreement_data["id"],
                'trial_number' => $agreement_data['trial_number'],
                'request_date' =>  Carbon::parse($agreement_data['request_date'])->toDateString(),
                'additional_request_qty_date' =>  Carbon::parse($agreement_data['additional_request_qty_date'])->toDateString(),
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
        rsort($datastorage);
        return $datastorage;
    }
}
