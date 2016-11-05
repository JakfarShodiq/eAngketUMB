<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis_Pt extends Model
{
    //
    protected $table = 'jenis_pt';
    protected $fillable = ['name','kelas_category'];

    public function category(){
        return $this->hasMany('App\Categories');
    }
}
