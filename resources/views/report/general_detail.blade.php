<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/24/2016
 * Time: 1:58 AM
 */
?>
@extends('layouts.index')
@section('header')
    Laporan Angket
@endsection
@section('submenu')
    Detail General
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

                        {{ Form::hidden('pertanyaan',$pertanyaan,['id'  =>  'pertanyaan']) }}
                        {{ Form::hidden('semester',$semester,['id'  =>  'semester']) }}
                        {{ Form::hidden('periode',$periode,['id'  =>  'periode']) }}

                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Semester</th>
                                <th>Category</th>
                                <th>Jenis Pertanyaan</th>
                                <th>Ruang</th>
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
                    url: '{{ route('report.datatables-general-detail') }}',
                    data: {
                        periode: $('#periode').val(),
                        semester: $('#semester').val(),
                        pertanyaan: $('#pertanyaan').val()
                    }
                },
                columns: [
                    {data: 'periode', name: 'periode'},
                    {data: 'semester', name: 'semester'},
                    {data: 'category', name: 'category'},
                    {data: 'jenis_pertanyaan', name: 'jenis_pertanyaan'},
                    {data: 'ruang', name: 'ruang'},
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