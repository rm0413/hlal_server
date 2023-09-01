<?php

namespace App\Services;

use App\Services\Contracts\InspectionDataServiceContract;
use App\Repositories\Contracts\InspectionDataRepositoryContract;

class InspectionDataService implements InspectionDataServiceContract
{
    protected $inspection_data_repository_contract;
    public function __construct(InspectionDataRepositoryContract $inspection_data_repository_contract)
    {
        $this->inspection_data_repository_contract = $inspection_data_repository_contract;
    }
    public function store($data)
    {
        return $this->inspection_data_repository_contract->store($data);
    }
    public function loadInspectionData()
    {
        $result = $this->inspection_data_repository_contract->loadInspectionData();
        $datastorage = [];
        foreach ($result as $data_inspection) {
            foreach ($data_inspection->agreement_list as $data_agreement) {
                $datastorage[] = [
                    'inspection_id_pk' => $data_inspection['id'],
                    'agreement_request_id_fk' => $data_inspection['agreement_request_id'],
                    'cpk_data' => $data_inspection['cpk_data'],
                    'inspection_after_rework' => $data_inspection['inspection_after_rework'],
                    'revised_date_igm' => $data_inspection['revised_date_igm'],
                    'sent_date_igm' => $data_inspection['sent_date_igm'],
                    'agreement_id_pk' => $data_agreement['id'],
                    'trial_number' => $data_agreement['trial_number'],
                    'request_date' => $data_agreement['request_date'],
                    'additional_request_qty_date' => $data_agreement['additional_request_qty_date'],
                    'tri_number' => $data_agreement['tri_number'],
                    'tri_quantity' => $data_agreement['tri_quantity'],
                    'superior_approval' => $data_agreement['superior_approval'],
                    'request_person' => $data_agreement['request_person'],
                    'supplier_name' => $data_agreement['supplier_name'],
                    'part_number' => $data_agreement['part_number'],
                    'sub_part_number' => $data_agreement['sub_part_number'],
                    'revision' => $data_agreement['revision'],
                    'coordinates' => $data_agreement['coordinates'],
                    'dimension' => $data_agreement['dimension'],
                    'actual_value' => $data_agreement['actual_value'],
                    'critical_parts' => $data_agreement['critical_parts'],
                    'critical_dimension' => $data_agreement['critical_dimension'],
                    'request_type' => $data_agreement['request_type'],
                    'request_value' => $data_agreement['request_value'],
                    'request_quantity' => $data_agreement['request_quantity'],
                    'unit_id' => $data_agreement['unit_id'],
                    'requestor_employee_id' => $data_agreement['requestor_employee_id'],
                    'code' => $data_agreement['agreement_list_code']['generate_code']['code'],
                ];
            }
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function update($id, $data)
    {
        return $this->inspection_data_repository_contract->update($id, $data);
    }
}
