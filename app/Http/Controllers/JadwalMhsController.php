<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Collective\Html\FormFacade;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Jadwal;
use App\Jadwal_Mhs;

class JadwalMhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mahasiswa = User::where('role_id','=',1)->pluck('name','id');
        $role = Auth::user()->role->name;

        return view('jadwal_mhs.index')->with('mahasiswa',$mahasiswa)
            ->with('role',$role);
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

    public function getJadwalDatatables()
    {
        $data = Jadwal::join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id')
            ->select(DB::raw('jadwal.id as jadwal_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->addColumn('check', function ($data) {
                    return FormFacade::checkbox('id', $data->jadwal_id);
            })
            ->make(true);

        return $datatables;
    }

    public function getMhsDatatable(){
        $data = Jadwal_Mhs::join('jadwal','jadwal_mhs.id_jadwal','=','jadwal.id')
            ->join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id')
            ->select(DB::raw('jadwal_mhs.id as jadwal_mhs_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->make(true);

        return $datatables;
    }

}
