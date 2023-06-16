<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponse\Exception;


class GenerateAgreementCodeRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
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
            'agreement_request_id' => 'required|unique:agreement_list_codes,agreement_request_id,NULL,id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        return [
            "agreement_request_id.required" => "Code is required.",
            "agreement_request_id.unique" => "Already Exists.",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponse\Exception(response()->json($response));
    }
}
