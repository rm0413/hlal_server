<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'agreement_request_id',
        'file_path_attachment'
    ];
    protected $guarded = [
        'id'
    ];
}
