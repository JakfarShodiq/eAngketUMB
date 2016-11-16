<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use App\Matakuliah;
use Yajra\Datatables\Facades\Datatables;

use App\Http\Requests;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelas = Kelas::all()->pluck('name','id');
//        return $kelas;
        return view('matakuliah.index')->with('kelas',$kelas);
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
        $semester = $request['semester'];
        $sks = $request['sks'];
        $id_kelas = $request['kelas'];

        $model = new Matakuliah();
        $model->name = $name;
        $model->semester = $semester;
        $model->sks = $sks;
        $model->id_kelas = $id_kelas;
        $model->save();

        return response()->json([
           'success'    => true,
            'message'   =>  'Record Successfully inserted !'
        ],200);
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
        $kelas = Kelas::all()->pluck('name','id');
        $model = Matakuliah::find($id);
        return view('matakuliah.edit')
            ->with('model',$model)
            ->with('kelas',$kelas);
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
        $name = $request['name'];
        $semester = $request['semester'];
        $sks = $request['sks'];
        $id_kelas = $request['kelas'];

        $model = Matakuliah::find($id);
        $model->name = $name;
        $model->semester = $semester;
        $model->sks = $sks;
        $model->id_kelas = $id_kelas;
        $model->save();

        return redirect()->route('matakuliah.index')->with('status', 'Record successfully updated !');
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
        $model = Matakuliah::find($id)->delete();

        return redirect()->route('matakuliah.index')->with('status', 'Record successfully deleted !');
    }

    public function getDatatables()
    {
        $data = Matakuliah::join('angketumb.kelas','matakuliah.id_kelas','=','kelas.id')
            ->select(['matakuliah.id', 'matakuliah.name', 'matakuliah.semester','matakuliah.sks','kelas.name as kelas_name']);
        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('matakuliah.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('matakuliah.destroy', $data->id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                return $edit . $delete;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
        return $datatables;
    }
}
