<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    protected $table = 'kelas';
    protected $fillable = ['name','status'];

    public function category(){
        return $this->belongsToMany('App\Categories','kelas_categories','id_kelas','id_category');
    }

    public function jenispt(){
        return $this->hasMany('App\JenisPt','kelas_category');
    }

    public function jenispt2(){
        return $this->hasManyThrough('\App\JenisPt','\App\KelasCategories','id_kelas','kelas_category','id');
    }

    public function kelas_categories(){
        return $this->hasMany('\App\KelasCategories','id_kelas');
    }
}
