<?php

namespace App\Http\Controllers;

use App\Roles;
use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::id();
        $model = User::find($user);
        $role = $model->role;
        return view('user.index')
            ->with('model', $model)
            ->with('role', $role);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = User::find($id);
        $role = Roles::pluck('name', 'id');
        return view('user.edit')->with('model', $model)
            ->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
//        return $request;
        $model = User::find($id);
        $model->name = $request['name'];
        $model->education = $request['education'];
        $model->address = $request['address'];
        $model->phone = $request['phone'];
        $model->email = $request['email'];

        if ($model->save()) {
            return redirect()->route('user.index')->with('status', 'Record Successfully Updated !');
        } else
            return redirect()->route('user.index')->with('status', 'Record Failed Update !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function manageUsers()
    {

        $roles = Roles::pluck('name', 'id');
        $default_roles = clone $roles;
        $roles->put('all', 'All');
        return view('user.user_mgt')
            ->with('default_roles', $default_roles)
            ->with('roles', $roles);
    }

    public function getDatatables(Request $request)
    {
        $roles = $request['role_id'];
        $name = $request['name'];
        $data = User::join('roles as r', 'users.role_id', '=', 'r.id');
        if (!empty($roles) OR !empty($name)) {
            if ($roles == 'all') {
                $data = $data->whereRaw('users.name like \'%' . $name . '%\'');
            } else
                $data = $data
                    ->where('role_id', '=', $roles)
                    ->whereRaw('users.name like \'%' . $name . '%\'');
        }

        $data = $data->select(DB::Raw('users.id as id,users.identity_number,users.name,users.role_id,r.name as role'))->get();

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $edit = "<a class='btn btn-danger' href = '".route('user.reset-password',$data->id)."'>Reset Password</a>";
                return $edit;
            })
            ->make(true);

        return $datatables;
    }

    public function resetpassword($id){

        $model = User::find($id);
        $model->password = bcrypt('123456');

        if($model->save()){
            return redirect()->route('user.role')->with('status','Password untuk '.$model->name.' telah direset');
        }
    }

    public function permission_update(Request $request){

        $id = $request['id_user'];
        $model = User::find($id);
        $model->name = $request['nama'];
        $model->identity_number = $request['identity_number'];
        $model->role_id = $request['role_id'];

        if($model->save()){
            return redirect()->route('user.role')->with('status','User '.$model->name.' telah diupdate !');
        }
    }
}
