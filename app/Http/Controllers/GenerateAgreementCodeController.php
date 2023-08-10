<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\GenerateAgreementCodeRequest;
use Illuminate\Support\Str;
use App\Services\GenerateAgreementCodeService;
use App\Services\AgreementListCodeService;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $with = ['generate_code', 'agreement_list', 'units'];
        $whereHas = '';
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
                $result['data'] = $this->agreement_list_code_service->store($agreement_list_code_data);
                $where = [['agreement_request_id', '=', $agreement_id]];
                $datastorage[] = $this->agreement_list_code_service->show($agreement_id, $where, $with,);
            }
            $file_name = storage_path("formatStorage\Excel_format.xlsx");
            // $file_path = public_path("storage/files/test.xlsx");
            $spreadsheet = IOFactory::load($file_name);
            $worksheet = $spreadsheet->getSheetByName('PPEF 09_01');
            $sheet = $spreadsheet->getSheet(0);
            $sheet->getCell("A1")->setValue($datastorage[0][0]['code']);
            $count = count($datastorage) + 10;

            $i = 10;
            $x = 1;
            foreach ($datastorage as $request_item) {
                $sheet->getCell("B{$i}")->setValue($x);
                $sheet->getCell("C{$i}")->setValue($request_item[0]['trial_number']);
                $sheet->getCell("D{$i}")->setValue($request_item[0]['request_date']);
                $sheet->getCell("E{$i}")->setValue($request_item[0]['additional_request_qty_date']);
                $sheet->getCell("F{$i}")->setValue($request_item[0]['tri_number']);
                $sheet->getCell("G{$i}")->setValue($request_item[0]['tri_quantity']);
                $sheet->getCell("H{$i}")->setValue($request_item[0]['request_person']);
                $sheet->getCell("I{$i}")->setValue($request_item[0]['superior_approval']);
                $sheet->getCell("J{$i}")->setValue($request_item[0]['supplier_name']);
                $sheet->getCell("K{$i}")->setValue($request_item[0]['part_number']);
                $sheet->getCell("L{$i}")->setValue($request_item[0]['sub_part_number']);
                $sheet->getCell("M{$i}")->setValue($request_item[0]['revision']);
                $sheet->getCell("N{$i}")->setValue($request_item[0]['coordinates']);
                $sheet->getCell("O{$i}")->setValue($request_item[0]['dimension']);
                $sheet->getCell("P{$i}")->setValueExplicit("{$request_item[0]['actual_value']}", DataType::TYPE_STRING);
                $sheet->getCell("Q{$i}")->setValue($request_item[0]['critical_parts']);
                $sheet->getCell("R{$i}")->setValue($request_item[0]['critical_dimension']);
                $sheet->getCell("T{$i}")->setValue($request_item[0]['request_type']);
                $sheet->getCell("U{$i}")->setValue($request_item[0]['request_value']);
                $sheet->getCell("V{$i}")->setValue($request_item[0]['request_quantity']);
                $i++;
                $x++;
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("storage/files/". "{$datastorage[0][0]['unit_name']}-{$datastorage[0][0]['code']}.xlsx"));

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
            $mail->addAttachment(public_path("storage/files/". "{$datastorage[0][0]['unit_name']}-{$datastorage[0][0]['code']}.xlsx"));
            // $mail->addAddress('jonathandave.detorres@fujitsu.com');
            $mail->addAddress('reinamae.sorisantos@fujitsu.com');
            $mail->addAddress('gerly.hernandez@fujitsu.com');
            $mail->Subject = 'HINSEI & LSA Agreement List | Generated Code';
            $mail->Body    = view('generate_code_email', compact('datastorage'))->render();
            $mail->send();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        LogActivity::addToLog('Generated Agreement Code', $request->emp_id,  $result["status"]);
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
