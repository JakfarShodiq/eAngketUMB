<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Roles;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|digits_between:1,16|numeric',
            'identity_number' => 'required|numeric|unique:users,identity_number',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id'   => $data['role_id'],
            'identity_number'   => $data['identity_number'],
            'username'  =>  $data['identity_number'],
            'address'   => $data['address'],
            'phone'   => $data['phone'],
            'education'   => $data['education'],
            'gender'    =>  $data['gender'],
            'birth_place'   =>  $data['birth_place'],
            'birth_date'    =>  $data['birth_date'],
            'join_date' =>  date('Y-m-d')
        ]);
    }

    public function showRegistrationForm()
    {
        $roles = Roles::all()->pluck('name','id');
        return view('auth.register')
            ->with('roles',$roles);
    }
}
