<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Jadwal_Mhs;
use App\Angkets;
use Illuminate\Support\Facades\DB;

class AngketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('angkets.index');
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

    public function getMhsDatatable()
    {

        $roles = Auth::user()->role->name;
        $id_mhs = Auth::user()->id;

        $filter = 'id_mhs = ' . $id_mhs;


        $data = Jadwal_Mhs::join('jadwal', 'jadwal_mhs.id_jadwal', '=', 'jadwal.id')
            ->join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id');

        if ($roles == "Mahasiswa") {
            $data = $data->whereRaw($filter);
        }


        $data = $data->select(DB::raw('jadwal_mhs.id as jadwal_mhs_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));
        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $action = '<a href="' . route('angket.jadwal', $data->jadwal_mhs_id) . '" class="btn btn-xs btn-info">Isi Survey</i></a>';
                return $action;
            })
            ->make(true);

        return $datatables;
    }

    /**
     * @return string
     */
    public function jadwal($id)
    {
        return ;
    }
}
