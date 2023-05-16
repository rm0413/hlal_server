<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisMasterlist extends Model
{
    use HasFactory;
    protected $connection = 'portal_database';
    protected $table = 'hrms_emp_masterlists';
}
