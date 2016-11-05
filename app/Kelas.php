<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    protected $table = 'kelas';
    protected $fillable = ['name','status'];

    public function categories(){
        return $this->hasMany('App\Categories');
    }
}
