<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgreementListCodeRequest;
use App\Traits\ResponseTrait;

use App\Services\AgreementListCodeService;
use Illuminate\Http\Request;

class AgreementListCodeController extends Controller
{
    use ResponseTrait;
    protected $agreement_list_code_service;
    public function __construct(AgreementListCodeService $agreement_list_code_service){
        $this->agreement_list_code_service = $agreement_list_code_service;
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
            $result['data'] = $this->agreement_list_code_service->loadGenaratedAgreementCode();
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
    public function store(AgreementListCodeRequest $request)
    {
     $result = $this->successResponse('Stored Successfully');
     try{
        $data = [
            'code_id' => $request['code_id'],
            'agreement_request_id' => $request['agreement_request_id']
        ];
        $result['data'] = $this->agreement_list_code_service->store($data);
     }catch(\Exception $e){
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
