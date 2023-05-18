<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UnitRequest extends FormRequest
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
            'unit_name' => 'required|unique:units,unit_name,NULL,id',
            'unit_status' => 'required',
            'unit_created_by' => 'required',
        ];
    }
    public function messages(){
        return [
            "unit_name.required" => "Unit name is required.",
            "unit_name.unique" => "Unit Name is already registered.",
            "unit_status.required" => "Unit status is required.",
            "unit_created_by.required" => "Unit created by is required."
        ];
    }
    public function failedValidation(Validator $validator){
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response));
    }
}
