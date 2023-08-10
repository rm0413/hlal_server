<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use App\Http\Requests\UserRequest;
use Error\Exception;
use App\Services\EmployeeNotificationService;

class UserController extends Controller
{
    use ResponseTrait;
    protected $user_service;
    protected $employee_notification_service;

    public function __construct(UserService $user_service, EmployeeNotificationService $employee_notification_service)
    {
        $this->user_service = $user_service;
        $this->employee_notification_service = $employee_notification_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse("Loaded Successfully");
        try {
            $result["data"] = $this->user_service->loadUserProfile();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result = $this->successResponse("User Added Successfully.");
        try {
            $data = [
                'employee_id' => $request->employee_id,
                'role_access' => $request->role_access
            ];
            $datastorage = [
                'emp_id' => $data['employee_id']
            ];
            $this->user_service->store($data);
            $this->employee_notification_service->store($datastorage);

        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog($result["message"], $request->employee_id,  $result["status"]);

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->successResponse('Loaded Successfully');
        try {
            $result['data'] = $this->user_service->showProfile($id);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $result = $this->successResponse('Updated Successfully!');
        try {
            $data = [
                'employee_id' => $request->employee_id,
                'role_access' => $request->role_access,
            ];
            $this->user_service->updateUserPortal($id, $data);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->successResponse('Deleted Successfully!');
        try {
            $this->user_service->delete($id);
        } catch (\Exception $e) {

            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadActivityLogs()
    {
        $result = $this->successResponse("Activitiy Logs Loaded Successfully", 200);
        try {
            $result["data"] = $this->user_service->loadActivityLogs();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $this->returnResponse($result);
    }
}
