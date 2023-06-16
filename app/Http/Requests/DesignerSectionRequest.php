<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponse\Exception;

class DesignerSectionRequest extends FormRequest
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
            'designer_answer' => 'required',
            'designer_in_charge' => 'required',
            'request_result' => 'required',
            'answer_date' => 'required',
        ];
    }
    public function messages()
    {
        return [
            "agreement_request_id.required" => "Agreement Id is required.",
            "designer_answer.required" => "Designer Answer is required.",
            "designer_in_charge.required" => "Designer in Charge is required.",
            "request_result.required" => "Request Result is required.",
            "answer_date.required" => "Answer Date is required.",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponse\Exception(response()->json($response));
    }
}
