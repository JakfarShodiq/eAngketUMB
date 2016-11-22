<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Jadwal_Mhs;
use App\Angkets;
use Illuminate\Support\Facades\DB;
use App\Angket_Details;
use Illuminate\Support\Facades\Log;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = $request['id'];
        $note = $request['note'];
        $pt = $request->input();
        unset($pt["id"]);
        unset($pt["_token"]);
        unset($pt["note"]);

//        return dd($pt,'<br>',$note,$id);
//        INSERT INTO DETAILS
        foreach ($pt as $key => $value) {
            $angket_details = new Angket_Details();
            $angket_details->angket_id = $id;
            $angket_details->id_pt = $key;
            $angket_details->rate = $value;
            $angket_details->save();
        }

        $model = Angkets::find($id);
        $model->state = 2;
        $model->note = $note;
        $model->save();

        return redirect()->route('angket.index')->with('status', 'Angket sudah berhasil diisi !');
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
        $angkets = Angkets::find($id);
        $note = $angkets->note;
//        return $angkets;
        $user = User::find($angkets->id_mhs);
        $pertanyaan = clone $angkets;
        $pertanyaan = $pertanyaan
            ->join('angket_details as ad', 'ad.angket_id', '=', 'angkets.id')
            ->join('pertanyaan as p', 'ad.id_pt', '=', 'p.id')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
        ->where('angkets.id','=',$angkets->id);
//        Log::info($pertanyaan->toSql());
//            ->select(DB::raw('p.id,p.text'));
//        return $pertanyaan->get();

        $jenispt = clone $pertanyaan;
        $matkul = clone $pertanyaan;
        $jenispt = $jenispt->select(DB::raw('distinct(jpt.name) as categories'))->orderBy('categories')->get();

        $matkul = $matkul->join('jadwal_mhs','jadwal_mhs.id','=','angkets.id_jadwal_mhs')
            ->join('jadwal','jadwal.id','=','jadwal_mhs.id_jadwal')
            ->join('matakuliah','matakuliah.id','=','jadwal.id_matkul')
            ->select(DB::raw('distinct(matakuliah.name) as matkul'))->first();
        $pertanyaan = $pertanyaan->select(DB::raw('p.id,jpt.name as jpt,p.text as pertanyaan,ad.rate'))->get();

        return view('angkets.show')
            ->with('user', $user)
            ->with('note', $note)
            ->with('jenispt', $jenispt)
            ->with('matkul', $matkul)
            ->with('pertanyaan', $pertanyaan);
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
                $angkets = Angkets::where('id_jadwal_mhs', '=', $data->jadwal_mhs_id)
                    ->where('id_mhs', '=', Auth::user()->id)->first();
                if (!empty($angkets) AND $angkets->state == 2) {
                    $action = '<a href="' . route('angket.show', $angkets->id) . '" class="btn btn-xs btn-info">Lihat Survey</i></a>';
                } else
                    $action = '<a href="' . route('angket.jadwal', $data->jadwal_mhs_id) . '" class="btn btn-xs btn-success">Isi Survey</i></a>';
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
        $id_angkets = Angkets::where('id_jadwal_mhs', '=', $id)
            ->where('id_mhs', '=', Auth::user()->id)->first();

        if (empty($id_angkets->id)) {
            $angkets = new Angkets();
            $angkets->id_jadwal_mhs = $id;
            $angkets->id_mhs = Auth::user()->id;
            $angkets->state = 1;
            $angkets->periode = date('Y') . '/' . date('Y', strtotime('+1 year'));
            $angkets->save();
//        $jadwal_model = $angkets->find($angkets->id)->select('');
            $id_angkets = clone $angkets;
        }
//        Jadwal_Mhs::find($id)->join('jadwal as j', 'jadwal_mhs.id_jadwal', '=', 'j.id')
        $pertanyaan = Angkets::find($id_angkets->id)
            ->join('jadwal_mhs', 'jadwal_mhs.id', '=', 'angkets.id_jadwal_mhs')
            ->join('jadwal as j', 'jadwal_mhs.id_jadwal', '=', 'j.id')
            ->join('matakuliah as mt', 'j.id_matkul', '=', 'mt.id')
            ->join('kelas as k', 'k.id', '=', 'mt.id_kelas')
            ->join('kelas_categories as kc', 'kc.id_kelas', '=', 'k.id')
            ->join('jenis_pt as jpt', 'jpt.kelas_category', '=', 'kc.id')
            ->join('categories as c', 'c.id', '=', 'kc.id_category')
            ->join('pertanyaan as p', 'p.jenis_pt', '=', 'jpt.id')
            ->where('jadwal_mhs.id', '=', $id);
//            ->select(DB::raw('p.id,p.text'));

//        return $pertanyaan->toSql();
        $jenispt = clone $pertanyaan;
        $matkul = clone $pertanyaan;
        $jenispt = $jenispt->select(DB::raw('distinct(jpt.name) as categories'))->orderBy('categories')->get();
        $matkul = $matkul->select(DB::raw('distinct(mt.name) as matkul'))->first();

        $pertanyaan = $pertanyaan->select(DB::raw('distinct(p.id) as id,jpt.name as jpt,p.text as pertanyaan'))->get();

        return view('angkets.create')
            ->with('id', $id_angkets)
            ->with('jenispt', $jenispt)
            ->with('matkul', $matkul)
            ->with('pertanyaan', $pertanyaan);
//        return $pertanyaan;
    }
}
