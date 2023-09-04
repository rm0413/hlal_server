<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function loadAll();
    public function loadUserProfile();
    public function store($data);
    public function showProfile($id);
    public function update($id, $data);
    public function updateMultiple($id, $data);
    public function updateUserPortal($id, $data);
    public function delete($id);
    public function loadUnits();
    public function loadAgreementListRequest();
    public function loadGenaratedAgreementCode();
    public function loadWithCodeRequest();
    public function loadWithNoCodeRequest();
    public function showWhereHas($id, $where, $with, $whereHas);
    public function show($id, $where, $with);
    public function loadCodeWithInspectionData();
    public function loadWithCodeAttachment();
    public function loadInspectionData();
    public function loadMonitoringList();
    public function loadCountResult($data);
    public function countRequest($data);
    public function countInspectionData();
    public function loadActivityLogs($data);
    public function loadTaskToDo();
    public function updateEmail($id, $data);
    public function loadWithoutDesignerAnswer();
}
