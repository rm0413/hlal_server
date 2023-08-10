<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\EmployeeNotificationService;

class EmployeeNotification extends Controller
{
    use ResponseTrait;
    protected $employee_notification_service;
    public function __construct(EmployeeNotificationService $employee_notification_service)
    {
        $this->employee_notification_service = $employee_notification_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($emp_id, Request $request)
    {
        $result = $this->successResponse('Updated Successfully');
        try {
            $data = [
                'recieve_notification' => $request->recieve_notification,
            ];
            $result['data'] = $this->employee_notification_service->updateEmail($emp_id, $data);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog("Successfully Updated Email Notification", $request->emp_id,  $result["status"]);
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
        //
    }
}
