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
        $jadwal = Jadwal::find($id)
            ->join('jadwal_mhs as jmh', 'jmh.id_jadwal', '=', 'jadwal.id')
            ->join('angkets as a', 'a.id_jadwal_mhs', '=', 'jmh.id')
            ->join('angket_details as ad', 'ad.angket_id', '=', 'a.id')
            ->join('pertanyaan as p', 'p.id', '=', 'ad.id_pt')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('kelas_categories as kc', 'kc.id', '=', 'jpt.kelas_category')
            ->join('categories as ct', 'ct.id', '=', 'kc.id_category')
            ->where('jadwal.id', '=', $id)
            ->where('ct.name', '=', 'Dosen')
            ->select(DB::raw('ad.id_pt,jpt.name,p.text,round(avg(ad.rate),1) as avg_rate'))
            ->groupBy(DB::raw('
                ad.id_pt,
                jpt.name,
                p.text'))
            ->get();

        if ($jadwal->count() < 1 ) {
            $data = '';
        } else {
            $data = '<table class="table table-condensed">
            <tr>
                <th style="width: 10px">#</th>
                <th>Pertanyaan</th>
                <th>Rating</th>
                <th style="width: 40px">Persentase</th>
            </tr>';
            $counter = 1;
            foreach ($jadwal as $jadwals) {
                $data .= '<tr>';
                $data .= '<td>' . $counter . '</td>';
                $data .= '<td>' . $jadwals->text . '</td>';
                $nilai = ($jadwals->avg_rate / 5) * 100;
                if ($nilai == 100) {
                    $barstyle = 'progress-bar progress-bar-primary';
                    $badgestyle = 'badge bg-light-blue';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $barstyle = 'progress-bar progress-bar-success';
                    $badgestyle = 'badge bg-grenn';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $barstyle = 'progress-bar progress-bar-yellow';
                    $badgestyle = 'badge bg-yellow';
                } elseif ($nilai < 50) {
                    $barstyle = 'progress-bar progress-bar-danger';
                    $badgestyle = 'badge bg-red';
                }
                $data .= '<td>
                    <div class="progress progress-xs">
                        <div class="' . $barstyle . '" style="width: ' . $nilai . '%"></div>
                    </div>
                </td>';
                $data .= '<td><span class="' . $badgestyle . '">' . $nilai . '%</span></td>';
                $data .= '</tr>';
                $counter++;
            }
            $data .= '</table>';
        }

        return response()->json([
            'success' => true,
            'message' => 'SUKSES !',
            'data' => $data
        ], 200);

    }
}
