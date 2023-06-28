<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class InspectionDataRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'agreement_request_id' => 'required',
            'cpk_data' => 'required',
            'inspection_after_rework' => 'required',
            'revised_date_igm' => 'required',
            'sent_date_igm' => 'required',
        ];
    }
    public function messages(){
        return [
            "agreement_request_id.required" => "Agreement List ID is required.",
            "cpk_data.required" => "Cpk data is required.",
            "inspection_after_rework.required" => "Inspection after rework is required.",
            "revised_date_igm.required" => "Revised Date IGM is required.",
            "sent_date_igm.required" => "Sent Date IGM is required.",
        ];
    }
    public function failedValidation(Validator $validator){
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response));
    }
}
