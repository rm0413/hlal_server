<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgreementListCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'agreement_request_id',
        'code_id'
    ];
    protected $guarded = [
        'id'
    ];

    protected $keyType = 'string';

    public function agreement_list(){
        return $this->hasMany(AgreementList::class, 'id' , 'agreement_request_id');
    }
    public function generate_code(){
        return $this->hasOne(GenerateAgreementCode::class, 'id' , 'code_id');
    }
}
