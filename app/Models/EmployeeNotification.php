<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeNotification extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id' , 'recieve_notification'];
    protected $guarded = ['id'];
    public function users(){
        return $this->hasOne(EmployeeNotification::class, "emp_id", "employee_id");
    }
}
