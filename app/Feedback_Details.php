<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback_Details extends Model
{
    //
    use SoftDeletes;
    protected $table = 'feedback_details';
    protected $fillable = [
    'feedback_id'
    ,'status'
    ,'note'
    ,'created_by'
    ];
    protected $dates = ['deleted_at'];
}