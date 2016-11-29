<?php

namespace App\Http\Controllers;

use App\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pengumuman.index');
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
        $id_ticket = $request['id_ticket'];
        $note = $request['note'];
        $user_id = Auth::user()->id;

        $model = new Pengumuman();
        $model->id_feedbacks    = $id_ticket;
        $model->note    = $note;
        $model->created_by  = $user_id;

        if($model->save()){
            return redirect()->route('pengumuman.index')->with('status','Pengumuman sudah dibuat');
        }
        else{
            return redirect()->route('pengumuman.index')->with('status','Pengumuman gagal dibuat');
        }
//        return $id_ticket.$note.$user_id;
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
        $model = Pengumuman::find($id);
        if($model->delete()){
            return redirect()->route('pengumuman.index')->with('status','Pengumuman sudah dihapus');
        }
        else{
            return redirect()->route('pengumuman.index')->with('status','Pengumuman gagal dihapus');
        }
    }

    public function getPengumuman(){
        $data = Pengumuman::select(DB::Raw('id,id_feedbacks,note,created_at'));

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $delete = "<form action='" . route('pengumuman.destroy', $data->id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                return $delete;
            })
            ->make(true);

        return $datatables;
    }
}
