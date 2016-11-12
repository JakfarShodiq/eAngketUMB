<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertanyaan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'pertanyaan';
    protected $fillable = [
      'text','jenis_pt','status','created_by'
    ];

    protected $dates = ['deleted_at'];
    public function jenispt(){
        return $this->belongsTo('App\JenisPt','jenis_pt');
    }
}
