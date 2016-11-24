<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;
use App\Feedbacks;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Collective\Html\FormFacade;

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

        if (empty($request['nama_dosen'])) {
            $nama_dosen = null;
        } else
            $nama_dosen = $request['nama_dosen'];

        if (empty($request['matakuliah'])) {
            $matakuliah = null;
        } else
            $matakuliah = $request['matakuliah'];

        $model = new Issue();
        $model->periode = $periode;
        $model->semester = $semester;
        $model->pertanyaan = $pertanyaan;
        $model->jenis_pertanyaan = $jenis_pertanyaan;
        $model->ruang = $ruang;
        $model->avg_rate = $avg_rate;
        $model->nama_dosen = $nama_dosen;
        $model->matakuliah = $matakuliah;

        if($model->save()){
            return redirect()->route('issue.store')->with('status','Record has been inserted !');
        }
        else
            return redirect()->route('issue.store')->with('status','Fail to insert Issue !');
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

    public function getDatatables(){
        $data = Issue::all();

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $ticket = Feedbacks::where('id_issue','=',$data->id)->first();

                if(empty($ticket)){
                    $button = FormFacade::open([
                        'method'  =>  'get',
                        'url' =>  route('ticket.create')
                    ]);
                    $button .= FormFacade::hidden('issue_id',$data->id);
                    $button .= FormFacade::submit('Buat Ticket',['class'    =>  'btn btn-success']);
                    $button .= FormFacade::close();
                }
                else
                {
                    $button = FormFacade::open([
                        'method'  =>  'get',
                        'url' =>  route('ticket.show',$ticket->id)
                    ]);
                    $button .= FormFacade::submit('Lihat Ticket',['class'    =>  'btn btn-success']);
                    $button .= FormFacade::close();
                }

                return $button;
            })
            ->make(true);

        return $datatables;
    }
}
