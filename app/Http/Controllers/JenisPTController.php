<?php

namespace App\Http\Controllers;

use App\Jenis_Pt;
use App\Kelas;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use Yajra\Datatables\Facades\Datatables;

class JenisPTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelas = Kelas::all()->pluck('name', 'id');
        return view('jenis_pertanyaan.index')
            ->with('kelas', $kelas);
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
//        dd($request);
        /* if($request->ajax()){
             dd('ajax request sent !');
         }*/
        $kelas = $request['kelas'];
        $name = $request['name'];

        $model = new Jenis_Pt();
        $model->name = $name;
        $model->kelas_category = $kelas;
        $model->save();

//        return redirect()->route('jenis_pertanyaan.index');
        return response()->json([
            'message' => '1 record inserted',
            'sukses' => true,
            'request' => $request
        ], 200);
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
        $model = Jenis_Pt::find($id);
        dd($model);
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
        $model = Jenis_Pt::find($id);
        $model->destroy();

        return response()->json([
            'success' => true,
            'message' => 'Record id ' . $id . ' has been deleted !'
        ], 200);

    }

    public function getDatatables()
    {
        $data = Jenis_Pt::select(['id', 'name', 'kelas_category']);

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('jenis_pertanyaan.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = '<a href="#" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                return $edit . $delete;
            })
//            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

        return $datatables;
    }
}
