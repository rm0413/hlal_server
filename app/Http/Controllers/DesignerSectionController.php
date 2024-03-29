<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Requests\DesignerSectionRequest;
use App\Services\DesignerSectionService;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class DesignerSectionController extends Controller
{
    use ResponseTrait;
    protected $designer_answer_service;
    public $user_service;
    public function __construct(DesignerSectionService $designer_answer_service, UserService $user_service)
    {
        $this->designer_answer_service = $designer_answer_service;
        $this->user_service = $user_service;
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
        $user_email_list = $this->user_service->loadEmailList();
        $file_name = $request->file('uploaded_file');
        $spreadsheet = IOFactory::load($file_name->getRealPath());
        $datastorage = [];
        $worksheet = $spreadsheet->getSheetByName('PPEF 09_01');
        $highest_row = $worksheet->getHighestRow();
        $sheet = $spreadsheet->getSheet(0);
        $request_storage = [];
        $datastorage2 = [];
        $remove = "\n";
        try {
            foreach ($request->data as $data) {
                $request_storage[] = [
                    'agreement_request_id' => $data['agreement_request_id'],
                    'trial_number' => $data['trial_number'],
                    'request_date' => $data['request_date'],
                    'additional_request_qty_date' => $data['additional_request_qty_date'],
                    'tri_number' => $data['tri_number'],
                    'tri_quantity' => $data['tri_quantity'],
                    'request_person' => $data['request_person'],
                    'superior_approval' => $data['superior_approval'],
                    'supplier_name' => $data['supplier_name'],
                    'part_number' => $data['part_number'],
                    'sub_part_number' => $data['sub_part_number'],
                    'revision' => $data['revision'],
                    'coordinates' => $data['coordinates'],
                    'dimension' => $data['dimension'],
                    'actual_value' => $data['actual_value'],
                    'critical_parts' => $data['critical_parts'],
                    'critical_dimension' => $data['critical_dimension'],
                    'request_type' => $data['request_type'],
                    'request_value' => $data['request_value'],
                    'request_quantity' => $data['request_quantity'],
                    'unit_id' => $data['unit_id'],
                    'requestor_employee_id' => $data['requestor_employee_id'],
                ];
            }
            for ($i = 10; $i < $highest_row + 1; $i++) {
                if (trim($sheet->getCell("B{$i}")->getValue()) != null) {
                    $datastorage[] = [
                        // 'NO' =>  $sheet->getCell("B{$i}")->getValue(),
                        'trial_number' => trim("{$sheet->getCell("C{$i}")->getValue()}"),
                        // 'request_date' => trim($sheet->getCell("D{$i}")->getValue()) === '-' ? null : Date::excelToDateTimeObject(trim($sheet->getCell("D{$i}")->getValue()))->format('Y-m-d'),
                        // 'additional_request_qty_date' => trim($sheet->getCell("E{$i}")->getValue()) === '-' ? null : Date::excelToDateTimeObject(trim($sheet->getCell("E{$i}")->getValue()))->format('Y-m-d'),
                        'tri_number' => trim("{$sheet->getCell("F{$i}")->getValue()}"),
                        'tri_quantity' => trim("{$sheet->getCell("G{$i}")->getValue()}"),
                        'request_person' => trim($sheet->getCell("H{$i}")->getValue()),
                        'superior_approval' => trim($sheet->getCell("I{$i}")->getValue()),
                        'supplier_name' => trim($sheet->getCell("J{$i}")->getValue()),
                        'part_number' => trim($sheet->getCell("K{$i}")->getValue()),
                        'sub_part_number' => trim($sheet->getCell("L{$i}")->getValue()),
                        'revision' => trim("{$sheet->getCell("M{$i}")->getValue()}"),
                        'coordinates' => trim(str_replace($remove, " ", $sheet->getCell("N{$i}")->getValue())),
                        'dimension' => trim(str_replace($remove, " ", $sheet->getCell("O{$i}")->getValue())),
                        'actual_value' => trim(str_replace($remove, " ", $sheet->getCell("P{$i}")->getValue())),
                        'critical_parts' => trim($sheet->getCell("Q{$i}")->getValue()),
                        'critical_dimension' => trim($sheet->getCell("R{$i}")->getValue()),
                        // 'CPK_DATA/INS_DATA' => $sheet->getCell($data_cell['CPK_DATA/INS_DATA'])->getValue()),
                        'request_type' => trim($sheet->getCell("T{$i}")->getValue()),
                        'request_value' => trim(str_replace($remove, " ", $sheet->getCell("U{$i}")->getValue())),
                        'request_quantity' => trim("{$sheet->getCell("V{$i}")->getValue()}"),
                        'designer_ans' => trim($sheet->getCell("W{$i}")->getValue()),
                        'designer_incharge' => trim($sheet->getCell("X{$i}")->getValue()),
                        'answer_date' => $sheet->getCell("Y{$i}")->getValue() === '-' ? null : $sheet->getCell("Y{$i}")->getValue(),
                        // 'unit_id' => $request['unit_id'],
                        // 'requestor_employee_id' => $request['requestor_employee_id']
                    ];
                }
            }
            foreach ($request_storage as $data_request) {
                for ($i = 0; $i < count($datastorage); $i++) {
                    if (
                        $data_request['trial_number'] === $datastorage[$i]['trial_number'] &&
                        // $data_request['request_date'] === $datastorage[$i]['request_date'] &&
                        // $data_request['additional_request_qty_date'] === $datastorage[$i]['additional_request_qty_date'] &&
                        $data_request['tri_number'] === $datastorage[$i]['tri_number'] &&
                        $data_request['tri_quantity'] === $datastorage[$i]['tri_quantity'] &&
                        $data_request['request_person'] === $datastorage[$i]['request_person'] &&
                        $data_request['superior_approval'] === $datastorage[$i]['superior_approval'] &&
                        $data_request['supplier_name'] === $datastorage[$i]['supplier_name'] &&
                        $data_request['part_number'] === $datastorage[$i]['part_number'] &&
                        $data_request['sub_part_number'] === $datastorage[$i]['sub_part_number'] &&
                        $data_request['revision'] === $datastorage[$i]['revision'] &&
                        $data_request['coordinates'] === $datastorage[$i]['coordinates'] &&
                        $data_request['dimension'] === $datastorage[$i]['dimension'] &&
                        $data_request['actual_value'] === $datastorage[$i]['actual_value'] &&
                        $data_request['critical_parts'] === $datastorage[$i]['critical_parts'] &&
                        $data_request['critical_dimension'] === $datastorage[$i]['critical_dimension'] &&
                        $data_request['request_type'] === $datastorage[$i]['request_type']  &&
                        $data_request['request_value'] === $datastorage[$i]['request_value'] &&
                        $data_request['request_quantity'] === $datastorage[$i]['request_quantity']
                    ) {
                        $datastorage2[] =
                            [
                                'agreement_request_id' => $data_request['agreement_request_id'],
                                'designer_ans' => $datastorage[$i]['designer_ans'],
                                'designer_incharge' => $datastorage[$i]['designer_incharge'],
                                'answer_date' => Date::excelToDateTimeObject($datastorage[$i]['answer_date'])->format('Y-m-d'),
                            ];
                        $i = count($datastorage);
                    }
                }
            }
            foreach ($datastorage2 as $store_data) {
                $data = [
                    'agreement_request_id' => $store_data['agreement_request_id'],
                    'designer_answer' => $store_data['designer_ans'],
                    'designer_in_charge' => $store_data["designer_incharge"],
                    'request_result' => $request["request_result"],
                    'answer_date' => $store_data["answer_date"],
                ];
                $this->designer_answer_service->store($data);
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
            $mail->SetFrom("fdtp.system@ph.fujitsu.com", 'HINSEI & LSA Agreement List | HLAL');
            $mail->addBCC('reinamae.sorisantos@fujitsu.com'); //for prod
            $mail->addBCC('gerly.hernandez@fujitsu.com');
            foreach ($user_email_list as $email_list) {
                $mail->addAddress($email_list['emp_email']);
            }
            $mail->Subject = 'HINSEI & LSA Agreement List | Designer Section Answer';
            $mail->Body    = view('update_designer_email', compact('request_storage'))->render();
            $mail->send();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        LogActivity::addToLog('Added Multiple Designer Answer Request', $request->emp_id,  $result["status"]);
        return $result;
    }

    public function storeSingleDesignerAnswer(DesignerSectionRequest $request)
    {
        $result = $this->successResponse("Designer Section Answer Added Successfully");
        $user_email_list = $this->user_service->loadEmailList();
        $data_storage = $request->selected_datastorage;
        try {
            foreach ($request->agreement_request_id as $agreement_req_id) {
                $data = [
                    'agreement_request_id' => $agreement_req_id,
                    'designer_answer' => $request["designer_answer"],
                    'designer_in_charge' => $request["designer_in_charge"],
                    'request_result' => $request["request_result"],
                    'answer_date' => $request["answer_date"],
                ];
                $this->designer_answer_service->store($data);
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
            $mail->SetFrom("fdtp.system@ph.fujitsu.com", 'HINSEI & LSA Agreement List | HLAL');
            $mail->addBCC('reinamae.sorisantos@fujitsu.com'); //for prod
            $mail->addBCC('gerly.hernandez@fujitsu.com');
            foreach ($user_email_list as $email_list) {
                $mail->addAddress($email_list['emp_email']);
            }
            $mail->Subject = 'HINSEI & LSA Agreement List | Designer Section Answer';
            $mail->Body    = view('update_single_designer', compact('data_storage'))->render();
            $mail->send();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        LogActivity::addToLog('Added Single Designer Answer Request', $request->emp_id,  $result["status"]);
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
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Updated Designer Answer Request', $request->emp_id,  $result["status"]);
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
