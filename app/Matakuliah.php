<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matakuliah extends Model
{
    //
    use SoftDeletes;

    protected $table = 'matakuliah';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name','semester','sks','id_kelas'];
}
