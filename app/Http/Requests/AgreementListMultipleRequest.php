<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class AgreementListMultipleRequest extends FormRequest
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
            'uploaded_file' => 'required|file|filled|sometimes|mimes:xls,xlsx',
            'unit_id' => 'required',
        ];
    }
    public function meesages()
    {
        return [
            'uploaded_file.required' => 'Please Upload a File!',
            'uploaded_file.sometimes' => 'TETST!',
            "unit_id.required" => "Unit ID is required.",

        ];
    }
    public function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response));
    }
}
