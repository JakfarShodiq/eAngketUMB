<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis_Pt extends Model
{
    //
    use SoftDeletes;

    protected $table = 'jenis_pt';
    protected $fillable = ['name','kelas_category'];
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasMany('App\Categories');
    }
}
