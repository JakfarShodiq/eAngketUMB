<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/25/2016
 * Time: 7:48 PM
 */
?>
@extends('layouts.index')
@section('header')
    Ticket
@endsection
@section('submenu')
    Update
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">
                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
                        {{ Form::open([
                        'method'    =>  'post',
                        'url'   => route('ticket.update',$model->id),
                        'class' =>  'form-horizontal'
                        ]) }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="issue" class="col-md-4 control-label">ID Ticket</label>
                            <div class="col-xs-6">
                                {{ Form::text('id',$model->id,array('class'   => 'form-control','id'  =>  'id','readonly'))  }}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="note" class="col-md-4 control-label">Pesan</label>
                            <div class="col-xs-6">
                                {{ Form::textarea('note',$model->note,array('class'   => 'form-control select2','id'  =>  'note','readonly',))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-xs-6">
                                {{ Form::select('status',$status,array('class'   => 'form-control select2','id'  =>  'status','readonly'))  }}
                            </div>
                        </div>

                        {{ Form::hidden('created_by',Auth::user()->id,['id'  =>  'created_by']) }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Update Data',['class'  =>  'btn btn-success']) }}
                                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3>History Ticket</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="jadwal-mhs-table" name="jadwal-mhs-table">
                            <thead>
                            <tr>
                                <th>No Ticket</th>
                                <th>Pesan</th>
                                <th>Pembuat</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                            </thead>
                        </table>
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

        });
        var id_ticket = $('#id').val();
        var mhs_table = $('#jadwal-mhs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('ticket.datatables-detail') }}',
                type: 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("token", "{{ csrf_token() }}");
                },
                data: {
                    id: id_ticket
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'note', name: 'note'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'waktu', name: 'waktu'},
            ]
        });
    </script>
@endsection
