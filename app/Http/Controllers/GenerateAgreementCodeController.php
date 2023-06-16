<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\GenerateAgreementCodeRequest;
use Illuminate\Support\Str;
use App\Services\GenerateAgreementCodeService;
use App\Services\AgreementListCodeService;
use PHPMailer\PHPMailer\PHPMailer;

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
    public function store(GenerateAgreementCodeRequest $request)
    {
        $result = $this->successResponse("Stored Successfully");
        $characters = Str::random(6);
        $characterNumbers = strlen($characters);
        $code = '';
        $with = ['generate_code', 'agreement_list'];
        $datastorage = [];
        $where = [];
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
                $this->agreement_list_code_service->store($agreement_list_code_data);
                $where = [['agreement_request_id', '=', $agreement_id]];
                $datastorage[] = $this->agreement_list_code_service->show($agreement_id, $where, $with);
            }
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth = false;
            $mail->SMTPAutoTLS = false;
            $mail->Port = 25;
            $mail->Host = "203.127.104.86";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->From = "fdtp.system@ph.fujitsu.com";
            $mail->SetFrom("fdtp.system@ph.fujitsu.com", 'HINSEI | HLAL');
            $mail->addAddress('jonathandave.detorres@fujitsu.com', 'Cancelled Archive Request');
            $mail->addAddress('reinamae.sorisantos@fujitsu.com', 'Cancelled Archive Request');
            $mail->Subject = 'HINSEI | Generated Code';
            $mail->Body    = view('generate_code_email', compact('datastorage'))->render();
            $mail->send();
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
