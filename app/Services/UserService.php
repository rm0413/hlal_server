<?php

namespace App\Services;

use App\Services\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\ActivityLogRepositoryContract;

class UserService implements UserServiceContract
{

    protected $user_repository_contract;
    protected $logActivity;

    public function __construct(UserRepositoryContract $user_repository_contract , ActivityLogRepositoryContract $logActivity)
    {
        $this->user_repository_contract = $user_repository_contract;
        $this->logActivity = $logActivity;

    }
    public function loadActivityLogs($data)
    {
        $load_activity_logs = $this->logActivity->loadActivityLogs($data);

        $activity_logs = [];

        foreach ($load_activity_logs as $load_activity_log)
        {
            $activity_logs[] =
            [
                'id'            =>  $load_activity_log->id,
                'picture'       =>  $load_activity_log->hris_masterlist['emp_photo'],
                'name'          =>  $load_activity_log->hris_masterlist['emp_first_name'] . ' ' . $load_activity_log->hris_masterlist['emp_middle_name'] . ' ' . $load_activity_log->hris_masterlist['emp_last_name'],
                'ip'            =>  $load_activity_log->ip,
                'subject'       =>  $load_activity_log->subject,
                'status'        =>  $load_activity_log->status,
                'url'           =>  $load_activity_log->url,
                'method'        =>  $load_activity_log->method,
                'agent'         =>  $load_activity_log->agent,
                'created_at'    =>  date('m-d-Y h:i:s', strtotime($load_activity_log->created_at)),
            ];
        }
        return $activity_logs;
    }
    public function loadAll()
    {
        return $this->user_repository_contract->loadAll();
    }
    public function loadUserProfile()
    {
        $result = $this->user_repository_contract->loadUserProfile();
        $datastorage = [];
        foreach($result as $users){
            $datastorage[] = [
                'user_id' => $users['id'],
                'emp_id' => $users['employee_id'],
                'role_access' => $users['role_access'],
                'emp_first_name' => $users->hris_masterlist['emp_first_name'],
                'emp_last_name' => $users->hris_masterlist['emp_last_name'],
                'emp_middle_name' => $users->hris_masterlist['emp_middle_name'],
                'emp_photo' => $users->hris_masterlist['emp_photo'],
                'emp_system_status' => $users->hris_masterlist['emp_system_status'],
                'position' => $users->hris_masterlist['position'],
                'section_code' => $users->hris_masterlist['section_code'],
                'emp_email' => $users->fdtp_portal_user['email'],
            ];
        }

        return $datastorage;
    }
    public function store($data)
    {
        return $this->user_repository_contract->store($data);
    }
    public function showProfile($id)
    {
        $result = $this->user_repository_contract->showProfile($id);
        $datastorage = [];
        // foreach($result as $users){
            $datastorage = [
                'id' => $result['id'],
                'employee_id' => $result['employee_id'],
                'role_access' => $result['role_access'],
                'first_name' => $result->hris_masterlist['emp_first_name'],
                'last_name' => $result->hris_masterlist['emp_last_name'],
                'middle_name' => $result->hris_masterlist['emp_middle_name'],
                'photo' => $result->hris_masterlist['emp_photo'],
                'employee_status' => $result->hris_masterlist['emp_system_status'],
                'position' => $result->hris_masterlist['position'],
                "section" =>  $result["hris_masterlist"]["section"],
                'section_code' => $result->hris_masterlist['section_code'],
                'email' => $result->fdtp_portal_user['email'],
            ];
        // }
        rsort($datastorage);
        return $datastorage;
    }
    public function update($id, $data){
        return $this->user_repository_contract->update($id, $data);
    }
    public function updateUserPortal($id, $data){
        return $this->user_repository_contract->updateUserPortal($id, $data);
    }
    public function delete($id)
    {
        return $this->user_repository_contract->delete($id);
    }
}
