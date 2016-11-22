<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jadwal;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dosen.index');
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
        $data = Jadwal::join('matakuliah', 'jadwal.id_matkul', '=', 'matakuliah.id')
            ->join('users', 'jadwal.id_dosen', '=', 'users.id')
            ->where('jadwal.id_dosen', '=', Auth::user()->id)
            ->select(DB::raw('jadwal.id as jadwal_id,matakuliah.name as matkul,tahun_ajaran,ruang,hari,time_start,time_end,qty,users.name as nama_dosen'));

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<button id="view-report" name="view-report" class="btn btn-success">Tampilkan</button>';
                return $button;
            })
            ->make(true);

        return $datatables;
    }

    public function nilai(Request $request)
    {
        $id = $request['id'];
//        return $id;
        $jadwal = Jadwal::find($id)
            ->join('jadwal_mhs as jmh', 'jmh.id_jadwal', '=', 'jadwal.id')
            ->join('angkets as a', 'a.id_jadwal_mhs', '=', 'jmh.id')
            ->join('angket_details as ad', 'ad.angket_id', '=', 'a.id')
            ->join('pertanyaan as p', 'p.id', '=', 'ad.id_pt')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->where('jadwal.id', '=', $id)
            ->where('jpt.name', '=', 'Performansi Dosen')
            ->select(DB::raw('ad.id_pt,jpt.name,p.text,round(avg(ad.rate),1) as avg_rate'))
            ->groupBy(DB::raw('
                ad.id_pt,
                jpt.name,
                p.text'))
            ->get();
        $data = '';


        /*
        <div class="col-xs-6">
        {{ $pertanyaans->pertanyaan }}
        </div>
        <div class="col-xs-6">
        */
        foreach ($jadwal as $jadwals) {
            $data .=  "<div class='col-xs-6'>";
            $data .=  $jadwals->text;
            $data .=  "</div>";
            $data .= "<input name='$jadwals->id_pt' id='$jadwals->id_pt' class='rating rating-loading display-rating-tok' value='$jadwals->avg_rate' data-size='xs'>";
        }

        return response()->json([
            'success' => true,
            'message' => 'SUKSES !',
            'data' => $data
        ], 200);

        /*
        select
            ad.id_pt,
              jpt.name,
              p.text,
              round(avg(ad.rate),1) as avg_rate
            from angketumb.jadwal
            INNER JOIN angketumb.jadwal_mhs on jadwal_mhs.id_jadwal = jadwal.id
            INNER JOIN angketumb.angkets on angkets.id_jadwal_mhs = jadwal_mhs.id
            INNER JOIN angketumb.angket_details ad on ad.angket_id = angkets.id
            INNER JOIN angketumb.pertanyaan p on p.id = ad.id_pt
            INNER JOIN angketumb.jenis_pt jpt on jpt.id = p.jenis_pt
            WHERE jadwal.id = 5
              AND jpt.name = 'Performansi Dosen'
            GROUP BY ad.id_pt,p.text,jpt.name
            ORDER BY avg_rate;
        */

    }
}
