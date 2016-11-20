<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/19/2016
 * Time: 2:14 AM
 */
?>
@extends('layouts.index')
@section('header')
    Angket
@endsection
@section('submenu')
    {{ Auth::user()->identity_number }}
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
                        <table class="table table-bordered" id="jadwal-mhs-table" name="jadwal-mhs-table">
                            <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Tahun Ajaran</th>
                                <th>Ruang</th>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Dosen</th>
                                <th>Kuesioner</th>
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
        var mhs_table = $('#jadwal-mhs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': '{{ route('angket.datatables') }}',
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
    </script>
@endsection
