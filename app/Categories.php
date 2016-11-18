<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Dotenv\Validator;

class Categories extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'status',
        'role_id',
    ];

    private $rules = [
        'name'  =>  'required|min:5',
        'status'    =>  'required'
    ];

    public function getValidate(Request $request){
        $validate = Validator::make($request,$this->rules);

        return $validate->passes();
    }

    public function jenispt(){
            return $this->hasManyThrough('\App\JenisPt','\App\KelasCategories','id_category','kelas_category','id');
    }

    public function roles(){
        return $this->belongsToMany('App\Roles','pic_categories','category_id','role_id');
    }

}