<?php

namespace App\Http\Controllers;

use App\Feedback_Details;
use App\Feedbacks;
use Illuminate\Http\Request;

use App\Http\Requests;

class FeedbackDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $ticket_id = $request['id_ticket'];
        $status = $request['status'];
        $note = $request['note'];
        $created_by = $request['created_by'];

        $model = new Feedback_Details();
        $model->feedback_id = $ticket_id;
        $model->note = $note;
        $model->status = $status;
        $model->created_by = $created_by;

        if($model->save()){
            $ticket = Feedbacks::find($ticket_id);
            $ticket->status = $status;
            $ticket->save();
            return redirect()->route('ticket.index')->with('status','Ticket sudah diupdate');
        }
        else
            return redirect()->route('ticket.index')->with('status','Ticket gagal diupdate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
