<?php

namespace App\Http\Controllers;

use App\Categories;
use App\JenisPt;
use App\Kelas;
use App\Pertanyaan;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all()->pluck('name', 'id');
        $categories = Kelas::first()->category->pluck('name', 'id');
        $first_class = Kelas::first()->id;
        $jenispt = JenisPt::where('kelas_category', '=', $first_class)->pluck('name', 'id');
//        return $categories;
        return view('pertanyaan.index')->with('kelas', $kelas)
            ->with('categories', $categories)
            ->with('jenispt', $jenispt);
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
        $model = new Pertanyaan();
        $model->text = $request['text'];
        $model->jenis_pt = $request['jenis_pt'];
        $model->status = $request['status'];
        $model->created_by = Auth::user()->id;

        if ($model->save()) {
            return response()->json([
                'success'   =>  true,
                'messages'  => 'Record successfully inserted !'
            ],200);
        }else
            return response()->json([
                'success'   =>  false,
                'messages'  => 'Failed to save record !'
            ],500);
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
        $data = Pertanyaan::join('jenis_pt', 'pertanyaan.jenis_pt', '=', 'jenis_pt.id')
            ->join('kelas_categories', 'kelas_categories.id', '=', 'jenis_pt.kelas_category')
            ->join('categories', 'kelas_categories.id_category', '=', 'categories.id')
            ->join('kelas', 'kelas_categories.id_kelas', '=', 'kelas.id')
            ->select(['pertanyaan.id as id', 'pertanyaan.text', 'pertanyaan.status','jenis_pt.name as jenis_pt_name', 'categories.name as categories_name', 'kelas.name as kelas_name']);

        $datatables = Datatables::of($data)
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    $status = 'ACTIVE';
                } else
                    $status = 'INACTIVE';

                return $status;
            })
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('pertanyaan.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('pertanyaan.destroy', $data->id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                return $edit . $delete;
            })
            ->make(true);
        return $datatables;
    }
}
