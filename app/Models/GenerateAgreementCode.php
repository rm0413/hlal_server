<?php

namespace App\Models;

use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateAgreementCode extends Model
{
    use HasFactory;
    use ResponseTrait;

    protected $fillable = [
        'code'
    ];
    protected $guarded = [
        'id'
    ];

}
