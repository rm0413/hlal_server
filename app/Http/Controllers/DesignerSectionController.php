<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignerSectionRequest;
use App\Services\DesignerSectionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DesignerSectionController extends Controller
{
    use ResponseTrait;
    protected $designer_answer_service;
    public function __construct(DesignerSectionService $designer_answer_service)
    {
        $this->designer_answer_service = $designer_answer_service;
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
    public function store(DesignerSectionRequest $request)
    {
        $result = $this->successResponse("Designer Section Answer Added Successfully.");
        try {
            foreach ($request->agreement_request_id as $agreement_id) {
                $data = [
                    'agreement_request_id' => $agreement_id,
                    'designer_answer' => $request["designer_answer"],
                    'designer_in_charge' => $request["designer_in_charge"],
                    'request_result' => $request["request_result"],
                    'answer_date' => $request["answer_date"],
                ];
                $this->designer_answer_service->store($data);
            }
        } catch (Exception $e) {
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
    public function update(DesignerSectionRequest $request, $id)
    {
        $result = $this->successResponse("Designer Section Answer Updated Successfully.");
        try {
            $data = [
                'designer_answer' => $request["designer_answer"],
                'designer_in_charge' => $request["designer_in_charge"],
                'request_result' => $request["request_result"],
                'answer_date' => $request["answer_date"],
            ];
            $this->designer_answer_service->update($id, $data);
        } catch (Exception $e) {
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
        //
    }
}
