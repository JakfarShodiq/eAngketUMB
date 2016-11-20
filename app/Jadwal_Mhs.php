<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_Mhs extends Model
{
    //
    protected $table = 'jadwal_mhs';
    protected $fillable = [ 'id_jadwal','id_mhs' ];

    /*      FROM angketumb.jadwal_mhs jm INNER JOIN angketumb.jadwal j ON jm.id_jadwal = j.id
                INNER JOIN angketumb.matakuliah mt ON j.id_matkul = mt.id
                INNER JOIN angketumb.kelas k ON k.id = mt.id_kelas
                INNER JOIN angketumb.kelas_categories kc ON kc.id_kelas = k.id
                INNER JOIN angketumb.jenis_pt jpt ON jpt.kelas_category = kc.id
                INNER JOIN angketumb.categories c ON c.id = kc.id_category
                INNER JOIN angketumb.pertanyaan p ON p.jenis_pt = jpt.id;
        */

    public function jadwal(){
        return $this->belongsTo('App\Jadwal','id_jadwal');
    }

    public function matakuliah(){
        return $this->belongsTo('App\Matakuliah','id_matkul');
    }

}
