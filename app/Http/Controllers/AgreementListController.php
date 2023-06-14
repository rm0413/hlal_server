<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgreementListMultipleRequest;
use App\Http\Requests\AgreementListRequest;
use App\Services\AgreementListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

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
        try {
            $result['data'] = $this->agreement_list_service->loadAgreementListRequest();
        } catch (Exception $e) {
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
        try {
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
            $result['data']  = $this->agreement_list_service->store($data);
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function multipleStore(AgreementListMultipleRequest $request)
    {
        // $reader = new Xlsx;
        $file_name = $request->file('uploaded_file');
        $spreadsheet = IOFactory::load($file_name->getRealPath());
        $datastorage = [];
        $worksheet = $spreadsheet->getSheetByName('PPEF 09_01');
        $highest_row = $worksheet->getHighestRow();
        $sheet = $spreadsheet->getSheet(0);
        $result = $this->successResponse("Stored Successfully");
        try {
            DB::beginTransaction();
            for ($i = 10; $i < $highest_row + 1; $i++) {
                if ($sheet->getCell("B{$i}")->getValue() != null) {
                    $datastorage = [
                        // 'NO' =>  $sheet->getCell("B{$i}")->getValue(),
                        'trial_number' => $sheet->getCell("C{$i}")->getValue(),
                        'request_date' => Date::excelToDateTimeObject($sheet->getCell("D{$i}")->getValue())->format('Y-m-d'),
                        'additional_request_qty_date' =>  Date::excelToDateTimeObject($sheet->getCell("E{$i}")->getValue())->format('Y-m-d') === '1970-01-01' ? null : Date::excelToDateTimeObject($sheet->getCell("E{$i}")->getValue())->format('Y-m-d'),
                        'tri_number' => $sheet->getCell("F{$i}")->getValue(),
                        'tri_quantity' => $sheet->getCell("G{$i}")->getValue(),
                        'request_person' => $sheet->getCell("H{$i}")->getValue(),
                        'superior_approval' => $sheet->getCell("I{$i}")->getValue(),
                        'supplier_name' => $sheet->getCell("J{$i}")->getValue(),
                        'part_number' => $sheet->getCell("K{$i}")->getValue(),
                        'sub_part_number' => $sheet->getCell("L{$i}")->getValue(),
                        'revision' => $sheet->getCell("M{$i}")->getValue(),
                        'coordinates' => $sheet->getCell("N{$i}")->getValue(),
                        'dimension' => $sheet->getCell("O{$i}")->getValue(),
                        'actual_value' => $sheet->getCell("P{$i}")->getValue(),
                        'critical_parts' => $sheet->getCell("Q{$i}")->getValue(),
                        'critical_dimension' => $sheet->getCell("R{$i}")->getValue(),
                        // 'CPK_DATA/INS_DATA' => $sheet->getCell($data_cell['CPK_DATA/INS_DATA'])->getValue(),
                        'request_type' => $sheet->getCell("T{$i}")->getValue(),
                        'request_value' => $sheet->getCell("U{$i}")->getValue(),
                        'request_quantity' => $sheet->getCell("V{$i}")->getValue(),
                        'unit_id' => $request['unit_id'],
                        'requestor_employee_id' => $request['requestor_employee_id']
                    ];
                    $this->agreement_list_service->store($datastorage);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function downloadFormat()
    {
        $result = $this->successResponse("Download Successfully");
        try {
            $format = storage_path("formatStorage\Excel_format.xlsx");
            $result = response()->download($format);
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
    public function loadWithCodeRequest()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadWithCodeRequest();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadWithNoCodeRequest()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadWithNoCodeRequest();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadCodeWithInspectionData()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadCodeWithInspectionData();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadCodeWithDesignerSection()
    {
        $result = $this->successResponse("Load Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadCodeWithDesignerSection();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberWithCode()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberWithCode();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function loadPartNumberWithCritical()
    {
        $result = $this->successResponse("Load Part Number Successfully");
        try {
            $result['data'] = $this->agreement_list_service->loadPartNumberWithCritical();
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function countRequest()
    {
        $result = $this->successResponse("Load Count Request Successfully");
        try {
            $result['data'] = $this->agreement_list_service->countRequest();
        } catch (Exception $e) {
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
            $this->agreement_list_service->update($id, $data);
        } catch (Exception $e) {
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
            $result['data'] = $this->agreement_list_service->delete($id);
        } catch (\ErrorException $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
}
