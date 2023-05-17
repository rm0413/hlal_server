<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'unit_created_by',
        'unit_status',
        'unit_name'
    ];
    protected $guarded = [
        'id'
    ];


    protected $keyType = 'string';

    public function fdtp_portal_user(){
        return $this->hasOne(FdtpPortalUser::class, "emp_id", "unit_created_by");
    }
    public function hris_masterlist(){
        return $this->hasOne(HrisMasterlist::class, "emp_pms_id", "unit_created_by");
    }
}
