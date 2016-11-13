<?php

namespace App\Http\Controllers;

use App\Matakuliah;
use App\User;
use Illuminate\Http\Request;
use App\Jadwal;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dosen = User::where('role_id','=',2)->pluck('name','id');
        $matkul = Matakuliah::all()->pluck('name','id');
        $day = [
          'Minggu'  =>  'Minggu',
          'Senin'  =>  'Senin',
          'Selasa'  =>  'Selasa',
          'Rabu'  =>  'Rabu',
          'Kamis'  =>  'Kamis',
          'Jumat'  =>  'Jumat',
          'Sabtu'  =>  'Sabtu',
        ];
        return view('jadwal.index')
            ->with('dosen',$dosen)
            ->with('matkul',$matkul)
            ->with('day',$day);
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
    }

    public function getDatatables()
    {
        $data = Jadwal::join('matakuliah','jadwal.id_matkul','=','matakuliah.id')
            ->join('users','jadwal.id_dosen','=','users.id')
            ->select(DB::raw('matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('jadwal.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('jadwal.destroy', $data->id) . "' method='POST'>";
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
