<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_Mhs extends Model
{
    //
    protected $table = 'jadwal_mhs';
    protected $fillable = [ 'id_jadwal','id_mhs' ];

}
