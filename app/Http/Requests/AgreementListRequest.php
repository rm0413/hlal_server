<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\HttpExceptions\HttpResponseException;

class AgreementListRequest extends FormRequest
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
            'trial_number' => 'required',
            'request_date' => 'required|date',
            'additional_request_qty_date' => 'date',
            'tri_number' => 'required',
            'tri_quantity' => 'required',
            'request_person' => 'required',
            'superior_approval' => 'required',
            'supplier_name' => 'required',
            'part_number' => 'required',
            'sub_part_number' => 'required',
            'revision' => 'required',
            'coordinates' => 'required',
            'dimension' => 'required',
            'actual_value' => 'required',
            'critical_parts' => 'required',
            'critical_dimension' => 'required',
            'request_type' => 'required',
            'request_value' => 'required',
            'request_quantity' => 'required',
            'unit_id' => 'required',
            'requestor_employee_id' => 'required'
        ];
    }
    public function messages(){
        return [
            "trial_number.required" => "Trial Number is required.",
            "request_date.required" => "Request Date is required.",
            "additional_request_qty_date.date" => "Additional Request Qty Date must be a date.",
            "tri_number.required" => "TRI Number is required.",
            "tri_quantity.required" => "TRI Quantity is required.",
            "request_person.required" => "Request Person is required.",
            "superior_approval.required" => "Superior Approval is required.",
            "supplier_name.required" => "Supplier is required.",
            "part_number.required" => "Part Number is required.",
            "sub_part_number.required" => "Sub Part Number is required.",
            "revision.required" => "Revision is required.",
            "coordinates.required" => "Coordinates is required.",
            "dimension.required" => "Dimension is required.",
            "actual_value.required" => "Actual Value is required.",
            "critical_parts.required" => "Critical Parts is required.",
            "critical_dimension.required" => "Critical Dimension is required.",
            "request_type.required" => "Kind of Request is required.",
            "request_value.required" => "Request Value is required.",
            "request_quantity.required" => "Request Quantity is required.",
            "unit_id.required" => "Unit ID is required.",
            "requestor_employee_id.required" => "Requestor is required."
        ];
    }
    public function failedValidation(Validator $validator){
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response));
    }
}
