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
        // } catch (\Exception $e) {
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
            foreach ($request->agreement_request_id as $agreement_req_id) {
                $file = $request->file('file_path_attachment');
                $file_name = $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $year.$month.$day.'-'.$file_name, ['disk' => 'public']);
                $data = [
                    'agreement_request_id' => $agreement_req_id,
                    'file_path_attachment' => $path,
                ];
                $result['data'] = $this->attachment_service->store($data);
            }
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function downloadAttachment(Request $request)
    {
        $result = $this->successResponse("Download Successfully");
        try {
            $file_upload = $request->file_path_attachment;
            $file_name = explode('/', $file_upload);
            $name = $file_name[1];

            $file_path = storage_path('app/public/uploads/' . $name);
            $result =  response()->download($file_path);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }
        return $result;
    }
    public function viewAttachement(Request $request)
    {
        $file_upload = $request->file_path_attachment;
        $file_name = explode('/', $file_upload);
        $name = $file_name[1];

        return response()->file(storage_path('app/public/uploads/' . $name), ['content-type' => 'application/pdf']);
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
