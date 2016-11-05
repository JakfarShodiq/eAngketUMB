<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PicCategories extends Model
{
    //
    protected $table = 'pic_categories';
    protected $fillable = ['role_id', 'category_id'];

}
