<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'emp_id', 'status'
    ];

    public function hris_masterlist()
    {
        return $this->belongsTo(HrisMasterlist::class, "emp_id", "emp_pms_id");
    }
}
