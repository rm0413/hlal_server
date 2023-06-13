<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignerSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'agreement_request_id', 'designer_answer', 'answer_date','designer_in_charge',
        'request_result'
    ];

    protected $guarded = [ 'id' ];

}
