<?php

namespace App\Http\Controllers;

use App\Angket_Details;
use App\Feedback_Details;
use App\Feedbacks;
use App\Issue;
use App\Status;
use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Facades\Datatables;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issue_id = $_REQUEST['issue_id'];
        $issue = Issue::find($issue_id);
        $pertanyaan = Issue::findOrFail($issue_id)
            ->join('pertanyaan as p', 'p.text', '=', 'issues.pertanyaan');
        $roles = clone $pertanyaan;
        $pertanyaan = $pertanyaan->select('p.*')->first();

        $roles = $roles->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('kelas_categories as kc', 'kc.id', '=', 'jpt.kelas_category')
            ->join('categories as c', 'c.id', '=', 'kc.id_category')
            ->join('pic_categories as pc', 'pc.category_id', '=', 'c.id')
            ->join('roles as r', 'r.id', '=', 'pc.role_id')
//            ->select(DB::raw('p.id as pertanyaan,r.id as role_id,r.name'))->get();
            ->pluck('r.name','r.id');

        return view('ticket.create')->with('roles',$roles)
            ->with('pertanyaan',$pertanyaan)
            ->with('issue',$issue);
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
        $issue_id = $request['issue_id'];
        $periode = $request['periode'];
        $status = 1;
        $created_by = Auth::user()->id;
        $assigned_to = $request['roles'];
        $note = $request['note'];

//        return dd($request);
        $model = new Feedbacks();
        $model->id_issue = $issue_id;
        $model->periode = $periode;
        $model->status = $status;
        $model->created_by = $created_by;
        $model->assigned_to = $assigned_to;
        $model->note = $note;

        if($model->save()){
            return redirect()->route('ticket.index')->with('status','Ticket sudah berhasil dibuat !');
        }
        else
            return redirect()->route('ticket.index')->with('status','Ticket gagal dibuat !');
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
        $ticket = Feedbacks::find($id);
        $ticket_detail = clone $ticket;
        $ticket_detail = $ticket->detail();
        $status = Status::whereIn('id',[2,3])->pluck('name','id');
        return view('ticket.show')->with('ticket',$ticket)
            ->with('detail',$ticket_detail)
            ->with('status',$status);
    }

    function generateTableDetail(){
        $id = $_REQUEST['id'];
        $data = Feedbacks::find($id)->join('feedback_details as fd','feedbacks.id','=','fd.feedback_id')
            ->join('users as u','u.id','=','fd.created_by')
        ->select(DB::raw('
        feedbacks.id,
        fd.note,
        u.name,
        fd.status,
        to_char(fd.created_at,\'yyyy-mm-dd hh24:mi:ss\') as waktu
        '));
        $datatables = Datatables::of($data)
            ->make(true);

        return $datatables;
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
        $model = Feedbacks::find($id);
        $status = Status::whereIn('id',[1,4])->pluck('name','id');
        return view('ticket.edit')
            ->with('model',$model)
            ->with('status',$status);
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
        $status = $request['status'];
        $updated_by = $request['created_by'];

        $model = Feedbacks::find($id);
        $model->status = $status;
        $model->updated_by = $updated_by;

        if($model->save()){
            return redirect()->route('ticket.index')->with('status','Ticket berhasil diupdate !');
        }
        else
            return redirect()->route('ticket.index')->with('status','Ticket gagal diupdate !');
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
        $data = Feedbacks::join('issues as i','feedbacks.id_issue','=','i.id')
                ->join('roles as r','feedbacks.assigned_to','=','r.id')
                ->select(DB::raw(
                    'feedbacks.id,
                    feedbacks.periode,
                    i.jenis_pertanyaan,
                    i.pertanyaan,
                    r.name,
                    feedbacks.status'
                ));
        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $finish = Feedback_Details::where('feedback_id','=',$data->id)
                    ->where('status','=',3)
                    ->first();

                if(empty($finish)){
                    $button = FormFacade::open([
                        'method' =>  'get',
                        'url'   =>  route('ticket.show',$data->id)
                    ]);
                    $button .= FormFacade::submit('Lihat Ticket',['class' =>'btn btn-success']);
                    $button .= FormFacade::close();
                }
                elseif (!empty(Feedbacks::find($data->id)->where('status','=',4)->first())){
                    $button = FormFacade::open([
                        'method' =>  'post',
                        'url'   =>  route('ticket.history')
                    ]);
                    $button .= FormFacade::hidden('id',$data->id);
                    $button .= FormFacade::submit('Lihat Ticket',['class' =>'btn btn-success']);
                    $button .= FormFacade::close();
                }
                else
                {
                    $button = FormFacade::open([
                        'method' =>  'get',
                        'url'   =>  route('ticket.edit',$data->id)
                    ]);
                    $button .= FormFacade::submit('Update Ticket',['class' =>'btn btn-info']);
                    $button .= FormFacade::close();
                }

                return $button;
            })
            ->make(true);

        return $datatables;
    }

    public function history(Request $request){
        return $request['id'];

    }
}
