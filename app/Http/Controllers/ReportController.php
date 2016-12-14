<?php

namespace App\Http\Controllers;

use App\Issue;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Angkets;
use App\Matakuliah;
use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Auth;

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

        return view('report.general_detail')
            ->with('pertanyaan', $pertanyaan)
            ->with('semester', $semester)
            ->with('periode', $periode);
    }

    public function datatables_general(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $current_role = Auth::user()->role->name;
        $data = DB::table('report_issue_general_new')
            ->select(DB::Raw('
                periode,semester,category,jenis_pertanyaan,text,round(avg(rate),2) as rate
            '))
            ->groupBy(DB::Raw('periode,semester,category,jenis_pertanyaan,text'));

        if (empty($periode) and empty($semester)) {
            $data = $data
//                ->where('jpt.name', '!=', 'Performansi Dosen')
                ->where('periode', '=', '2016/2017')
                ->where('semester', '=', 'Ganjil');
        } else
            $data = $data
                ->where('periode', '=', $periode)
                ->where('semester', '=', $semester);
        if ($current_role == "SDM") {
            $data = $data->where('category', '=', 'Dosen');
        } elseif ($current_role == "KAPRODI") {
            $data = $data->where('category', '=', 'Dosen');
        } elseif ($current_role == "BJM") {
            $data = $data->where('category', '=', 'Belajar Mengajar');
        } elseif ($current_role == "POP") {
            $data = $data->whereIn('category', ['Sarana Prasarana Kelas', 'Pelayanan Umum']);
            /*} elseif ($current_role == "BJM") {
                $data = $data->whereIn('category', ['Pelayanan Unit']);*/
        } else
            $data = $data;

        $data = $data->orderBy('rate')->limit(10);

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

        $data = DB::table('report_issue_general_new')
            ->where('periode', '=', $periode)
            ->where('semester', '=', $semester)
            ->where('text', '=', $pertanyaan);

        $data = $data->orderBy('rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $issue = Issue::where('periode', '=', $data->periode)
                    ->where('semester', '=', $data->semester)
                    ->where('jenis_pertanyaan', '=', $data->jenis_pertanyaan)
                    ->where('ruang', '=', $data->ruang)
                    ->where('pertanyaan', '=', $data->text)
                    ->where('avg_rate', '=', $data->rate)
                    ->first();
                if (empty($issue)) {
                    $detail = "<form action='" . route('issue.store') . "' method='POST'>";
                    $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                    $detail .= FormFacade::hidden('semester', $data->semester, []);
                    $detail .= FormFacade::hidden('periode', $data->periode, []);
                    $detail .= FormFacade::hidden('jenis_pertanyaan', $data->jenis_pertanyaan, []);
                    $detail .= FormFacade::hidden('ruang', $data->ruang, []);
                    $detail .= FormFacade::hidden('avg_rate', $data->rate, []);
                    $detail .= FormFacade::hidden('category', $data->category, []);
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

        return view('report.perf_detail')
            ->with('pertanyaan', $pertanyaan)
            ->with('semester', $semester)
            ->with('periode', $periode);
    }

    public function datatables_performance(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];

        $data = DB::table('report_issue_dosen_new')
            ->select(DB::Raw('periode,semester,jenis_pertanyaan,text,round(avg(rate),2) as rate'))
            ->groupBy(DB::Raw('periode,semester,jenis_pertanyaan,text'));

        if (empty($periode) and empty($semester)) {
            $data = $data
                ->where('periode', '=', '2016/2017')
                ->where('semester', '=', 'Ganjil');
        } else
            $data = $data
                ->where('periode', '=', $periode)
                ->where('semester', '=', $semester);

        $data = $data->orderBy('rate');

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

        $data = DB::table('report_issue_dosen_new')
            ->where('periode', '=', $periode)
            ->where('semester', '=', $semester)
            ->where('text', '=', $pertanyaan);

        $data = $data->orderBy('rate');

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $issue = Issue::where('periode', '=', $data->periode)
                    ->where('semester', '=', $data->semester)
                    ->where('jenis_pertanyaan', '=', $data->jenis_pertanyaan)
                    ->where('ruang', '=', $data->ruang)
                    ->where('pertanyaan', '=', $data->text)
                    ->where('avg_rate', '=', $data->rate)
                    ->first();
                if (empty($issue)) {
                    $detail = "<form action='" . route('issue.store') . "' method='POST'>";
                    $detail .= FormFacade::hidden('pertanyaan', $data->text, []);
                    $detail .= FormFacade::hidden('semester', $data->semester, []);
                    $detail .= FormFacade::hidden('periode', $data->periode, []);
                    $detail .= FormFacade::hidden('jenis_pertanyaan', $data->jenis_pertanyaan, []);
                    $detail .= FormFacade::hidden('ruang', $data->ruang, []);
                    $detail .= FormFacade::hidden('dosen', $data->dosen, []);
                    $detail .= FormFacade::hidden('matkul', $data->matkul, []);
                    $detail .= FormFacade::hidden('avg_rate', $data->rate, []);
                    $detail .= FormFacade::hidden('category', $data->category, []);
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

    public function index_penilaian_mhs()
    {
        $periode = DB::table('report_penilaian_mhs')->pluck('periode', 'periode');
        $semester = DB::table('report_penilaian_mhs')->pluck('semester', 'semester');

        return view('report.index_penilaian_mhs')->with('periode', $periode)->with('semester', $semester);
    }

    public function datatables_penilaian_mhs(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $data = DB::table('report_penilaian_mhs');

        if (empty($periode) and empty($semester)) {
            $data = $data
                ->where('periode', '=', '2016/2017')
                ->where('semester', '=', 'Ganjil');
        } else
            $data = $data
                ->where('periode', '=', $periode)
                ->where('semester', '=', $semester);

        $datatables = Datatables::of($data)
            ->addColumn('rating', function ($data) {
                $nilai = ($data->avg_rate / 5) * 100;
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
                $rating = '<div class="progress progress-xs">
                <div class="' . $barstyle . '" style="width: ' . $nilai . '%">
                </div>
                </div>';

                return $rating;
            })->addColumn('avg_rate', function ($data) {
                $nilai = ($data->avg_rate / 5) * 100;
                if ($nilai == 100) {
                    $badgestyle = 'badge bg-light-blue';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $badgestyle = 'badge bg-green';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $badgestyle = 'badge bg-yellow';
                } elseif ($nilai < 50) {
                    $badgestyle = 'badge bg-red';
                }
                $rating = '<span class="' . $badgestyle . '">' . $nilai . '%</span>';

                return $rating;
            })
            ->make(true);

        return $datatables;
    }

    public function index_rating_dosen()
    {

        $periode = DB::table('report_issue_dosen_new')->pluck('periode', 'periode');
        $semester = DB::table('report_issue_dosen_new')->pluck('semester', 'semester');
        $dosen = DB::table('report_issue_dosen_new')->pluck('dosen', 'id_dosen');
        $dosen->put('all', 'All');
        $semester->put('all', 'All');
        $periode->put('all', 'All');

        return view('report.rating_dosen')->with('periode', $periode)->with('semester', $semester)->with('dosen', $dosen);
    }

    public function datatables_rating_dosen(Request $request)
    {

        $periode = $request['periode'];
        $semester = $request['semester'];
        $id_dosen = $request['dosen'];

        $data = DB::table('report_issue_dosen_new')
            ->select(DB::Raw('periode,
              semester,
              id_dosen,
              dosen,
              round(avg(rate),2) as rate'))
            ->groupBy(DB::raw('
              periode,
              semester,
              id_dosen,
              dosen'));

        if (empty($periode) and empty($semester) and empty($id_dosen)) {
            $data = $data
                ->where('periode', '=', '2016/2017')
                ->where('semester', '=', 'Ganjil');
        } else {
            if ($id_dosen != "all") {
                $data = $data->where('id_dosen', '=', $id_dosen);
            }
            if ($periode != 'all') {
                $data = $data->where('periode', '=', $periode);
            }
            if ($semester != 'all') {
                $data = $data->where('semester', '=', $semester);
            }
        }
//        $data = $data->orderBy('rate','desc');
        $datatables = Datatables::of($data)
            ->addColumn('rating', function ($data) {
                $barstyle = '';
                $nilai = ($data->rate / 5) * 100;
                if ($nilai == 100) {
                    $barstyle = 'progress-bar progress-bar-primary';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $barstyle = 'progress-bar progress-bar-success';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $barstyle = 'progress-bar progress-bar-yellow';
                } elseif ($nilai < 50) {
                    $barstyle = 'progress-bar progress-bar-danger';
                }
                $rating = '<div class="progress progress-xs">
                <div class="' . $barstyle . '" style="width: ' . $nilai . '%">
                </div>
                </div>';

                return $rating;
            })->addColumn('rate', function ($data) {
                $badgestyle = '';
                $nilai = ($data->rate / 5) * 100;
                if ($nilai == 100) {
                    $badgestyle = 'badge bg-light-blue';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $badgestyle = 'badge bg-green';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $badgestyle = 'badge bg-yellow';
                } elseif ($nilai < 50) {
                    $badgestyle = 'badge bg-red';
                }
                $rating = '<span class="' . $badgestyle . '">' . $nilai . '%</span>';

                return $rating;
            })
            ->addColumn('detail', function ($data) {
                $button = "<a class = 'btn btn-info' href=" . route('report.index_detail_rating_dosen', $data->id_dosen) . ">Lihat Detail</a>";
                return $button;
            })
            ->make(true);

        return $datatables;
    }

    public function index_detail_rating_dosen($id)
    {
        $periode = DB::table('report_issue_dosen_new')->pluck('periode', 'periode');
        $semester = DB::table('report_issue_dosen_new')->pluck('semester', 'semester');
        $semester->put('all', 'All');
        $periode->put('all', 'All');
        $dosen = User::find($id);
        return view('report.rating_dosen_detail')->with('periode', $periode)->with('semester', $semester)->with('dosen', $dosen);
    }

    public function datatables_detail_rating(Request $request)
    {
        $periode = $request['periode'];
        $semester = $request['semester'];
        $id_dosen = $request['dosen'];

        $data = DB::table('report_issue_dosen_new')
            ->where('id_dosen', '=', $id_dosen)
            ->select(DB::Raw('periode,
              semester,
              text,
              id_dosen,           
              dosen,
              round(avg(rate),2) as rate'))
            ->groupBy(DB::raw('
              periode,
              semester,
              text,
              id_dosen,
              dosen'));

        if (empty($periode) and empty($semester)) {
            $data = $data
                ->where('periode', '=', '2016/2017')
                ->where('semester', '=', 'Ganjil');
        } else {
            if ($periode != 'all') {
                $data = $data->where('periode', '=', $periode);
            }
            if ($semester != 'all') {
                $data = $data->where('semester', '=', $semester);
            }
        }

        $datatables = Datatables::of($data)
            ->addColumn('rating', function ($data) {
                $barstyle = '';
                $nilai = ($data->rate / 5) * 100;
                if ($nilai == 100) {
                    $barstyle = 'progress-bar progress-bar-primary';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $barstyle = 'progress-bar progress-bar-success';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $barstyle = 'progress-bar progress-bar-yellow';
                } elseif ($nilai < 50) {
                    $barstyle = 'progress-bar progress-bar-danger';
                }
                $rating = '<div class="progress progress-xs">
                <div class="' . $barstyle . '" style="width: ' . $nilai . '%">
                </div>
                </div>';

                return $rating;
            })->addColumn('rate', function ($data) {
                $badgestyle = '';
                $nilai = ($data->rate / 5) * 100;
                if ($nilai == 100) {
                    $badgestyle = 'badge bg-light-blue';
                } elseif ($nilai >= 75 and $nilai < 100) {
                    $badgestyle = 'badge bg-green';
                } elseif ($nilai >= 50 and $nilai < 75) {
                    $badgestyle = 'badge bg-yellow';
                } elseif ($nilai < 50) {
                    $badgestyle = 'badge bg-red';
                }
                $rating = '<span class="' . $badgestyle . '">' . $nilai . '%</span>';

                return $rating;
            })
            ->make(true);

        return $datatables;
    }
}