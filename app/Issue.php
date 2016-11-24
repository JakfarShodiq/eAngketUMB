<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'periode'
        ,'semester'
        ,'jenis_pertanyaan'
        ,'ruang'
        ,'nama_dosen'
        ,'matakuliah'
        ,'pertanyaan'
        ,'avg_rate'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
    ];

    protected $dates = ['deleted_at'];

    public function ticket(){
        return $this->hasMany('\App\feedbacks','id_issue','id');
    }
}
