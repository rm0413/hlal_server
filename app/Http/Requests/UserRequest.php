<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'employee_id'    => $this->method() === "POST" ? "required|unique:users,employee_id,NULL,id,deleted_at,NULL" : "",
            'role_access'    => 'required',
        ];
    }
    public function messages(){
        return [
            'employee_id.required' => "Please Input Valid Employee ID",
            'employee_id.unique' => "Employee ID already exists",
            'role_access.required' => "Please Input Role Access ID"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response, 200));
    }
}
