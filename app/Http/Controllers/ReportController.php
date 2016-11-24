<?php

namespace App\Http\Controllers;

use App\Issue;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Form;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Angkets;
use App\Matakuliah;
use Collective\Html\FormFacade;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $periode = Angkets::select(DB::raw('distinct(periode) as periode'))->pluck('periode', 'periode');
        $semester = Matakuliah::select(DB::raw('distinct(semester) as semester'))->pluck('semester', 'semester');

//        return $semester;
        return view('report.index')
            ->with('periode', $periode)
            ->with('semester', $semester);
    }

    public function index_perf()
    {
        //
        $periode = Angkets::select(DB::raw('distinct(periode) as periode'))->pluck('periode', 'periode');
        $semester = Matakuliah::select(DB::raw('distinct(semester) as semester'))->pluck('semester', 'semester');

//        return $semester;
        return view('report.index_perf')
            ->with('periode', $periode)
            ->with('semester', $semester);
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

    public function general_detail(Request $request)
    {
        $pertanyaan = $request['pertanyaan'];
        $semester = $request['semester'];
        $periode = $request['periode'];

//        return $pertanyaan.'<br>'.$semester.'<br>'.$periode;
        return view('report.general_detail')
            ->with('pertanyaan', $pertanyaan)
            ->with('semester', $semester)
            ->with('periode', $periode);
    }

    public function datatables_general(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $data = Angkets::join('angket_details as ad', 'angkets.id', '=', 'ad.angket_id')
            ->join('pertanyaan as p', 'ad.id_pt', '=', 'p.id')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('jadwal_mhs as jm', 'jm.id', '=', 'angkets.id_jadwal_mhs')
            ->join('jadwal as j', 'j.id', '=', 'jm.id_jadwal')
            ->join('matakuliah as mt', 'mt.id', '=', 'j.id_matkul');

        if (empty($periode) and empty($semester)) {
            $data = $data->where('jpt.name', '!=', 'Performansi Dosen')
                ->where('angkets.periode', '=', '2016/2017')
                ->where('mt.semester', '=', 'Ganjil');
        } else
            $data = $data->where('jpt.name', '!=', 'Performansi Dosen')
                ->where('angkets.periode', '=', $periode)
                ->where('mt.semester', '=', $semester);

        $data = $data->select(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name               AS jenis_pertanyaan,
              p.text,
              round(avg(ad.rate), 2) AS avg_rate
            '))
            ->groupBy(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name,
              p.text
            '))
            ->orderBy('avg_rate')
            ->limit(10);

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $detail = "<form action='" . route('report.general-detail') . "' method='POST'>";
                $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                $detail .= FormFacade::hidden('semester', $data->semester, []);
                $detail .= FormFacade::hidden('periode', $data->periode, []);
                $detail .= csrf_field();
                $detail .= '<button type="submit" id="btn-delete" class="btn btn-info"><i class="glyphicon glyphicon-info-sign"> Detail</i></button>';
                $detail .= '</form>';
                return $detail;
            })
            ->make(true);

        return $datatables;
    }

    public function datatables_general_detail(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $pertanyaan = $request['pertanyaan'];

        $data = Angkets::join('angket_details as ad', 'angkets.id', '=', 'ad.angket_id')
            ->join('pertanyaan as p', 'ad.id_pt', '=', 'p.id')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('jadwal_mhs as jm', 'jm.id', '=', 'angkets.id_jadwal_mhs')
            ->join('jadwal as j', 'j.id', '=', 'jm.id_jadwal')
            ->join('matakuliah as mt', 'mt.id', '=', 'j.id_matkul')
            ->where('jpt.name', '!=', 'Performansi Dosen')
            ->where('angkets.periode', '=', $periode)
            ->where('mt.semester', '=', $semester)
            ->where('p.text', '=', $pertanyaan);

        $data = $data->select(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name               AS jenis_pertanyaan,
              j.ruang,
              p.text,
              round(avg(ad.rate), 2) AS avg_rate
            '))
            ->groupBy(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name,
              j.ruang,
              p.text
            '))
            ->orderBy('avg_rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $issue = Issue::where('periode', '=', $data->periode)
                    ->where('semester', '=', $data->semester)
                    ->where('jenis_pertanyaan', '=', $data->jenis_pertanyaan)
                    ->where('ruang', '=', $data->ruang)
                    ->where('pertanyaan', '=', $data->text)
                    ->where('avg_rate', '=', $data->avg_rate)
                    ->first();
                if (empty($issue)) {
                    $detail = "<form action='" . route('issue.store') . "' method='POST'>";
                    $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                    $detail .= FormFacade::hidden('semester', $data->semester, []);
                    $detail .= FormFacade::hidden('periode', $data->periode, []);
                    $detail .= FormFacade::hidden('jenis_pertanyaan', $data->jenis_pertanyaan, []);
                    $detail .= FormFacade::hidden('ruang', $data->ruang, []);
                    $detail .= FormFacade::hidden('avg_rate', $data->avg_rate, []);
                    $detail .= csrf_field();
                    $detail .= '<button type="submit" id="btn-delete" class="btn btn-info">Assign Issue</button>';
                    $detail .= '</form>';
                } else {
                    $detail = FormFacade::open([
                        'method' => 'get',
                        'url' => route('issue.index')
                    ]);
                    $detail .= FormFacade::submit('Lihat Issue', ['class' => 'btn btn-info']);
                    $detail .= FormFacade::close();
                }

                return $detail;
            })
            ->make(true);
        return $datatables;
    }

    public function performance_detail(Request $request)
    {
        $pertanyaan = $request['pertanyaan'];
        $semester = $request['semester'];
        $periode = $request['periode'];

//        return $pertanyaan.'<br>'.$semester.'<br>'.$periode;
        return view('report.perf_detail')
            ->with('pertanyaan', $pertanyaan)
            ->with('semester', $semester)
            ->with('periode', $periode);
    }

    public function datatables_performance(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];

        $data = Angkets::join('angket_details as ad', 'angkets.id', '=', 'ad.angket_id')
            ->join('pertanyaan as p', 'ad.id_pt', '=', 'p.id')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('jadwal_mhs as jm', 'jm.id', '=', 'angkets.id_jadwal_mhs')
            ->join('jadwal as j', 'j.id', '=', 'jm.id_jadwal')
            ->join('matakuliah as mt', 'mt.id', '=', 'j.id_matkul');

        if (empty($periode) and empty($semester)) {
            $data = $data->where('jpt.name', '=', 'Performansi Dosen')
                ->where('angkets.periode', '=', '2016/2017')
                ->where('mt.semester', '=', 'Ganjil');
        } else
            $data = $data->where('jpt.name', '=', 'Performansi Dosen')
                ->where('angkets.periode', '=', $periode)
                ->where('mt.semester', '=', $semester);

        $data = $data->select(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name               AS jenis_pertanyaan,
              p.text,
              round(avg(ad.rate), 2) AS avg_rate
            '))
            ->groupBy(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name,
              p.text
            '))
            ->orderBy('avg_rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $detail = "<form action='" . route('report.perf-detail') . "' method='POST'>";
                $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                $detail .= FormFacade::hidden('semester', $data->semester, []);
                $detail .= FormFacade::hidden('periode', $data->periode, []);
                $detail .= csrf_field();
                $detail .= '<button type="submit" id="btn-delete" class="btn btn-info"><i class="glyphicon glyphicon-info-sign"> Detail</i></button>';
                $detail .= '</form>';
                return $detail;
            })
            ->make(true);

        return $datatables;
    }

    public function datatables_performance_detail(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $pertanyaan = $request['pertanyaan'];

        $data = Angkets::join('angket_details as ad', 'angkets.id', '=', 'ad.angket_id')
            ->join('pertanyaan as p', 'ad.id_pt', '=', 'p.id')
            ->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('jadwal_mhs as jm', 'jm.id', '=', 'angkets.id_jadwal_mhs')
            ->join('jadwal as j', 'j.id', '=', 'jm.id_jadwal')
            ->join('matakuliah as mt', 'mt.id', '=', 'j.id_matkul')
            ->join('users as u', 'u.id', '=', 'j.id_dosen')
            ->where('jpt.name', '=', 'Performansi Dosen')
            ->where('angkets.periode', '=', $periode)
            ->where('mt.semester', '=', $semester)
            ->where('p.text', '=', $pertanyaan);

        $data = $data->select(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name               AS jenis_pertanyaan,
              j.ruang,
              u.name as dosen,
              mt.name as matkul,
              p.text,
              round(avg(ad.rate), 2) AS avg_rate
            '))
            ->groupBy(DB::raw('
            angkets.periode,
              mt.semester,
              jpt.name,
              j.ruang,
              u.name,
              mt.name,
              p.text
            '))
            ->orderBy('avg_rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $detail = "<form action='" . route('report.general-detail') . "' method='POST'>";
                $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                $detail .= FormFacade::hidden('semester', $data->semester, []);
                $detail .= FormFacade::hidden('periode', $data->periode, []);
                $detail .= csrf_field();
                $detail .= '<button type="submit" id="btn-delete" class="btn btn-info">Assign Issue</button>';
                $detail .= '</form>';
                return $detail;
            })
            ->make(true);
        return $datatables;
    }
}
