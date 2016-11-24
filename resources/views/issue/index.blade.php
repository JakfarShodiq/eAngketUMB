<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/24/2016
 * Time: 4:37 PM
 */
?>
@extends('layouts.index')
@section('header')
    Issue
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
                        <table class="table table-bordered" id="jadwal-mhs-table" name="jadwal-mhs-table">
                            <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Semester</th>
                                <th>Jenis Pertanyaan</th>
                                <th>Ruang</th>
                                <th>Nama Dosen</th>
                                <th>Matakuliah</th>
                                <th>Pertanyaan</th>
                                <th>Avg Rate</th>
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
                'url': '{{ route('issue.datatables') }}',
                'type': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("token", "{{ csrf_token() }}");
                }
            },
            columns: [
                {data: 'periode', name: 'periode'},
                {data: 'semester', name: 'semester'},
                {data: 'jenis_pertanyaan', name: 'jenis_pertanyaan'},
                {data: 'ruang', name: 'ruang'},
                {data: 'nama_dosen', name: 'nama_dosen'},
                {data: 'matakuliah', name: 'matakuliah'},
                {data: 'pertanyaan', name: 'pertanyaan'},
                {data: 'avg_rate', name: 'avg_rate'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection

