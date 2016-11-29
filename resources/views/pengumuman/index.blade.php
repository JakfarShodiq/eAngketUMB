<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/29/2016
 * Time: 5:27 PM
 */
?>
@extends('layouts.index')
@section('header')
    Pengumuman
@endsection
@section('submenu')
    Index
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#pengumuman-create" data-toggle="tab">Buat Pengumuman</a></li>
                        <li><a href="#pengumuman-list" data-toggle="tab">Data Pengumuman</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="pengumuman-create">
                            <div class="box box-primary">
                                @if (session('status'))
                                    <div class="box-header">
                                        <div class="alert alert-info alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true">&times;</button>
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="box-body">

                                    <div class="form-group row">
                                        <div class="col-md-6 col-md-offset-4">
                                            <h3>Pilih Ticket</h3>
                                        </div>
                                    </div>


                                    <table class="display" cellspacing="0" width="100%" id="jadwal-mhs-table"
                                           name="jadwal-mhs-table">
                                        <thead>
                                        <tr>
                                            <th>ID Ticket</th>
                                            <th>Periode</th>
                                            <th>Jenis Pertanyaan</th>
                                            <th>Pertanyaan</th>
                                            <th>Ruang</th>
                                            <th>Mata Kuliah</th>
                                            <th>Nama Dosen</th>
                                            <th>Penerima</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="pengumuman-list">
                            <table class="display" cellspacing="0" width="100%" id="pengumuman-table"
                                   name="pengumuman-table">
                                <thead>
                                <tr>
                                    <th>ID Ticket</th>
                                    <th>Feed</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">

                    </div>
                    <div class="box-body">
                        {{ Form::open([
                        'method'    =>  'post',
                        'url'   =>  route('pengumuman.store'),
                        'class' =>  'form-horizontal'
                        ]) }}


                        <div class="form-group row">
                            <label for="id_ticket" class="col-sm-4 control-label">ID Ticket</label>
                            <div class="col-sm-6">
                                {{ Form::text('id_ticket','',array('class'   => 'form-control','id'  =>  'id_ticket','readonly'))  }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="note">Feed</label>
                            <div class="col-sm-6">
                                {{ Form::textarea('note','',['class'   => 'form-control','id'  =>  'note']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Tambahkan',[
                                'class' =>  'btn btn-success'
                                ]) }}
                            </div>
                        </div>

                        {{ Form::close() }}
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

                    $('select').select2();
                });

                var pengumuman_table = $('#pengumuman-table').DataTable({
                    rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'url': '{{ route('pengumuman.datatables') }}',
                        'type': 'GET',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        'beforeSend': function (request) {
                            request.setRequestHeader("token", "{{ csrf_token() }}");
                        }
                    },
                    columns: [
                        {data: 'id_feedbacks', name: 'id_feedbacks'},
                        {data: 'note', name: 'note'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });

                var mhs_table = $('#jadwal-mhs-table').DataTable({
                    select: true,
                    rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'url': '{{ route('ticket.datatables') }}',
                        'type': 'GET',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        'beforeSend': function (request) {
                            request.setRequestHeader("token", "{{ csrf_token() }}");
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'periode', name: 'periode'},
                        {data: 'jenis_pertanyaan', name: 'jenis_pertanyaan'},
                        {data: 'pertanyaan', name: 'pertanyaan'},
                        {data: 'ruang', name: 'ruang'},
                        {data: 'matakuliah', name: 'matakuliah'},
                        {data: 'nama_dosen', name: 'nama_dosen'},
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
                var events = $('#events');
                var id_ticket = $('#id_ticket');
                mhs_table

                        .on('select', function (e, dt, type, indexes) {
                            var rowData = mhs_table.rows(indexes).data().toArray();
                            var ticket_id = rowData[0].id;
//                            console.log(rowData[0].id);
                            id_ticket.val(ticket_id);
                        })
            </script>
@endsection