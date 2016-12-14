<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;
use App\Feedbacks;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('issue.index');
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
        $periode = $request['periode'];
        $semester = $request['semester'];
        $pertanyaan = $request['pertanyaan'];
        $jenis_pertanyaan = $request['jenis_pertanyaan'];
        $ruang = $request['ruang'];
        $avg_rate = $request['avg_rate'];
        $category = $request['category'];

        if (empty($request['dosen'])) {
            $nama_dosen = null;
        } else
            $nama_dosen = $request['dosen'];

        if (empty($request['matkul'])) {
            $matakuliah = null;
        } else
            $matakuliah = $request['matkul'];

        $model = new Issue();
        $model->periode = $periode;
        $model->semester = $semester;
        $model->pertanyaan = $pertanyaan;
        $model->jenis_pertanyaan = $jenis_pertanyaan;
        $model->ruang = $ruang;
        $model->avg_rate = $avg_rate;
        $model->nama_dosen = $nama_dosen;
        $model->matakuliah = $matakuliah;
        $model->category = $category;

        if ($model->save()) {
            return redirect()->route('issue.store')->with('status', 'Record has been inserted !');
        } else
            return redirect()->route('issue.store')->with('status', 'Fail to insert Issue !');
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

        $data = Issue::all();
        $current_role = Auth::user()->role->name;
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
        $query = clone $data;
        Log::info($current_role);
        Log::info('TEST OM');
//        Log::info($query->toSql());
        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $ticket = Feedbacks::where('id_issue', '=', $data->id)->first();

                if (empty($ticket)) {
                    $button = FormFacade::open([
                        'method' => 'get',
                        'url' => route('ticket.create')
                    ]);
                    $button .= FormFacade::hidden('issue_id', $data->id);
                    $button .= FormFacade::submit('Buat Ticket', ['class' => 'btn btn-success']);
                    $button .= FormFacade::close();
                } else {
                    $button = FormFacade::open([
                        'method' => 'get',
                        'url' => route('ticket.edit', $ticket->id)
                    ]);
                    $button .= FormFacade::submit('Lihat Ticket', ['class' => 'btn btn-success']);
                    $button .= FormFacade::close();
                }

                return $button;
            })
            ->make(true);

        return $datatables;
    }
}
