<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'identity_number',
        'username',
        'address',
        'phone',
        'gender',
        'birth_date',
        'join_date',
        'education',
        'birth_place',
        'education',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Roles');
    }

    public function hasRole($id){
        $model = $this->find($id)->$this->role->name;
        return $model;
    }
}
