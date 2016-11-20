<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Angket_Details extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'angket_details';
    protected $fillable = [ 'angket_id','id_pt','rate' ];
}
