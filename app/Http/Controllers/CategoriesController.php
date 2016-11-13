<?php

namespace App\Http\Controllers;

use App\PicCategories;
use App\Roles;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use App\Categories;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Facades\Datatables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::where('id', '>', 1)->select('id', 'name')->get()->toArray();
        return View('categories.index')
            ->with('roles', $roles);
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
        $name = $request['name'];
        $status = $request['status'];
        $pic = $request['pic'];

        $model = new Categories();
        $model->name = $name;
        $model->status = $status;
        $model->save();

        foreach ($pic as $pics) {
            $pic_categories = new PicCategories();
            $pic_categories->role_id = $pics;
            $pic_categories->category_id = $model->id;
            $pic_categories->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Record Successfully inserted !'
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
        $model = Categories::find($id);
        $roles = Roles::where('id', '>', 1)->select('id', 'name')->get()->toArray();
        $selected_id = clone $model;
        $selected_id = $selected_id->roles->pluck('id');
        $selected = [];
        foreach ($selected_id as $select) {
            $selected[] = $select;
        }
//        return var_dump($selected);
//        return $selected_id;
        return View('categories.edit')->with('model', $model)
            ->with('roles', $roles)
            ->with('selected', $selected);
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
        $status = $request['status'];
        $pic = $request['pic'];

        $model = Categories::find($id);
        $model->name    = $name;
        $model->status  = $status;
        $model->save();

        // DELETE model id in pic_categories
        $pic_categories = PicCategories::where('category_id', '=', $id)->delete();
        foreach ($pic as $pics) {
            $pic_categories_model = new PicCategories();
            $pic_categories_model->category_id = $id;
            $pic_categories_model->role_id = $pics;
            $pic_categories_model->save();
        }

        return redirect()->route('categories.index');
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
        $model = Categories::find($id);
        $model->delete();

        return redirect()->route('categories.index');
    }

    public function testRelation()
    {
        $model = Categories::first()->roles;
        foreach ($model as $role) {
            echo $role->name;
        }
    }

    public function getDatatables()
    {
        $data = Categories::select(['id', 'name', 'status']);

        $datatables = Datatables::of($data)
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    $status = 'ACTIVE';
                } else
                    $status = 'INACTIVE';

                return $status;
            })
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('categories.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('categories.destroy', $data->id) . "' method='POST'>";
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
}
