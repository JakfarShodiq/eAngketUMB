<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas_Categories extends Model
{
    //
    protected $table = 'kelas_categories';
    protected $fillable = ['id_kelas','id_category'];
}
