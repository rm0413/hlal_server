<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgreementList extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'trial_number', 'request_date', 'additional_request_qty_date',
        'tri_number', 'tri_quantity', 'request_person', 'superior_approval',
        'supplier_name', 'part_number', 'sub_part_number', 'revision',
        'coordinates', 'dimension', 'actual_value', 'critical_parts',
        'critical_dimension', 'request_type', 'request_value',
        'request_quantity', 'unit_id', 'generated_code', 'requestor_employee_id'
    ];
    protected $guarded = [
        'id'
    ];
    protected $keyType = 'string';


    public function fdtp_portal_user()
    {
        return $this->hasOne(FdtpPortalUser::class, "emp_id", "employee_id");
    }
    public function hris_masterlist()
    {
        return $this->hasOne(HrisMasterlist::class, "emp_pms_id", "requestor_employee_id");
    }
    public function units()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
    public function inspection_data()
    {
        return $this->hasOne(InspectionData::class, 'agreement_request_id', 'id');
    }
    public function agreement_list_code()
    {
        return $this->hasOne(AgreementListCode::class, 'agreement_request_id', 'id');
    }
    public function designer_section_answer()
    {
        return $this->hasOne(DesignerSection::class, 'agreement_request_id', 'id');
    }
}
