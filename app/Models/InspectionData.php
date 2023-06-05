<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'inspection_after_rework',
        'agreement_request_id',
        'cpk_data',
        'sent_date_igm',
        'revised_date_igm'
    ];
    protected $guarded = ['id'];
    public function agreement_list(){
        return $this->hasMany(AgreementList::class, 'id' , 'agreement_request_id');
    }
}
