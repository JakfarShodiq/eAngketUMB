<?php

namespace App\Http\Controllers;

use App\Roles;
use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Form;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('roles.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $name = $request['name'];
        $model = new Roles();
        $model->name = $name;

        if($model->save()){
            return redirect()->route('roles.index')->with('status', 'Record Successfully Inserted !');
        } else
            return redirect()->route('roles.index')->with('status', 'Record Failed Update !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
//        dd('test om');
        $model = Roles::find($id)->delete();

        return redirect()->route('roles.index')->with('status', 'Record successfully deleted !');
    }

    public function getDatatables(){
        $data = Roles::select(DB::raw('
        id,name,created_at
        '));
        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $delete = FormFacade::open([
                   'url'    =>  route('roles.destroy',$data->id),
                    'method'    => 'DELETE',
                ]);
                $delete .= FormFacade::submit('Delete',['class' =>  'btn btn-danger']);
                $delete .= FormFacade::close();
//                $delete = FormFacade::hidden('_method','DELETE');
//                $delete .= csrf_field();
//                $delete .= "<a class='btn btn-danger' href = '".route('roles.destroy',$data->id)."'>Delete</a>";
//                $delete = FormFacade::submit('Delete',[
//                    'method'  =>   'post',
//                    'url'   => route('roles.destroy',$data->id),
//                    'class' =>  'btn btn-danger'
//                ]);
                return $delete;
            })
            ->make(true);

        return $datatables;
    }

    public function updateRoles(Request $request){
        return $request;
    }
}
