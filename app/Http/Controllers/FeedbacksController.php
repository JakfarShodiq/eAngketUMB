<?php

namespace App\Http\Controllers;

use App\Angket_Details;
use App\Feedback_Details;
use App\Feedbacks;
use App\Issue;
use App\Roles;
use App\Status;
use App\User;
use Collective\Html\FormFacade;
use Illuminate\Contracts\Logging\Log;
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
//        $roles = clone $pertanyaan;
        $roles = Roles::all();
        $pertanyaan = $pertanyaan->select('p.*')->first();
//        return $issue;
        /*
         * $roles = $roles->join('jenis_pt as jpt', 'jpt.id', '=', 'p.jenis_pt')
            ->join('kelas_categories as kc', 'kc.id', '=', 'jpt.kelas_category')
            ->join('categories as c', 'c.id', '=', 'kc.id_category')
            ->join('pic_categories as pc', 'pc.category_id', '=', 'c.id')
            ->join('roles as r', 'r.id', '=', 'pc.role_id');
        */
        /*
        Pelayanan Unit
        Belajar Mengajar
        Sarana Prasarana Kelas
        Pelayanan Umum
        */
//        return $roles->pluck('name', 'id');
        $current_role = Auth::user()->role->name;

        if ($issue->category == "Dosen") {
            if ($current_role == "KAPRODI") {
                $roles = $roles->whereIn('name', ['DEKAN']);
            } else
                $roles = $roles->whereIn('name', ['KAPRODI', 'DEKAN']);
        } elseif ($issue->category == "Belajar Mengajar") {
            $roles = $roles->whereIn('name', ['KAPRODI']);
        } elseif ($issue->category == "Sarana Prasarana Kelas") {
            $roles = $roles->whereIn('name', ['BMGS']);
        } elseif ($issue->category == "Pelayanan Umum") {
            $roles = $roles->whereIn('name', ['BMGS']);
        } elseif ($issue->category == "Pelayanan Unit") {
            $roles = $roles->whereIn('name', ['BJM']);
        }
        $roles = $roles->pluck('name', 'id');
//        return $issue->category . '<br>' . $current_role . '<br>' . $roles;
        return view('ticket.create')->with('roles', $roles)
            ->with('pertanyaan', $pertanyaan)
            ->with('issue', $issue);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
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

        if ($model->save()) {
            return redirect()->route('ticket.index')->with('status', 'Ticket sudah berhasil dibuat !');
        } else
            return redirect()->route('ticket.index')->with('status', 'Ticket gagal dibuat !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //ADD DETAIL TICKET
        $ticket = Feedbacks::find($id);
        $created_by = User::find($ticket->created_by);
        $roles = User::find($ticket->created_by)->role->name;
        $issue = clone $ticket;
        $issue = $issue->issue;
        $status = Status::whereIn('id', [2, 3])->pluck('name', 'id');
//        return $issue;
        return view('ticket.show')->with('ticket', $ticket)
            ->with('status', $status)
            ->with('roles', $roles)
            ->with('created_by', $created_by)
            ->with('issue', $issue);
    }

    function generateTableDetail()
    {
        $id = $_REQUEST['id'];
        $data = Feedbacks::find($id)->join('feedback_details as fd', 'feedbacks.id', '=', 'fd.feedback_id')
            ->join('users as u', 'u.id', '=', 'fd.created_by')
            ->join('status as s', 's.id', '=', 'fd.status')
            ->where('feedbacks.id', '=', $id)
            ->select(DB::raw('
        feedbacks.id,
        fd.note,
        u.name,
        s.name as status,
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
    public
    function edit($id)
    {
        //UPDATE TICKET DOANG MUNCUL KETIKA ROLE PEMBUAT / ADMIN
        $model = Feedbacks::find($id);
        $issue = clone $model;
        $issue = $issue->issue;
        $status = Status::whereIn('id', [1, 4])->pluck('name', 'id');
        return view('ticket.edit')
            ->with('model', $model)
            ->with('status', $status)
            ->with('issue', $issue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
        $status = $request['status'];
        $updated_by = $request['created_by'];

        $model = Feedbacks::find($id);
        $model->status = $status;
        $model->updated_by = $updated_by;

        if ($model->save()) {
            return redirect()->route('ticket.index')->with('status', 'Ticket berhasil diupdate !');
        } else
            return redirect()->route('ticket.index')->with('status', 'Ticket gagal diupdate !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function getDatatables()
    {
        $data = Feedbacks::join('issues as i', 'feedbacks.id_issue', '=', 'i.id')
            ->join('roles as r', 'feedbacks.assigned_to', '=', 'r.id')
            ->join('users as u', 'feedbacks.created_by', '=', 'u.id')
            ->join('roles as rc', 'u.role_id', '=', 'rc.id')
            ->join('status as s', 's.id', '=', 'feedbacks.status');
        $role = Auth::user()->role->name;
        /*if ($role->name != "LPPM" and $role->name != "Administrator") {
            $data = $data->where('feedbacks.assigned_to', '=', $role->id);
        }*/
        if($role == "POP"){
            $data = $data->where('rc.name','=','POP');
        }elseif ($role == "BJM"){
            $data = $data->where('rc.name','=','BJM');
        }elseif ($role == "SDM"){
            $data = $data->where('rc.name','=','SDM');
        }elseif ($role == "KAPRODI"){
            $data = $data->where('rc.name','=','KAPRODI');
        }
        elseif($role == "Administrator")
        {
            $data = $data;
        }
        else{
            $data = $data->where('r.name','=',$role);
        }
        $data = $data->select(DB::raw(
            'feedbacks.id,
                    feedbacks.periode,
                    i.jenis_pertanyaan,
                    i.pertanyaan,
                    i.nama_dosen,
                    i.ruang,
                    i.matakuliah,
                    r.name,
                    rc.name as created_by_role,
                    s.name as status'
        ));

        $datatables = Datatables::of($data)
            ->addColumn('action', function ($data) {
                $role = Auth::user()->role;
                $detail = Feedback_Details::where('feedback_id', '=', $data->id)->count();
                $finish = Feedback_Details::where('feedback_id', '=', $data->id)
                    ->where('status', '=', 3)
                    ->first();
                $close = Feedbacks::find($data->id)//                    ->where('feedbacks.status','=',4)
                ;
                $user = Auth::user()->role;

                if ($close->status == 4) {
                    $button = FormFacade::open([
                        'method' => 'post',
                        'url' => route('ticket.history')
                    ]);
                    $button .= FormFacade::hidden('id', $data->id);
                    $button .= FormFacade::submit('History Ticket', ['class' => 'btn btn-default']);
                    $button .= FormFacade::close();
                } elseif ($data->created_by_role == $user->name or $user->name == "Administrator") {
                    $button = FormFacade::open([
                        'method' => 'get',
                        'url' => route('ticket.edit', $data->id)
                    ]);
                    $button .= FormFacade::submit('Update Ticket', ['class' => 'btn btn-success']);
                    $button .= FormFacade::close();
                } elseif ($data->name == $user->name) {
                    $button = FormFacade::open([
                        'method' => 'get',
                        'url' => route('ticket.show', $data->id)
                    ]);
                    $button .= FormFacade::submit('Update Ticket', ['class' => 'btn btn-info']);
                    $button .= FormFacade::close();
                } else
                    $button = '';
                return $button;
            })
            ->make(true);

        return $datatables;
    }

    public
    function history(Request $request)
    {

        $id = $request['id'];
        $model = Feedbacks::find($id);
        $detail = Feedbacks::find($id)->join('feedback_details as fd', 'feedbacks.id', '=', 'fd.feedback_id')
            ->join('users as u', 'fd.created_by', '=', 'u.id')
            ->join('status as s', 'fd.status', '=', 's.id')
            ->where('fd.feedback_id', '=', $id)
            ->select(DB::raw('
                fd.id,
                u.name as username,
                fd.note as note,
                to_char(fd.created_at,\'yyyy-mm-dd hh24:mi:ss\') as waktu,
                s.name as status                                                                          
                '))
            ->orderBy('fd.id')
            ->get();
        $role_user = User::find($model->created_by);
//        return $role_user;
        $roles = Roles::find($role_user->role_id);
//        return $model;
        return view('ticket.history')
            ->with('model', $model)
            ->with('roles', $roles)
            ->with('detail', $detail);
    }
}
