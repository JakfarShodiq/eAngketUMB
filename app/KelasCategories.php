<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasCategories extends Model
{
    //
    use SoftDeletes;
    protected $table = 'kelas_categories';
    protected $fillable = ['id_kelas','id_category'];

    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasOne('\App\Categories','id','id_category');
    }

}
