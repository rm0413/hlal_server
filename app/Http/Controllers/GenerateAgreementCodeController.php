<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\GenerateAgreementCodeRequest;
use Illuminate\Support\Str;
use App\Services\GenerateAgreementCodeService;
use App\Services\AgreementListCodeService;

class GenerateAgreementCodeController extends Controller
{
    use ResponseTrait;
    protected $generate_agreement_code_service;
    protected $agreement_list_code_service;
    public function __construct(GenerateAgreementCodeService $generate_agreement_code_service, AgreementListCodeService $agreement_list_code_service)
    {
        $this->generate_agreement_code_service = $generate_agreement_code_service;
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
            $result['data'] = $this->generate_agreement_code_service->loadAll();
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
    public function store(GenerateAgreementCodeRequest $request)
    {
        $result = $this->successResponse("Stored Successfully");
        $characters = Str::random(6);
        $characterNumbers = strlen($characters);
        $code = '';
        $with = ['generate_code', 'agreement_list'];
        $datastorage = [];
        try {
            while (strlen($code) < 4) {

                $position = rand(0, $characterNumbers - 1);
                $character = $characters[$position];
                $code = $code . $character;
            }
            $generated_code = "FDTP_{$code}";
            $data = [
                'code' => $generated_code
            ];
            $code_id = $this->generate_agreement_code_service->store($data);
            foreach ($request->agreement_request_id as $agreement_id) {

                $agreement_list_code_data = [
                    'agreement_request_id' => $agreement_id,
                    'code_id' => $code_id['id']

                ];
                $result['data'] = $this->agreement_list_code_service->store($agreement_list_code_data);
            }
            $where = [['id', '=', $result['data']['id']]];
            $datastorage = $this->agreement_list_code_service->show($result['data']['id'], $where, $with);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $datastorage;
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
