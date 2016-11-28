<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 12:57 PM
 */
?>
@extends('layouts.index')
@section('header')
    Enroll Jadwal Mahasiswa
@endsection
@section('submenu')
    Index
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
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#jadwal-mhs" data-toggle="tab">Jadwal Mahasiswa</a></li>
                                <li><a href="#jadwal-matkul" data-toggle="tab">Jadwal Mata Kuliah</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="jadwal-matkul">
                                    <form class="form-horizontal" role="form" method="POST" action="#">
                                        {{ csrf_field() }}

                                        @if (strtoupper($role)=="MAHASISWA")
                                            {{ Form::hidden('mahasiswa',Auth::user()->id,['id'   =>  'mahasiswa']) }}
                                        @else
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="roles">Pilih
                                                    Mahasiswa</label>
                                                <div class="col-md-4">
                                                    {{ Form::select('mahasiswa',$mahasiswa,'',['id'   =>  'mahasiswa','class'   =>  'form-control select2']) }}
                                                </div>
                                            </div>
                                        @endif

                                    </form>

                                    <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                                        <thead>
                                        <tr>
                                            <th>Check</th>
                                            <th>Mata Kuliah</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Ruang</th>
                                            <th>Hari</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Dosen</th>
                                            <th>Qty</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="row">
                                        <div class="col-xs-3">

                                            <button id="SubmitSelected" class="btn btn-info">Tambah ke Jadwal</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="active tab-pane" id="jadwal-mhs">
                                    <table class="display" cellspacing="0" width="100%" id="jadwal-mhs-table" name="jadwal-mhs-table">
                                        <thead>
                                        <tr>
                                            <th>Mata Kuliah</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Ruang</th>
                                            <th>Hari</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Dosen</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        </div>
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

            $('select').select2();
        });
        var mhs_table = $('#jadwal-mhs-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                'url': '{{ route('jadwal_mhs_enroll.datatables') }}',
                'type': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                'beforeSend': function (request) {
                 request.setRequestHeader("token", "{{ csrf_token() }}");
                 }
            },
            columns: [
                {data: 'matkul', name: 'matkul'},
                {data: 'tahun_ajaran', name: 'tahun_ajaran'},
                {data: 'ruang', name: 'ruang'},
                {data: 'hari', name: 'hari'},
                {data: 'time_start', name: 'time_start'},
                {data: 'time_end', name: 'time_end'},
                {data: 'nama_dosen', name: 'nama_dosen'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var table = $('#kelas-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'url': '{{ route('jadwal_mhs_jadwal.datatables') }}',
                        'type': 'GET',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        'beforeSend': function (request) {
                         request.setRequestHeader("token", "{{ csrf_token() }}");
                         }
                    },
                    columns: [
                        {data: 'check', name: 'check', orderable: false, searchable: false},
                        {data: 'matkul', name: 'matkul'},
                        {data: 'tahun_ajaran', name: 'tahun_ajaran'},
                        {data: 'ruang', name: 'ruang'},
                        {data: 'hari', name: 'hari'},
                        {data: 'time_start', name: 'time_start'},
                        {data: 'time_end', name: 'time_end'},
                        {data: 'qty', name: 'qty'},
                        {data: 'nama_dosen', name: 'nama_dosen'},
                    ]
                })
                ;

        $('#SubmitSelected').click(function () {
//            var chkbox_checked    = $('tbody input[type="checkbox"]:checked', table);
            var selected_jadwal = [];
            table = $('#kelas-table').DataTable();
//            table_jadwal = $('#jadwal-mhs-table').DataTable();
            var chkbox_checked = table.$('input[type="checkbox"]:checked');
            console.log('test om');
            console.log(chkbox_checked);
            chkbox_checked.each(function () {
//                console.log(this.value);
                selected_jadwal.push(this.value)
            })
            console.log(selected_jadwal);
            $.ajax({
                url:'{{ route('jadwal-mhs.store') }}',
                type: 'post',
                data: {
                    'id_jadwal':    selected_jadwal,
                    'id_mhs'   :    $('#mahasiswa').val()
                },
                success:    function (result) {
//                    console.log(result.message)
                    alert(result.message);
                    mhs_table.ajax.reload();
                }
            })
        });

    </script>
@endsection