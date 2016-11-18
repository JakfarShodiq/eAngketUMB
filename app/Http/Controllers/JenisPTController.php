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
//        return $categories;
        return view('jenis_pertanyaan.index')
            ->with('kelas', $kelas)
            ->with('categories',$categories);
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
//        return $kelas_category;
        return $kelas_category;
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
        $kelas_category = KelasCategories::find($model->kelas_category);
        $kelas = Kelas::all()->pluck('name', 'id');
        $categories = Kelas::first()->category->pluck('name','id')->toArray();
        $category = [];
        foreach ($categories as $cats){
            $category[] = $cats;
        }

        return view('jenis_pertanyaan.edit')->with('model',$model)
            ->with('select',$kelas_category)
            ->with('kelas',$kelas)
            ->with('categories',$category);
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
        $name = $request['name'];
        $model = JenisPt::find($id);
        $model->name = $name;
        $model->save();

        return redirect()->route('jenis_pertanyaan.index')->with('status', 'Record successfully updated !');
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

        $model = JenisPt::find($id)->destroy($id);

        return redirect()->route('jenis_pertanyaan.index')->with('status', 'Record successfully deleted !');
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
                $delete = "<form action='" . route('jenis_pertanyaan.destroy', $data->id) . "' method='post'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</button>';
                $delete .= '</form>';
                return $edit . $delete;
            })
//            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

        return $datatables;
    }
}
