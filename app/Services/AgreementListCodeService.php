<?php

namespace App\Services;

use App\Repositories\Contracts\AgreementListCodeRepositoryContract;
use App\Services\Contracts\AgreementListCodeServiceContract;
use Carbon\Carbon;

class AgreementListCodeService implements AgreementListCodeServiceContract
{

    protected $agreement_list_code_contract;
    public function __construct(AgreementListCodeRepositoryContract $agreement_list_code_contract)
    {
        $this->agreement_list_code_contract = $agreement_list_code_contract;
    }
    public function store($data)
    {
        return $this->agreement_list_code_contract->store($data);
    }
    public function loadGenaratedAgreementCode()
    {
        return $this->agreement_list_code_contract->loadGenaratedAgreementCode();
    }
    public function show($id, $where, $with)
    {
        $result =  $this->agreement_list_code_contract->show($id, $where, $with);
        $datastorage = [];
        foreach ($result as $data) {
            foreach ($data->agreement_list as $data_agreement_list) {
                $datastorage[] = [
                    'agreement_code_id_pk' => $data['id'],
                    'agreement_request_id_fk' => $data['agreement_request_id'],
                    'code_id_fk' => $data['code_id'],
                    'code_id_pk' => $data->generate_code['id'],
                    'code' => $data->generate_code['code'],
                    'trial_number' => $data_agreement_list['trial_number'],
                    'request_date' => Carbon::parse($data_agreement_list['request_date'])->toDateString(),
                    'additional_request_qty_date' =>  Carbon::parse($data_agreement_list['additional_request_qty_date'])->toDateString(),
                    'tri_number' => $data_agreement_list['tri_number'],
                    'tri_quantity' => $data_agreement_list['tri_quantity'],
                    'request_person' => $data_agreement_list['request_person'],
                    'superior_approval' => $data_agreement_list['superior_approval'],
                    'supplier_name' => $data_agreement_list['supplier_name'],
                    'part_number' => $data_agreement_list['part_number'],
                    'sub_part_number' => $data_agreement_list['sub_part_number'],
                    'revision' => $data_agreement_list['revision'],
                    'coordinates' => $data_agreement_list['coordinates'],
                    'dimension' => $data_agreement_list['dimension'],
                    'actual_value' => $data_agreement_list['actual_value'],
                    'critical_parts' => $data_agreement_list['critical_parts'],
                    'critical_dimension' => $data_agreement_list['critical_dimension'],
                    'request_type' => $data_agreement_list['request_type'],
                    'request_value' => $data_agreement_list['request_value'],
                    'request_quantity' => $data_agreement_list['request_quantity'],
                    'unit_id' => $data_agreement_list['unit_id'],
                    'requestor_employee_id' => $data_agreement_list['requestor_employee_id'],
                ];
            }
        }
        return $datastorage;
    }
}
