<?php

namespace App\Http\Controllers;

use App\JenisPt;
use App\Kelas;
use App\KelasCategories;
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
        $categories = Kelas::first()->category->pluck('name','id')->toArray();
        $category = [];
        foreach ($categories as $cats){
            $category[] = $cats;
        }
        return view('jenis_pertanyaan.index')
            ->with('kelas', $kelas)
            ->with('categories',$category);
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
        $categories = $request['categories'];
        $kelas_category = KelasCategories::where('id_kelas','=',$kelas)->where('id_category','=',$categories)->first();
//        return $request;
//        return $kelas_category;
        $model = new JenisPt();
        $model->name = $name;
        $model->kelas_category = $kelas_category['id'];

        if($model->save())
        {
            return response()->json([
                'message' => '1 record inserted',
                'sukses' => true,
                'request' => $request
            ], 200);
        }
        else
            return response()->json([
                'message' => 'Insert Failed',
                'sukses' => false,
                'request' => $request
            ], 500);

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
        $model = JenisPt::find($id);
        return $model;
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
        $model = JenisPt::find($id);
        $model->destroy();

        return response()->json([
            'success' => true,
            'message' => 'Record id ' . $id . ' has been deleted !'
        ], 200);

    }

    public function getDatatables()
    {
        $data = JenisPt::join('kelas_categories','kelas_categories.id','=','jenis_pt.kelas_category')
            ->join('categories','kelas_categories.id_category','=','categories.id')
            ->join('kelas','kelas_categories.id_kelas','=','kelas.id')
            ->select(['jenis_pt.id as id', 'jenis_pt.name as jenispt_name', 'categories.name as categories_name','kelas.name as kelas_name']);

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
