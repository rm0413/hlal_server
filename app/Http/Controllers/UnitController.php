<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\UnitService;

class UnitController extends Controller
{
    use ResponseTrait;

    protected $unit_service;
    public function __construct(UnitService $unit_service)
    {
        $this->unit_service = $unit_service;
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
            $result['data'] = $this->unit_service->loadUnits();
        } catch (\ErrorException $e) {
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
    public function store(UnitRequest $request)
    {
        $result = $this->successResponse("Added Successfully.");
        try {
            $data = [
                "unit_name" => $request["unit_name"],
                "unit_status" => $request["unit_status"],
                "unit_created_by" => $request["unit_created_by"]
            ];
            $this->unit_service->store($data);
        } catch (\Exception $e) {
            //throw $e;
            $result = $this->errorResponse($e);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $result = $this->successResponse("Updated Successfully.");
        try {
            $data = [
                "unit_name" => $request["unit_name"],
                "unit_status" => $request["unit_status"],
                "unit_created_by" => $request["unit_created_by"]
            ];
            $this->unit_service->update($id, $data);
        } catch (\Exception $e) {
            //throw $e;
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
        $result = $this->successResponse("Deleted Successfully");
        try {
            $result['data'] = $this->unit_service->delete($id);
        } catch (\ErrorException $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
}
