<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/23/2016
 * Time: 11:38 PM
 */
?>
@extends('layouts.index')
@section('header')
    Laporan Angket
@endsection
@section('submenu')
    Issue Performa Dosen
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
                        <form class="form-horizontal" id="data-filter" role="form" method="POST" action="#">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="periode" class="col-md-4 control-label">Periode</label>
                                <div class="col-xs-3">
                                    {{ Form::select('periode',$periode,'',['id'    =>  'periode','class'    =>  'form-control select2']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="semester" class="col-md-4 control-label">Semester</label>
                                <div class="col-xs-3">
                                    {{ Form::select('semester',$semester,'',['id'    =>  'semester','class'    =>  'form-control select2']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" id="filter" name="filter" class="btn btn-info">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Semester</th>
                                <th>Jenis Pertanyaan</th>
                                <th>Pertanyaan</th>
                                <th>Rate</th>
                                <th>Action</th>
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

            var table = $('#kelas-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
                "<'row'<'col-xs-12't>>" +
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{ route('report.datatables-performance') }}',
                    data: function (d) {
                        d.periode = $('#periode').val();
                        d.semester = $('#semester').val();
                    }
                },
                columns: [
                    {data: 'periode', name: 'periode'},
                    {data: 'semester', name: 'semester'},
                    {data: 'jenis_pertanyaan', name: 'jenis_pertanyaan'},
                    {data: 'text', name: 'text'},
                    {data: 'rate', name: 'rate', orderable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
//            $('select').select2();
            $('#data-filter').submit(function (e) {

                var periode = $('#periode').val();
                var semester = $('#semester').val();
                console.log(periode);
                console.log(semester);
                table.draw();
                e.preventDefault();
//                return false;
            });
        })
    </script>
@endsection