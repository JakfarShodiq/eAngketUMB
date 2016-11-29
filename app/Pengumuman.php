<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    //
    use SoftDeletes;
    protected $table = 'notifications';
    protected $fillable = [
        'id_feedbacks',
        'note',
        'created_by',
    ];

    public function ticket(){
        return $this->belongsTo('\App\Feedbacks','id_feedbacks','id');
    }
}
