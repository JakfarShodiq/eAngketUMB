<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    //

    use SoftDeletes;

    protected $table = 'jadwal';
    protected $dates = ['deleted_at'];
    protected $fillable = ['tahun_ajaran',
        'id_matkul',
        'id_dosen',
        'ruang',
        'hari',
        'time_start',
        'time_end',
        'qty'];

    public function jadwal(){
        return $this->hasMany('App\Matakuliah');
    }
}
