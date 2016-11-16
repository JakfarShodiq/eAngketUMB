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
        $dosen = User::where('role_id', '=', 2)->pluck('name', 'id');
        $matkul = Matakuliah::all()->pluck('name', 'id');
        $day = [
            'Minggu' => 'Minggu',
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
        ];
        return view('jadwal.index')
            ->with('dosen', $dosen)
            ->with('matkul', $matkul)
            ->with('day', $day);
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
        $matkul = $request['matkul'];
        $tahun_ajaran = $request['tahun_ajaran'];
        $dosen = $request['dosen'];
        $ruang  = $request['ruang'];
        $hari = $request['hari'];
        $qty = $request['qty'];
        $time_start = $request['time_start'];
        $time_end = $request['time_end'];

        if ($request->ajax()) {

            $model = new Jadwal();
            $model->tahun_ajaran    = $tahun_ajaran;
            $model->id_matkul   = $matkul;
            $model->id_dosen    = $dosen;
            $model->ruang   = $ruang;
            $model->hari    = $hari;
            $model->time_start  = $time_start;
            $model->time_end    = $time_end;
            $model->qty = $qty;

            $save_model = $model->save();

            if(!$save_model){
                return response()->json([
                    'success' => false,
                    'message' => 'Fail to save record !',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Record Successfully Inserted !',
                'result' => $request
            ], 200);
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
        $model = Jadwal::find($id);
        $dosen = User::where('role_id', '=', 2)->pluck('name', 'id');
        $matkul = Matakuliah::all()->pluck('name', 'id');
        $day = [
            'Minggu' => 'Minggu',
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
        ];
        return view('jadwal.edit')
            ->with('model', $model)
            ->with('dosen', $dosen)
            ->with('matkul', $matkul)
            ->with('day', $day);
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
        $tahun_ajaran = $request['tahun_ajaran'];
        $matkul = $request['matkul'];
        $dosen = $request['dosen'];
        $ruang = $request['ruang'];
        $hari = $request['hari'];
        $time_start = $request['time_start'];
        $time_end = $request['time_end'];
        $qty = $request['qty'];

        $model = Jadwal::find($id);
        $model->tahun_ajaran = $tahun_ajaran;
        $model->id_matkul = $matkul ;
        $model->id_dosen = $dosen;
        $model->ruang = $ruang;
        $model->hari = $hari;
        $model->time_start = $time_start;
        $model->time_end = $time_end;
        $model->qty = $qty;

        $model->save();

        return redirect()->route('jadwal.index')->with('status','Record Successfully Updated !')->with('alert_style','alert-info');
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
        $model = Jadwal::find($id)->delete();
        return redirect()->route('jadwal.index')->with('status','Record Successfully Deleted !')->with('alert_style','alert-success');
    }

    public function getDatatables()
    {
        $data = Jadwal::join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id')
            ->select(DB::raw('jadwal.id as jadwal_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('jadwal.edit', $data->jadwal_id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('jadwal.destroy', $data->jadwal_id) . "' method='POST'>";
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
