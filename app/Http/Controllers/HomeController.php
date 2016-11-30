<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengumuman;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengumuman = Pengumuman::join('users as u','u.id','=','notifications.created_by')
        ->join('roles as r','r.id','=','u.role_id')
        ->select(DB::raw('notifications.id,notifications.note,notifications.id_feedbacks,notifications.created_at,notifications.updated_at,u.name as username,r.name as roles'))
        ->orderBy('created_at','desc')->limit(10)->get();

        return view('home')
            ->with('pengumuman',$pengumuman);
    }

    public function master(){
        return view('layouts.index');
    }
}
