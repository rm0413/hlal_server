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
    public function show($id, $where, $with)
    {
        return $this->agreement_list_contract->show($id, $where, $with);
    }
    public function loadTaskToDo()
    {
        $request_data = $this->agreement_list_contract->loadCodeWithInspectionData();
        $generate_data = $this->agreement_list_contract->loadWithCodeRequest();
        $inspection_data = $this->agreement_list_contract->loadCodeWithInspectionData();
        $datastorage = [
            'request_generate_data' => ['part_number' => $request_data, 'total_count' => count($request_data)],
            'designer_data' => ['part_number' => $generate_data, 'total_count' => count($generate_data)],
            'inspection_data' => ['part_number' => $inspection_data, 'total_count' => count($inspection_data)]
        ];

        return $datastorage;
    }
    public function loadWithNoCodeRequest()
    {
        $result =  $this->agreement_list_contract->loadWithNoCodeRequest();
        $datastorage = [];
        foreach ($result as $data_with_code) {
            $datastorage[] = [
                "agreement_id_pk" => $data_with_code["id"],
                'trial_number' => $data_with_code['trial_number'],
                'request_date' => $data_with_code['request_date'] ? Carbon::parse($data_with_code['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $data_with_code['additional_request_qty_date'] ? Carbon::parse($data_with_code['additional_request_qty_date'])->toDateString() : "",
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
        foreach ($result as $data_with_code) {
            $datastorage[] = [
                "agreement_id_pk" => $data_with_code["id"],
                'trial_number' => $data_with_code['trial_number'],
                'request_date' => $data_with_code['request_date'] ? Carbon::parse($data_with_code['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $data_with_code['additional_request_qty_date'] ? Carbon::parse($data_with_code['additional_request_qty_date'])->toDateString() : "",
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
                'request_date' =>  $agreement_data['request_date'] ? Carbon::parse($agreement_data['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $agreement_data['additional_request_qty_date'] ? Carbon::parse($agreement_data['additional_request_qty_date'])->toDateString() : "",
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
    public function update($id, $data)
    {
        return $this->agreement_list_contract->update($id, $data);
    }

    public function delete($id)
    {
        return $this->agreement_list_contract->delete($id);
    }
    public function loadCodeWithInspectionData()
    {
        $result = $this->agreement_list_contract->loadCodeWithInspectionData();
        $datastorage = [];
        foreach ($result as $data_code_with_inspection) {
            $datastorage[] = [
                "agreement_id_pk" => $data_code_with_inspection["id"],
                'trial_number' => $data_code_with_inspection['trial_number'],
                'request_date' => $data_code_with_inspection['request_date'] ? Carbon::parse($data_code_with_inspection['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $data_code_with_inspection['additional_request_qty_date'] ? Carbon::parse($data_code_with_inspection['additional_request_qty_date'])->toDateString() : "",
                'tri_number' => $data_code_with_inspection['tri_number'],
                'tri_quantity' => $data_code_with_inspection['tri_quantity'],
                'request_person' => $data_code_with_inspection['request_person'],
                'superior_approval' => $data_code_with_inspection['superior_approval'],
                'supplier_name' => $data_code_with_inspection['supplier_name'],
                'part_number' => $data_code_with_inspection['part_number'],
                'sub_part_number' => $data_code_with_inspection['sub_part_number'],
                'revision' => $data_code_with_inspection['revision'],
                'coordinates' => $data_code_with_inspection['coordinates'],
                'dimension' => $data_code_with_inspection['dimension'],
                'actual_value' => $data_code_with_inspection['actual_value'],
                'critical_parts' => $data_code_with_inspection['critical_parts'],
                'critical_dimension' => $data_code_with_inspection['critical_dimension'],
                'request_type' => $data_code_with_inspection['request_type'],
                'request_value' => $data_code_with_inspection['request_value'],
                'request_quantity' => $data_code_with_inspection['request_quantity'],
                'unit_id' => $data_code_with_inspection['unit_id'],
                'requestor_employee_id' => $data_code_with_inspection['requestor_employee_id'],
                'requestor_full_name' => "{$data_code_with_inspection->hris_masterlist['emp_first_name']} {$data_code_with_inspection->hris_masterlist['emp_last_name']}",
                'agreement_list_code_id_pk' => $data_code_with_inspection->agreement_list_code['id'],
                'agreement_request_id_fk' => $data_code_with_inspection->agreement_list_code['agreement_request_id'],
                'code_id_fk' => $data_code_with_inspection->agreement_list_code['code_id'],
                'generate_code_id_pk' => $data_code_with_inspection->agreement_list_code->generate_code['id'],
                'code' => $data_code_with_inspection->agreement_list_code->generate_code['code'],
                'inspection_id' => $data_code_with_inspection->inspection_data['id'],
                'cpk_data' => $data_code_with_inspection->inspection_data['cpk_data'],
                'inspection_after_rework' => $data_code_with_inspection->inspection_data['inspection_after_rework'],
                'revised_date_igm' => $data_code_with_inspection->inspection_data['revised_date_igm'] ? Carbon::parse($data_code_with_inspection->inspection_data['revised_date_igm'])->toDateString() : "",
                'sent_date_igm' => $data_code_with_inspection->inspection_data['sent_date_igm'] ? Carbon::parse($data_code_with_inspection->inspection_data['sent_date_igm'])->toDateString() : "",
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadCodeWithDesignerSection()
    {
        $result = $this->agreement_list_contract->loadWithCodeRequest();
        $datastorage = [];
        foreach ($result as $data_code_designer) {
            $datastorage[] = [
                "agreement_id_pk" => $data_code_designer["id"],
                'trial_number' => $data_code_designer['trial_number'],
                'request_date' => $data_code_designer['request_date'] ? Carbon::parse($data_code_designer['request_date'])->toDateString() : null,
                'additional_request_qty_date' =>  $data_code_designer['additional_request_qty_date'] ? Carbon::parse($data_code_designer['additional_request_qty_date'])->toDateString() : null,
                'tri_number' => $data_code_designer['tri_number'],
                'tri_quantity' => $data_code_designer['tri_quantity'],
                'request_person' => $data_code_designer['request_person'],
                'superior_approval' => $data_code_designer['superior_approval'],
                'supplier_name' => $data_code_designer['supplier_name'],
                'part_number' => $data_code_designer['part_number'],
                'sub_part_number' => $data_code_designer['sub_part_number'],
                'revision' => $data_code_designer['revision'],
                'coordinates' => $data_code_designer['coordinates'],
                'dimension' => $data_code_designer['dimension'],
                'actual_value' => $data_code_designer['actual_value'],
                'critical_parts' => $data_code_designer['critical_parts'],
                'critical_dimension' => $data_code_designer['critical_dimension'],
                'request_type' => $data_code_designer['request_type'],
                'request_value' => $data_code_designer['request_value'],
                'request_quantity' => $data_code_designer['request_quantity'],
                'unit_id' => $data_code_designer['unit_id'],
                'requestor_employee_id' => $data_code_designer['requestor_employee_id'],
                'requestor_full_name' => "{$data_code_designer->hris_masterlist['emp_first_name']} {$data_code_designer->hris_masterlist['emp_last_name']}",
                'agreement_list_code_id_pk' => $data_code_designer->agreement_list_code['id'],
                'agreement_request_id_fk' => $data_code_designer->agreement_list_code['agreement_request_id'],
                'code_id_fk' => $data_code_designer->agreement_list_code['code_id'],
                'generate_code_id_pk' => $data_code_designer->agreement_list_code->generate_code['id'],
                'code' => $data_code_designer->agreement_list_code->generate_code['code'],
                'inspection_id' => $data_code_designer->inspection_data['id'],
                'cpk_data' => $data_code_designer->inspection_data['cpk_data'],
                'inspection_after_rework' => $data_code_designer->inspection_data['inspection_after_rework'],
                'revised_date_igm' => $data_code_designer->inspection_data['revised_date_igm'] ? Carbon::parse($data_code_designer->inspection_data['revised_date_igm'])->toDateString() : "",
                'sent_date_igm' => $data_code_designer->inspection_data['sent_date_igm'] ? Carbon::parse($data_code_designer->inspection_data['sent_date_igm'])->toDateString() : "",
                'designer_section_id' => $data_code_designer->designer_section_answer['id'],
                'designer_answer' => $data_code_designer->designer_section_answer['designer_answer'],
                'designer_in_charge' => $data_code_designer->designer_section_answer['designer_in_charge'],
                'answer_date' => $data_code_designer->designer_section_answer['answer_date'] ? Carbon::parse($data_code_designer->designer_section_answer['answer_date'])->toDateString() : "",
                'request_result' => $data_code_designer->designer_section_answer['request_result'],
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadWithCodeAttachment()
    {
        $result = $this->agreement_list_contract->loadWithCodeRequest();
        $datastorage = [];
        foreach ($result as $data_code_attachement) {
            $datastorage[] = [
                "agreement_id_pk" => $data_code_attachement["id"],
                'trial_number' => $data_code_attachement['trial_number'],
                'request_date' => $data_code_attachement['request_date'] ? Carbon::parse($data_code_attachement['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $data_code_attachement['additional_request_qty_date'] ? Carbon::parse($data_code_attachement['additional_request_qty_date'])->toDateString() : "",
                'tri_number' => $data_code_attachement['tri_number'],
                'tri_quantity' => $data_code_attachement['tri_quantity'],
                'request_person' => $data_code_attachement['request_person'],
                'superior_approval' => $data_code_attachement['superior_approval'],
                'supplier_name' => $data_code_attachement['supplier_name'],
                'part_number' => $data_code_attachement['part_number'],
                'sub_part_number' => $data_code_attachement['sub_part_number'],
                'revision' => $data_code_attachement['revision'],
                'coordinates' => $data_code_attachement['coordinates'],
                'dimension' => $data_code_attachement['dimension'],
                'actual_value' => $data_code_attachement['actual_value'],
                'critical_parts' => $data_code_attachement['critical_parts'],
                'critical_dimension' => $data_code_attachement['critical_dimension'],
                'request_type' => $data_code_attachement['request_type'],
                'request_value' => $data_code_attachement['request_value'],
                'request_quantity' => $data_code_attachement['request_quantity'],
                'unit_id' => $data_code_attachement['unit_id'],
                'requestor_employee_id' => $data_code_attachement['requestor_employee_id'],
                'requestor_full_name' => "{$data_code_attachement->hris_masterlist['emp_first_name']} {$data_code_attachement->hris_masterlist['emp_last_name']}",
                'agreement_list_code_id_pk' => $data_code_attachement->agreement_list_code['id'],
                'agreement_request_id_fk' => $data_code_attachement->agreement_list_code['agreement_request_id'],
                'code_id_fk' => $data_code_attachement->agreement_list_code['code_id'],
                'generate_code_id_pk' => $data_code_attachement->agreement_list_code->generate_code['id'],
                'code' => $data_code_attachement->agreement_list_code->generate_code['code'],
                'attachement_id' => $data_code_attachement->attachment['id'],
                'file_path_attachment' => $data_code_attachement->attachment['file_path_attachment'],
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadPartNumberWithCritical()
    {
        $result = $this->agreement_list_contract->loadCodeWithInspectionData();
        $part_number = [];
        foreach ($result as $results) {
            $part_number[] = $results->part_number;
        }
        foreach (array_unique($part_number) as $load_part_number) {
            $datastorage[] = $load_part_number;
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadPartNumberWithCode()
    {
        $result = $this->agreement_list_contract->loadWithCodeRequest();
        $part_number = [];
        foreach ($result as $results) {
            $part_number[] = $results->part_number;
        }
        foreach (array_unique($part_number) as $load_part_number) {
            $datastorage[] = $load_part_number;
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function countRequest($data)
    {
        $result = $this->agreement_list_contract->countRequest($data);
        $hinsei_count = 0;
        $lsa_count = 0;
        $lsa_ok = 0;
        $lsa_ng = 0;
        $lsa_pending = 0;
        $hinsei_ok = 0;
        $hinsei_ng = 0;
        $hinsei_pending = 0;

        foreach ($result as $data_request) {
            if ($data_request["request_type"] === "LSA Request") {
                $lsa_count += 1;
                if ($data_request["designer_section_answer"]["request_result"] === "LSA OK") {
                    $lsa_ok += 1;
                } elseif ($data_request["designer_section_answer"]["request_result"] === "LSA NG") {
                    $lsa_ng += 1;
                } else {
                    $lsa_pending += 1;
                }
            } else {
                $hinsei_count += 1;
                if ($data_request["designer_section_answer"]["request_result"] === "Hinsei OK") {
                    $hinsei_ok += 1;
                } elseif ($data_request["designer_section_answer"]["request_result"] === "Hinsei NG") {
                    $hinsei_ng += 1;
                } else {
                    $hinsei_pending += 1;
                }
            }
        }
        $datastorage_count[] = [
            'count_lsa' => $lsa_count,
            'lsa_ok' => $lsa_ok,
            'lsa_ng' => $lsa_ng,
            'lsa_pending' => $lsa_pending,
            'hinsei_count' => $hinsei_count,
            'hinsei_ok' => $hinsei_ok,
            'hinsei_ng' => $hinsei_ng,
            'hinsei_pending' => $hinsei_pending,

        ];
        return $datastorage_count;
    }
    public function loadMonitoringList()
    {
        $result =  $this->agreement_list_contract->loadMonitoringList();
        $datastorage = [];
        $result_data = [];
        foreach ($result as $data_monitoring) {
            $datastorage[] = [
                'agreement_list_id' => $data_monitoring['id'],
                'supplier_name' => $data_monitoring['supplier_name'],
                'part_number' => $data_monitoring['part_number'],
                'unit_name' => $data_monitoring->units['unit_name'],
            ];
        }
        $result_data = array_unique($datastorage, SORT_REGULAR);
        return $result_data;
    }
    public function showWhereHas($id, $where, $with, $whereHas)
    {
        $result = $this->agreement_list_contract->showWhereHas($id, $where, $with, $whereHas);
        $datastorage = [];
        $result_data = [];
        foreach ($result as $data_monitoring) {
            $datastorage[] = [
                'unit_id' => $data_monitoring['unit_id'],
                'supplier_name' => $data_monitoring['supplier_name'],
                'part_number' => $data_monitoring['part_number'],
                'unit_name' => $data_monitoring->units['unit_name'],
            ];
        }
        $result_data = array_unique($datastorage, SORT_REGULAR);
        return $result_data;
    }
    public function showMonitoringList($id, $where, $with, $whereHas)
    {
        $result = $this->agreement_list_contract->showWhereHas($id, $where, $with, $whereHas);
        $datastorage = [];

        foreach ($result as $data_monitoring_list) {
            $datastorage[] = [
                "agreement_id_pk" => $data_monitoring_list["id"],
                'trial_number' => $data_monitoring_list['trial_number'],
                'request_date' => $data_monitoring_list['request_date'] ? Carbon::parse($data_monitoring_list['request_date'])->toDateString() : "",
                'additional_request_qty_date' =>  $data_monitoring_list['additional_request_qty_date'] ? Carbon::parse($data_monitoring_list['additional_request_qty_date'])->toDateString() : "",
                'tri_number' => $data_monitoring_list['tri_number'],
                'tri_quantity' => $data_monitoring_list['tri_quantity'],
                'request_person' => $data_monitoring_list['request_person'],
                'superior_approval' => $data_monitoring_list['superior_approval'],
                'supplier_name' => $data_monitoring_list['supplier_name'],
                'part_number' => $data_monitoring_list['part_number'],
                'sub_part_number' => $data_monitoring_list['sub_part_number'],
                'revision' => $data_monitoring_list['revision'],
                'coordinates' => $data_monitoring_list['coordinates'],
                'dimension' => $data_monitoring_list['dimension'],
                'actual_value' => $data_monitoring_list['actual_value'],
                'critical_parts' => $data_monitoring_list['critical_parts'],
                'critical_dimension' => $data_monitoring_list['critical_dimension'],
                'request_type' => $data_monitoring_list['request_type'],
                'request_value' => $data_monitoring_list['request_value'],
                'request_quantity' => $data_monitoring_list['request_quantity'],
                'unit_id' => $data_monitoring_list['unit_id'],
                'unit_name' => $data_monitoring_list->units['unit_name'],
                'requestor_employee_id' => $data_monitoring_list['requestor_employee_id'],
                'requestor_full_name' => "{$data_monitoring_list->hris_masterlist['emp_first_name']} {$data_monitoring_list->hris_masterlist['emp_last_name']}",
                'agreement_list_code_id_pk' => $data_monitoring_list->agreement_list_code['id'],
                'agreement_request_id_fk' => $data_monitoring_list->agreement_list_code['agreement_request_id'],
                'code_id_fk' => $data_monitoring_list->agreement_list_code['code_id'],
                'generate_code_id_pk' => $data_monitoring_list->agreement_list_code->generate_code['id'],
                'code' => $data_monitoring_list->agreement_list_code->generate_code['code'],
                'inspection_id' => $data_monitoring_list->inspection_data['id'],
                'cpk_data' => $data_monitoring_list->inspection_data['cpk_data'],
                'inspection_after_rework' => $data_monitoring_list->inspection_data['inspection_after_rework'],
                'revised_date_igm' => $data_monitoring_list->inspection_data['revised_date_igm'] ? Carbon::parse($data_monitoring_list->inspection_data['revised_date_igm'])->toDateString() : "",
                'sent_date_igm' => $data_monitoring_list->inspection_data['sent_date_igm'] ? Carbon::parse($data_monitoring_list->inspection_data['sent_date_igm'])->toDateString() : "",
                'designer_section_id' => $data_monitoring_list->designer_section_answer['id'],
                'designer_answer' => $data_monitoring_list->designer_section_answer['designer_answer'],
                'designer_in_charge' => $data_monitoring_list->designer_section_answer['designer_in_charge'],
                'answer_date' => $data_monitoring_list->designer_section_answer['answer_date'] ? Carbon::parse($data_monitoring_list->designer_section_answer['answer_date'])->toDateString() : "",
                'request_result' => $data_monitoring_list->designer_section_answer['request_result'],
                'attachement_id' => $data_monitoring_list->attachment['id'],
                'file_path_attachment' => $data_monitoring_list->attachment['file_path_attachment'],
            ];
        }
        rsort($datastorage);
        return $datastorage;
    }
    public function loadCountResult($data)
    {
        $result = $this->agreement_list_contract->loadCountResult($data);
        $hinsei_ok = 0;
        $hinsei_ng = 0;
        $lsa_request_count = 0;
        $lsa_ok = 0;
        $lsa_request_count = 0;
        $hinsei_request_count = 0;
        $lsa_ng = 0;
        $hinsei_request_count = 0;
        $lsa_request_pending = 0;
        $hinsei_request_pending = 0;

        foreach ($result as $data_request_result) {
            if ($data_request_result['request_type'] === 'LSA Request') {
                $lsa_request_count += 1;
                if ($data_request_result['designer_section_answer']['request_result'] === "LSA OK") {
                    $lsa_ok += 1;
                } elseif ($data_request_result['designer_section_answer']['request_result'] === "LSA NG") {
                    $lsa_ng += 1;
                } else {
                    $lsa_request_pending += 1;
                }
            } else {
                $hinsei_request_count += 1;
                if ($data_request_result['designer_section_answer']['request_result'] === "Hinsei OK") {
                    $hinsei_ok += 1;
                } elseif ($data_request_result['designer_section_answer']['request_result'] === "Hinsei NG") {
                    $hinsei_ng += 1;
                } else {
                    $hinsei_request_pending += 1;
                }
            }
        }

        $datastorage_count_request[] = [
            'hinsei' => [
                $hinsei_ok, $hinsei_ng, $hinsei_request_pending
            ],
            'lsa' => [
                $lsa_ok, $lsa_ng, $lsa_request_pending
            ],
            'hinsei_request' => $hinsei_request_count,
            'lsa_request' => $lsa_request_count,
        ];

        return $datastorage_count_request;
    }
}
