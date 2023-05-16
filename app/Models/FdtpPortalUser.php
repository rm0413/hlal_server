<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdtpPortalUser extends Model
{
    use HasFactory;
    protected $connection = 'portal_database';
    protected $table = 'users';
}
