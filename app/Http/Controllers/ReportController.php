<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Form;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Angkets;
use App\Matakuliah;
//use Collective\Html\FormBuilder;
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

    /*
       SELECT
          angkets.periode,
          mt.semester,
        --   p.id,
          jpt.name               AS jenis_pertanyaan,
          p.text,
          round(avg(ad.rate), 2) AS avg_rate
        FROM angketumb.angkets a INNER JOIN angketumb.angket_details ad ON angkets.id = ad.angket_id
          INNER JOIN angketumb.pertanyaan p ON p.id = ad.id_pt
          INNER JOIN angketumb.jenis_pt jpt ON jpt.id = p.jenis_pt
          INNER JOIN angketumb.jadwal_mhs jm ON jm.id = angkets.id_jadwal_mhs
          INNER JOIN angketumb.jadwal j ON j.id = jm.id_jadwal
          INNER JOIN angketumb.matakuliah mt ON mt.id = j.id_matkul
        WHERE jpt.name != 'Performansi Dosen'
          AND angkets.periode = '2016/2017'
          AND mt.semester = 'Ganjil'
        GROUP BY
          angkets.periode,
          mt.semester,
        --   p.id,
          jpt.name,
          p.text
        ORDER BY 4;
    */
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
            ->orderBy('avg_rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                /*
                 * $edit = '<a href="' . route('jadwal.edit', $data->jadwal_id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('jadwal.destroy', $data->jadwal_id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                */
//                return 'button detail';
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

    public function datatables_performance()
    {
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
                /*
                 * $edit = '<a href="' . route('jadwal.edit', $data->jadwal_id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('jadwal.destroy', $data->jadwal_id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                */
            })
            ->make(true);

        return $datatables;
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
                /*
                 * $edit = '<a href="' . route('jadwal.edit', $data->jadwal_id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete = "<form action='" . route('jadwal.destroy', $data->jadwal_id) . "' method='POST'>";
                $delete .= "<input type='hidden' name='_method' value='DELETE'>";
                $delete .= csrf_field();
                $delete .= '<button type="submit" id="btn-delete" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"> Delete</i></button>';
                $delete .= '</form>';
                */
//                return 'button detail';
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

//        return $data->toSql();
        return $datatables;
    }
}
