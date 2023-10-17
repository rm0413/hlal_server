<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Requests\AgreementListMultipleRequest;
use App\Http\Requests\DateRangeRequest;
use App\Http\Requests\AgreementListRequest;
use App\Services\AgreementListService;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;
use Closure;
use \Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class AgreementListController extends Controller
{
    use ResponseTrait;
    protected $agreement_list_service, $user_service;
    public function __construct(AgreementListService $agreementListService, UserService $user_service)
    {
        $this->agreement_list_service = $agreementListService;
        $this->user_service = $user_service;
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
            $result['data'] = $this->agreement_list_service->loadAgreementListRequest();
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
    public function store(AgreementListRequest $request)
    {
        $result = $this->successResponse("Request Added Successfully.");
        $QCI_email_list = $this->user_service->loadQCIEmailList();
        $PE_email_list = $this->user_service->loadPEEmailList();
        // $user_email_list = $this->user_service->loadEmailList();
        try {
            $data = [
                "trial_number" => $request["trial_number"],
                "request_date" => $request["request_date"] ? Carbon::parse($request["request_date"])->toDateString() : null,
                "additional_request_qty_date" => $request["additional_request_qty_date"] ? Carbon::parse($request["additional_request_qty_date"])->toDateString() : null,
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
            if ($request->critical_parts === 'Yes') {
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
                $mail->addBCC('reinamae.sorisantos@fujitsu.com', 'Inspection Data'); //for prod
                $mail->addBCC('gerly.hernandez@fujitsu.com', 'Inspection Data'); //for prod

                foreach ($QCI_email_list as $email_list) {
                    $mail->addAddress($email_list['emp_email']);
                }
                foreach ($PE_email_list as $pe_email_list) {
                    $mail->addCC($pe_email_list['emp_email']);
                }
                // foreach ($user_email_list as $email_list) {
                //     $mail->addAddress($email_list['emp_email']);
                // } // for testing

                $mail->Subject = 'HINSEI & LSA Agreement List | Inspection Data';
                $mail->Body    = view('inspection_email', compact('data'))->render();
                $mail->send();
            }
            $result['data']  = $this->agreement_list_service->store($data);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Added Single Agreement Request', $request->requestor_employee_id,  $result["status"]);

        return $result;
    }
    public function multipleStore(AgreementListMultipleRequest $request)
    {
        // $reader = new Xlsx;
        $file_name = $request->file('uploaded_file');
        $spreadsheet = IOFactory::load($file_name->getRealPath());
        $datastorage = [];
        $yes_datastorage = [];
        $worksheet = $spreadsheet->getSheetByName('PPEF 09_01');
        $highest_row = $worksheet->getHighestRow();
        $sheet = $spreadsheet->getSheet(0);
        $result = $this->successResponse("Multiple Request Added Successfully");
        $remove = "\n";

        $QCI_email_list = $this->user_service->loadQCIEmailList();
        $PE_email_list = $this->user_service->loadPEEmailList();
        // $user_email_list = $this->user_service->loadEmailList();
        try {
            DB::beginTransaction();
            for ($i = 10; $i < $highest_row + 1; $i++) {
                if (trim($sheet->getCell("B{$i}")->getValue()) != null) {

                    $datastorage = [
                        // 'NO' =>  $sheet->getCell("B{$i}")->getValue(),
                        'trial_number' => trim($sheet->getCell("C{$i}")->getValue()),
                        'request_date' => $sheet->getCell("D{$i}")->getValue() === '-' ? null : Date::excelToDateTimeObject($sheet->getCell("D{$i}")->getValue())->format('Y-m-d'),
                        'additional_request_qty_date' =>  $sheet->getCell("E{$i}")->getValue() === '-' ? null : Date::excelToDateTimeObject($sheet->getCell("E{$i}")->getValue())->format('Y-m-d'),
                        'tri_number' => trim($sheet->getCell("F{$i}")->getValue()),
                        'tri_quantity' => trim($sheet->getCell("G{$i}")->getValue()),
                        'request_person' => trim($sheet->getCell("H{$i}")->getValue()),
                        'superior_approval' => trim($sheet->getCell("I{$i}")->getValue()),
                        'supplier_name' => trim($sheet->getCell("J{$i}")->getValue()),
                        'part_number' => trim($sheet->getCell("K{$i}")->getValue()),
                        'sub_part_number' => trim($sheet->getCell("L{$i}")->getValue()),
                        'revision' => trim($sheet->getCell("M{$i}")->getValue()),
                        'coordinates' => trim(str_replace($remove, " ", $sheet->getCell("N{$i}")->getValue())),
                        'dimension' => trim(str_replace($remove, " ", $sheet->getCell("O{$i}")->getValue())),
                        'actual_value' => trim(str_replace($remove, " ", $sheet->getCell("P{$i}")->getValue())),
                        'critical_parts' => trim($sheet->getCell("Q{$i}")->getValue()),
                        'critical_dimension' => trim($sheet->getCell("R{$i}")->getValue()),
                        // 'CPK_DATA/INS_DATA' => trim($sheet->getCell($data_cell['CPK_DATA/INS_DATA'])->getValue()),
                        'request_type' => trim($sheet->getCell("T{$i}")->getValue()),
                        'request_value' => trim(str_replace($remove, " ", $sheet->getCell("U{$i}")->getValue())),
                        'request_quantity' => trim($sheet->getCell("V{$i}")->getValue()),
                        'unit_id' => $request['unit_id'],
                        'requestor_employee_id' => $request['requestor_employee_id']
                    ];
                    if (trim($sheet->getCell("Q{$i}")->getValue()) === 'Yes' || trim($sheet->getCell("Q{$i}")->getValue()) === 'YES') {
                        $yes_datastorage[] = $datastorage;
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
                        $mail->addBCC('reinamae.sorisantos@fujitsu.com', 'Inspection Data');
                        $mail->addBCC('gerly.hernandez@fujitsu.com', 'Inspection Data');
                        foreach ($QCI_email_list as $email_list) {
                            $mail->addAddress($email_list['emp_email']);
                        }
                        foreach ($PE_email_list as $pe_email_list) {
                            $mail->addCC($pe_email_list['emp_email']);
                        }
                        // foreach ($user_email_list as $email_list) {
                        //     $mail->addAddress($email_list['emp_email']);
                        // }
                        $mail->Subject = 'HINSEI & LSA Agreement List | Inspection Data';
                        $mail->Body    = view('critical_parts_email', compact('yes_datastorage'))->render();
                        $mail->send();
                    }
                    $this->agreement_list_service->store($datastorage);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $result = $this->errorResponse($e);
        }

        LogActivity::addToLog('Added Multiple Agreement Request', $request->requestor_employee_id,  $result["status"]);
        return $result;
    }
    public function downloadFormat(Request $request)
    {
        $result = $this->successResponse("Download Successfully");
        try {
            $format = public_path("storage\Excel_format.xlsx");
            $spreadsheet = IOFactory::load($format);
            $sheet = $spreadsheet->getSheet(0);
            $sheet->getCell("B4")->setValue("{$request->unit_name} LSA/Hinsei Agreement List");

            $date = date('Y-m-d');
            $time = time();
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("storage/files/" . "Excel_format-{$date}-{$time}.xlsx"));

            header("Content-Type: application/vnd.ms-excel");
            return redirect(url('/') . "/storage/files/" . "Excel_format-{$date}-{$time}.xlsx");
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
    public function showMonitoring($part_number)
    {
        $result = $this->successResponse('Load Successfully');
        $with = [
            'agreement_list_code', 'designer_section_answer', 'units'
        ];
        $id = [];
        $where = [
            // ['unit_id', '=', $unit_id,],
            // ['supplier_name', '=', $supplier_name],
            ['part_number', '=', $part_number],
        ];
        $whereHas = 'designer_section_answer';
        try {
            $result['data'] = $this->agreement_list_service->showWhereHas($id, $where, $with, $whereHas);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function showMonitoringList($unit_id, $supplier_name, $part_number)
    {
        $result = $this->successResponse('Load Successfully');
        $with = [
            'agreement_list_code', 'agreement_list_code.generate_code', 'designer_section_answer', 'units', 'attachment', 'inspection_data'
        ];
        $id = [];
        $where = [
            ['unit_id', '=', $unit_id,],
            ['supplier_name', '=', $supplier_name],
            ['part_number', '=', str_replace(" ", "/", $part_number)],
        ];
        $whereHas = 'designer_section_answer';
        try {
            $result['data'] = $this->agreement_list_service->showMonitoringList($id, $where, $with, $whereHas);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function showAttachment($unit_id, $supplier_name, $part_number)
    {
        $result = $this->successResponse('Load Successfully');
        $with = [
            'agreement_list_code', 'agreement_list_code.generate_code', 'designer_section_answer', 'units', 'attachment', 'inspection_data'
        ];
        $id = [];
        $where = [
            ['unit_id', '=', $unit_id,],
            ['supplier_name', '=', $supplier_name],
            ['part_number', '=', str_replace(" ", "/", $part_number)],
        ];
        $whereHas = 'attachment';
        try {
            $result['data'] = $this->agreement_list_service->showMonitoringList($id, $where, $with, $whereHas);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function exportMonitoringList($unit_id, $supplier_name, $part_number)
    {
        $result = $this->successResponse('Load Successfully');
        // $format = "";
        $with = [
            'agreement_list_code', 'agreement_list_code.generate_code', 'designer_section_answer', 'units', 'attachment', 'inspection_data'
        ];
        $id = [];
        $where = [
            ['unit_id', '=', $unit_id,],
            ['supplier_name', '=', $supplier_name],
            ['part_number', '=', str_replace(" ", "/", $part_number)],
        ];
        $whereHas = 'designer_section_answer';
        try {
            $datastorage = $this->agreement_list_service->showMonitoringList($id, $where, $with, $whereHas);
            $file_name = storage_path("formatStorage\\Export.xlsx");
            $file_path = public_path("storage/files/test.xlsx");
            $spreadsheet = IOFactory::load($file_name);
            $worksheet = $spreadsheet->getSheetByName('PPEF 09_01');
            $sheet = $spreadsheet->getSheet(0);
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                    'inside' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
            $i = 10;
            $x = 1;
            $sheet->getCell("B4")->setValue("{$datastorage[0]['unit_name']} LSA/Hinsei Agreement List");
            foreach ($datastorage as $export_data) {
                $worksheet->getStyle("B{$i}:AB{$i}")->applyFromArray($styleArray);
                $sheet->getStyle("B{$i}:AB{$i}")->getAlignment()->setWrapText(true);
                $sheet->getCell("B{$i}")->setValue($x);
                $sheet->getCell("C{$i}")->setValue($export_data['trial_number']);
                $sheet->getCell("D{$i}")->setValue($export_data['request_date']);
                $sheet->getCell("E{$i}")->setValue($export_data['additional_request_qty_date']);
                $sheet->getCell("F{$i}")->setValue($export_data['tri_number']);
                $sheet->getCell("G{$i}")->setValue($export_data['tri_quantity']);
                $sheet->getCell("H{$i}")->setValue($export_data['request_person']);
                $sheet->getCell("I{$i}")->setValue($export_data['superior_approval']);
                $sheet->getCell("J{$i}")->setValue($export_data['supplier_name']);
                $sheet->getCell("K{$i}")->setValue($export_data['part_number']);
                $sheet->getCell("L{$i}")->setValue($export_data['sub_part_number']);
                $sheet->getCell("M{$i}")->setValue($export_data['revision']);
                $sheet->getCell("N{$i}")->setValue($export_data['coordinates']);
                $sheet->getCell("O{$i}")->setValue($export_data['dimension']);
                $sheet->getCell("P{$i}")->setValueExplicit("{$export_data['actual_value']}", DataType::TYPE_STRING);
                $sheet->getCell("Q{$i}")->setValue($export_data['critical_parts']);
                $sheet->getCell("R{$i}")->setValue($export_data['critical_dimension']);
                $sheet->getCell("S{$i}")->setValue($export_data['cpk_data']);
                $sheet->getCell("T{$i}")->setValue($export_data['request_type']);
                $sheet->getCell("U{$i}")->setValue($export_data['request_value']);
                $sheet->getCell("V{$i}")->setValue($export_data['request_quantity']);
                $sheet->getCell("W{$i}")->setValue($export_data['designer_answer']);
                $sheet->getCell("X{$i}")->setValue($export_data['designer_in_charge']);
                $sheet->getCell("Y{$i}")->setValue($export_data['answer_date']);
                $sheet->getCell("Z{$i}")->setValue($export_data['inspection_after_rework']);
                $sheet->getCell("AA{$i}")->setValue($export_data['revised_date_igm']);
                $sheet->getCell("AB{$i}")->setValue($export_data['sent_date_igm']);
                $i++;
                $x++;
            }

            $date = date('Y-m-d');
            $time = time();
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("storage/files/" . "{$datastorage[0]['unit_name']}-{$date}-{$time}.xlsx"));
            // return Response::download(public_path('storage/files/' . "{$datastorage[0]['unit_name']}-{$date}-{$time}.xlsx"));

            header("Content-Type: application/vnd.ms-excel");
            return redirect(url('/') . "/storage/files/" . "{$datastorage[0]['unit_name']}-{$date}-{$time}.xlsx");
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }

    public function loadMonitoringList()
    {
        $result = $this->successResponse('Load Successfully');
        try {
            $result['data'] = $this->agreement_list_service->loadMonitoringList();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadTaskToDo()
    {
        $result = $this->successResponse('Load Successfully');
        try {
            $result['data'] = $this->agreement_list_service->loadTaskToDo();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadWithCodeRequest()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadWithCodeRequest();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadWithNoCodeRequest()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadWithNoCodeRequest();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadCodeWithInspectionData()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadCodeWithInspectionData();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function countInspectionData()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->countInspectionData();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadCodeWithDesignerSection()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadCodeWithDesignerSection();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberWithCode()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberWithCode();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberAttachment()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberAttachment();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberWithCritical()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberWithCritical();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberWithDesigner()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberWithDesigner();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadWithCodeAttachment()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadWithCodeAttachment();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function countRequest(Request $data)
    {
        $result = $this->successResponse("Load Count Request Successfully");
        try {
            $data = [
                'date_from' => Carbon::parse($data['date_from'])->format('Y/m/d'),
                'date_to' => Carbon::parse($data['date_to'])->format('Y/m/d'),
            ];
            $result['data'] = $this->agreement_list_service->countRequest($data);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadCountResult(DateRangeRequest $request)
    {
        $result = $this->successResponse("Load Request Result");

        try {
            $data = [
                'date_from' => Carbon::parse($request['date_from'])->format('Y/m/d'),
                'date_to' => Carbon::parse($request['date_to'])->format('Y/m/d'),
            ];
            $result['data'] = $this->agreement_list_service->loadCountResult($data);
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
    public function update(AgreementListRequest $request, $id)
    {
        $result = $this->successResponse("Updated Successfully.");
        try {
            $data = [
                "trial_number" => $request["trial_number"],
                "request_date" => $request["request_date"],
                "additional_request_qty_date" => $request["additional_request_qty_date"] ? Carbon::parse($request["additional_request_qty_date"])->toDateString() : null,
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
            $this->agreement_list_service->update($id, $data);
        } catch (\Exception $e) {
            //throw $e;
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Updated Agreement Request', $request->requestor_employee_id,  $result["status"]);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAgreement($id, $emp_id)
    {
        $result = $this->successResponse("Deleted Successfully");
        try {
            $this->agreement_list_service->delete($id);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Removed Agreement Request', $emp_id,  $result["status"]);
        return $result;
    }
    public function deleteMonitoring($id, $emp_id)
    {
        $result = $this->successResponse("Deleted Successfully");
        try {
            $this->agreement_list_service->delete($id);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Removed Agreement Request', $emp_id,  $result["status"]);
        return $result;
    }
    public function loadWithoutDesignerAnswer()
    {
        $result = $this->successResponse('Load Successfully');
        try {
            $this->agreement_list_service->loadWithoutDesignerAnswer();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
}
