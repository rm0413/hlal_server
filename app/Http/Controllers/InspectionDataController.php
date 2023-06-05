<?php

namespace App\Http\Controllers;

use App\Http\Requests\InspectionDataRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\InspectionDataService;

class InspectionDataController extends Controller
{
    use ResponseTrait;
    protected $inspection_data_service;
    public function __construct(InspectionDataService $inspection_data_service)
    {
        $this->inspection_data_service = $inspection_data_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->inspection_data_service->loadInspectionData();
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
    public function store(InspectionDataRequest $request)
    {
        $result = $this->successResponse("Stored Successfully");
        try {
            foreach ($request->agreement_request_id as $agreement_req_id) {
                $data = [
                    'agreement_request_id' => $agreement_req_id,
                    'cpk_data' => $request->cpk_data,
                    'inspection_after_rework' => $request->inspection_after_rework,
                    'revised_date_igm' => $request->revised_date_igm,
                    'sent_date_igm' => $request->sent_date_igm
                ];
                $result['data'] = $this->inspection_data_service->store($data);
            }
        } catch (\Exception $e) {
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
    public function update(Request $request, $id)
    {
        //
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
