<?php

namespace App\Http\Controllers;

use App\Categories;
use App\JenisPt;
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
//        return $category;
        return view('kelas.index')->with('category', $category);
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
                'status' => 'OK',
                'message' => 'Row Inserted !'
            ], 200);
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
        $model = Kelas::find($id);
        $selected_category = clone $model;
        $selected_category= $selected_category->category->pluck('id');
        $selected = [];

        $category = Categories::select('id', 'name')->get()->toArray();
        foreach ($selected_category as $select) {
            $selected[] = $select;
        }
        return view('kelas.edit')->with('model',$model)
            ->with('selected',$selected)
            ->with('category',$category);
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
        $name = $request['name'];
        $categories = $request['categories'];
        $status = $request['status'];

//        return dd($request);
        $model = Kelas::find($id);
        $model->name = $name;
        $model->status = $status;
        $model->save();

        KelasCategories::where('id_kelas','=',$id)->delete();
        foreach ($categories as $category){
            $kelas_categories = new KelasCategories();
            $kelas_categories->id_kelas = $id;
            $kelas_categories->id_category = $category;
            $kelas_categories->save();
        }

        return redirect()->route('kelas.index')->with('status','Data has been successfully updated !');
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
//        return 'DELETE RECORD ID '.$id;
        $model = Kelas::find($id);
        $model->delete($id);

        return redirect()->route('kelas.index')->with('status', 'Record successfully deleted !');
    }

    public function getDatatables()
    {
        $data = Kelas::select(['id', 'name', 'status']);

        $datatables = Datatables::of($data)
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    $status = 'ACTIVE';
                }
                else
                    $status = 'INACTIVE';

                return $status;
            })
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('kelas.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('kelas.destroy', $data->id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                return $edit . $delete;
            })
//            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

        return $datatables;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function kelas_categories($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas_category = $kelas->category;
        $jenispt = [];
        $list_categories = [];

//        return $kelas_category;

        $select_categories = '<select id="categories" name="categories" class="form-control select2">';
        foreach ($kelas_category as $kc){
            $select_categories .= "<option value='$kc->id'>$kc->name</option>";;
        }
        $select_categories .= '</select>';

//        return $select_categories;
        /*
         * foreach ($kelas->category as $kelass) {
            $list_categories[] = [$kelass->id => $kelass->name];
        }
        foreach ($kelas->jenispt as $jenis_pt) {
            $jenispt[] = [$jenis_pt->id => $jenis_pt->name];
        }

//        return $jenispt;
        $select_categories = '<select id="categories" name="categories" class="form-control select2">';
        foreach ($list_categories as $list_category) {
            foreach ($list_category as $key => $value) {
                $select_categories .= "<option value='$key'>$value</option>";
            }
        }
        $select_categories .= '</select>';
        $select_jenispt = '<select id="jenispt" name="jenispt" class="form-control select2">';
        foreach ($jenispt as $list_jenispt) {
            foreach ($list_jenispt as $key => $value) {
                $select_jenispt .= "<option value='$key'>$value</option>";
            }
        }
        $select_jenispt .= '</select>';
        */

        return response()
            ->json(['select_categories' => $select_categories], 200);
    }

    public function getJenisPt($id){
        $model = Kelas::find($id)->jenispt2;
        return $model;
    }

    public function getJenisPTCat(Request $request){
        $kelas = $request['kelas'];
        $categories = $request['categories'];

        $kelas = Kelas::find($kelas);
        $kelas_categories = $kelas->kelas_categories->where('id_category','=',$categories);
//        return $kelas_categories;
//        return $kelas_categories->where('id_category','=',$categories);
        $kc_array = [];
        foreach ($kelas_categories as $kc){
            $kc_array[] = $kc->id;
        }

        $jenispt = JenisPt::whereIn('kelas_category',$kc_array)->get();

        $select_jenispt = '<select id="jenispt" name="jenispt" class="form-control select2">';
        foreach ($jenispt as $jp){
            $select_jenispt .= "<option value='$jp->id'>$jp->name</option>";
        }
        $select_jenispt .= '</select>';

        return response()
            ->json(['select_jenispt' => $select_jenispt], 200);
    }
}
