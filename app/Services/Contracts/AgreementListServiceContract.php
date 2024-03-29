<?php

namespace App\Services\Contracts;

interface AgreementListServiceContract
{
    public function store($data);
    public function loadWithCodeRequest();
    public function loadWithNoCodeRequest();
    public function loadTaskToDo();
    public function update($id, $data);
    public function delete($id);
    public function loadCodeWithInspectionData();
    public function loadWithCodeAttachment();
    public function loadMonitoringList();
    public function loadCountResult($data);
    public function countRequest($data);
    public function showWhereHas($id, $where, $with, $whereHas);
    public function show($id, $where, $with);
    public function loadWithoutDesignerAnswer();
}
