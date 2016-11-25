<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/25/2016
 * Time: 11:12 AM
 */
?>
@extends('layouts.index')
@section('header')
    Ticket
@endsection
@section('submenu')
    Create
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">
                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
                        {{ Form::open([
                            'method'    => 'post',
                            'url'   =>  route('ticket.store'),
                            'class' =>  'form-horizontal'
                        ]) }}

                        <div class="form-group">
                            <label for="issue" class="col-md-4 control-label">ID Issue</label>
                            <div class="col-xs-6">
                                {{ Form::text('issue_id',$issue->id,array('class'   => 'form-control','id'  =>  'issue_id','readonly'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_pertanyaan" class="col-md-4 control-label">Jenis Pertanyaan</label>
                            <div class="col-xs-6">
                                {{ Form::text('jenis_pertanyaan',$issue->jenis_pertanyaan,array('class'   => 'form-control','id'  =>  'jenis_pertanyaan','readonly'))  }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pertanyaan" class="col-md-4 control-label">Elemen Angket</label>
                            <div class="col-xs-6">
                                {{ Form::text('pertanyaan',$issue->pertanyaan,array('class'   => 'form-control','id'  =>  'pertanyaan','readonly'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="periode" class="col-md-4 control-label">Periode</label>
                            <div class="col-xs-6">
                                {{ Form::text('periode',$issue->periode,array('class'   => 'form-control','id'  =>  'periode','readonly'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="roles" class="col-md-4 control-label">Penerima</label>
                            <div class="col-xs-6">
                                {{ Form::select('roles',$roles,array('class'   => 'form-control select2','id'  =>  'roles'))  }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="note" class="col-md-4 control-label">Catatan</label>
                            <div class="col-xs-6">
                                {{ Form::textarea('note','',array('class'   => 'form-control','id'  =>  'note'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12" align="center">
                                {{ Form::submit('Buat Ticket',['class'  =>  'btn btn-success']) }}
                                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        })
    </script>
@endsection

