<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'role_access',
    ];
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function section_data(){
    //     return $this->belongsTo(Section::class, "section_id", "id");
    // }
    public $primaryKey = "employee_id";
    protected $keyType = "string";
    public $incrementing = false;

    public function fdtp_portal_user(){
        return $this->hasOne(FdtpPortalUser::class, "emp_id", "employee_id");
    }
    public function hris_masterlist(){
        return $this->hasOne(HrisMasterlist::class, "emp_pms_id", "employee_id");
    }
    public function employee_notification(){
        return $this->hasOne(EmployeeNotification::class, "emp_id", "employee_id");
    }
}
