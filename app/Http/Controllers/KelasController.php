<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Kelas;
use App\KelasCategories;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Categories::select('id', 'name')->get()->toArray();
        return view('kelas.index')
            ->with('category', $category);
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
        if ($request->ajax()) {

            $name = $request['name'];
            $status = $request['status'];
            $categories = $request['categories'];

            $model = new Kelas();
            $model->name = $name;
            $model->status = $status;
            $model->save();

            foreach ($categories as $category) {
                $kelas_category = new KelasCategories();
                $kelas_category->id_kelas = $model->id;
                $kelas_category->id_category = $category;
                $kelas_category->save();
            }

            return response()->json([
                'status'    =>  'OK',
                'message'   =>  'Row Inserted !'
            ],200);
        }
        return redirect()->route('kelas.index');
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
    }

    public function getDatatables()
    {
        $data = Kelas::select(['id', 'name', 'status']);

        $datatables = Datatables::of($data)
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    $status = 'ACTIVE';
                }
                $status = 'INACTIVE';

                return $status;
            })
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('kelas.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = '<a href="#" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                return $edit . $delete;
            })
//            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

        return $datatables;
    }
}
