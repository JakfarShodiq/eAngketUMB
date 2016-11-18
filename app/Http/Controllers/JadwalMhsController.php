<?php

namespace App\Http\Controllers;

use App\User;
use Dompdf\Exception;
use Illuminate\Auth\Access\Response;
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
        $mahasiswa = User::where('role_id', '=', 1)->pluck('name', 'id');
        $role = Auth::user()->role->name;

        return view('jadwal_mhs.index')->with('mahasiswa', $mahasiswa)
            ->with('role', $role);
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
        $id_mhs = $request['id_mhs'];
        $id_jadwals = $request['id_jadwal'];

        try {
            foreach ($id_jadwals as $id_jadwal) {
                $model = new Jadwal_Mhs();
                $model->id_mhs = $id_mhs;
                $model->id_jadwal = $id_jadwal;
                $model->save();
            }

            return response()->json([
                'success' => false,
                'message' => 'Record has been Inserted !'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
        }
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
        $model = Jadwal_Mhs::find($id)->delete();
        return redirect()->route('jadwal-mhs.index')->with('status','Record Successfully Deleted !')->with('alert_style','alert-success');
    }

    public function getJadwalDatatables()
    {
        $data = Jadwal::join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id')
            ->select(DB::raw('jadwal.id as jadwal_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->addColumn('check', function ($data) {
                return FormFacade::checkbox('id', $data->jadwal_id);
//                return $data->jadwal_id;
            })
            ->make(true);

        return $datatables;
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
                $delete = "<form action='" . route('jadwal-mhs.destroy', $data->jadwal_mhs_id) . "' method='POST'>";
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
