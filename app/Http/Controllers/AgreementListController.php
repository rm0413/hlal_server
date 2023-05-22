<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgreementListRequest;
use App\Services\AgreementListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class AgreementListController extends Controller
{
    use ResponseTrait;
    protected $agreement_list_service;
    public function __construct(AgreementListService $agreementListService)
    {
        $this->agreement_list_service = $agreementListService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $result = $this->successResponse("Loaded Successfully");
     try{
            $result['data']= $this->agreement_list_service->loadAgreementListRequest();
     }catch(\Exception $e){
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
    public function store(AgreementListRequest $request)
    {
        $result = $this->successResponse("Request Added Successfully.");
        try{
            $data = [
                "trial_number" => $request["trial_number"],
                "request_date" => $request["request_date"],
                "additional_request_qty_date" => $request["additional_request_qty_date"],
                "tri_number" => $request["tri_number"],
                "tri_quantity" => $request["tri_quantity"],
                "request_person" => $request["request_person"],
                "superior_approval" => $request["superior_approval"],
                "supplier_name" => $request["supplier_name"],
                "part_number" => $request["part_number"],
                "sub_part_number" => $request["sub_part_number"],
                "revision" => $request["revision"],
                "coordinates" => $request["coordinates"],
                "dimension" => $request["dimension"],
                "actual_value" => $request["actual_value"],
                "critical_parts" => $request->critical_parts,
                "critical_dimension" => $request["critical_dimension"],
                "request_type" => $request["request_type"],
                "request_value" => $request["request_value"],
                "request_quantity" => $request["request_quantity"],
                "unit_id" => $request["unit_id"],
                "requestor_employee_id" => $request["requestor_employee_id"]
            ];
             $this->agreement_list_service->store($data);
            // $inspection_data = [
            //     'agreement_request_id' => $result_agreement_request["id"],
            //     'cpk_data' => "-",
            //     'inspection_after_rework' => "-",
            //     'revised_date_igm' => $agreement_request->revised_date_igm,
            //     'sent_date_igm' => $agreement_request->sent_date_igm
            // ];
            // $this->inspection_service->storeInspectionData($inspection_data);
            // if($agreement_request->critical_parts === 'yes'){
            //     $mail = new PHPMailer();
            //     $mail->isSMTP();
            //     $mail->SMTPDebug  = 0;
            //     $mail->SMTPAuth = false;
            //     $mail->SMTPAutoTLS = false;
            //     $mail->Port = 25;
            //     $mail->Host = "203.127.104.86";
            //     $mail->isHTML(true);
            //     $mail->From = "fdtp.system@ph.fujitsu.com";
            //     $mail->SetFrom("fdtp.system@ph.fujitsu.com", 'Hinsei & LSA Agreenent List');
            //     $mail->addAddress('reinamae.sorisantos@fujitsu.com');
            //     $mail->Subject = 'Hinsei & LSA Agreement List | Critical Parts';
            //     $mail->Body    = view('inspection_email', compact('agreement_data'))->render();
            //     $mail->send();
            // }
        }catch (\Exception $e) {
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
