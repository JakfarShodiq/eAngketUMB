<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedbacks extends Model
{
    //
    use SoftDeletes;
    protected $table = 'feedbacks';
    protected $fillable = [
        'periode'
        ,'status'
        ,'created_by'
        ,'assigned_to'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
        ,'id_issue'
        ,'note'
    ];
    protected $dates = ['deleted_at'];

    public function detail() {
        return $this->hasMany('\App\Feedback_Details','feedback_id','id');
    }

}