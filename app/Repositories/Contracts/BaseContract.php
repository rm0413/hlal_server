<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function loadAll();
    public function loadUserProfile();
    public function store($data);
    public function showProfile($id);
    public function update($id, $data);
    public function updateUserPortal($id, $data);
    public function delete($id);
    public function loadUnits();
    public function loadAgreementListRequest();
    public function loadGenaratedAgreementCode();
    public function loadWithCodeRequest();
    public function loadWithNoCodeRequest();
    public function show($id, $where, $with);
    public function loadInspectionData();
}
