<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\AttachmentRequest;
use App\Services\AttachmentService;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    use ResponseTrait;
    protected $attachment_service;
    public function __construct(AttachmentService $attachment_service)
    {
        $this->attachment_service = $attachment_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $result = $this->successResponse("View Successfully");
        // try {
        //     // $result['data'] = $this->agreement_list_service->loadWithCodeRequest();
        //     $format = storage_path("format\${$request->file_path_attachment}");
        //     return response()->file($format);
        // } catch (Exception $e) {
        //     $result = $this->errorResponse($e);
        // }
        // return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentRequest $request)
    {
        $result = $this->successResponse("Attachment Added Successfully");
        try {
            $year = date("Y");
            $month = date("m");
            $day = date("d");
            $filename = "uploads/" . $year . $month . $day;
            $filename2 = "uploads/" . $year . $month . $day;

            if (file_exists($filename)) {
                if (file_exists($filename2) == false) {
                    mkdir($filename2, 777, true);
                }
            } else {
                mkdir($filename, 777, true);
                mkdir($filename2, 777, true);
            }
            foreach ($request->agreement_request_id as $agreement_req_id) {
                $path = $request->file('file_path_attachment')->store($filename2, ['disk' => 'c_path']);
                $data = [
                    'agreement_request_id' => $agreement_req_id,
                    'file_path_attachment' => $path,
                ];
                $result['data'] = $this->attachment_service->store($data);
            }
        } catch (Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function downloadAttachment(Request $request)
    {
        $result = $this->successResponse("Download Successfully");
        try {
            $file = $request->file_path_attachment;
            $format = storage_path('app/' . $file);
            return response()->download($format);
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
