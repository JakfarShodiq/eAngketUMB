<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/7/2016
 * Time: 1:19 PM
 */
?>
@extends('layouts.index')
@section('header')
    Rating Dosen
@endsection
@section('submenu')
    {{ $dosen->name }}
@endsection
@section('content')
    <div class="container">
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
                            <li class="active"><a href="#rating" data-toggle="tab">Summary Overview</a></li>
                            <li><a href="#detail" data-toggle="tab">Detail Performance</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="rating">
                                <div class="row">
                                    <form class="form-horizontal" id="data-filter" role="form" method="POST" action="#">
                                        {{ csrf_field() }}
                                        {{ Form::hidden('dosen',$dosen->id), array('id'   =>  'dosen') }}
                                        <div class="form-group row">
                                            <label for="periode" class="col-md-4 control-label">Periode</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('periode',$periode,'',['id'    =>  'periode','class'    =>  'form-control select2']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="semester" class="col-md-4 control-label">Semester</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('semester',$semester,'all',['id'    =>  'semester','class'    =>  'form-control select2']) }}
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
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="box box-primary">
                                            <div class="box-body">
                                                <div class="row">
                                                    <table class="display" cellspacing="0" width="100%" id="kelas-table"
                                                           name="kelas-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Periode</th>
                                                            <th>Semester</th>
                                                            <th>Pertanyaan</th>
                                                            <th>Rating</th>
                                                            <th>Persentase</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="detail">
                                <div class="row">

                                    <table class="display" cellspacing="0" width="100%" id="jadwal-table"
                                           name="jadwal-table">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mata Kuliah</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Ruang</th>
                                            <th>Hari</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Qty</th>
                                            <th>Dosen</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12" id="centent-data">
                                        <div id="loader" class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                        <div class="box box-default" id="content-nilai">
                                            <div class="box-header">
                                                Penilaian
                                            </div>
                                            <div class="box-body">
                                                <div class="col-xs-12">
                                                    <div id="data-nilai">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            $('#loader').hide();
            $('#content-nilai').hide();

            var dosen = $("input[name='dosen']").val();
            console.log(dosen);
            var table = $('#kelas-table').DataTable({
                rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
                "<'row'<'col-xs-12't>>" +
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('report.datatables_detail_rating') }}',
                    data: function (d) {
                        d.periode = $('#periode').val();
                        d.semester = $('#semester').val();
                        d.dosen = dosen;
                    }
                },
                columns: [
                    {data: 'periode', name: 'periode'},
                    {data: 'semester', name: 'semester'},
                    {data: 'text', name: 'text'},
                    {data: 'rating', name: 'rating', orderable: false},
                    {data: 'rate', name: 'rate', orderable: true, searchable: false},
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

            var jadwal_table = $('#jadwal-table').DataTable({
                rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('dosen.datatables') }}',
                    data: function (d) {
                        d.dosen = dosen;
                    }
                },
                columns: [
                    {data: 'jadwal_id', name: 'jadwal_id', visible: false},
                    {data: 'matkul', name: 'matkul'},
                    {data: 'tahun_ajaran', name: 'tahun_ajaran'},
                    {data: 'ruang', name: 'ruang'},
                    {data: 'hari', name: 'hari'},
                    {data: 'time_start', name: 'time_start'},
                    {data: 'time_end', name: 'time_end'},
                    {data: 'qty', name: 'qty'},
                    {data: 'nama_dosen', name: 'nama_dosen'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            jadwal_table.on('click', 'button', function () {
                var id = jadwal_table.row($(this).parents('tr')).data().jadwal_id;
                $('#loader').show();
                $.ajax({
                    url: "{{ route('dosen.nilai') }}",
                    type: 'post',
                    data: {
                        _token: "<?php echo csrf_token(); ?>",
                        id: id
                    },
                    success: function (data) {
                        if (data.data.length == 0) {
                            data.data = 'Tidak ada Data Angket untuk Jadwal ini !';
                        }
                        $('#data-nilai').html(data.data);
                        $(".display-rating-tok").rating({displayOnly: true, step: 0.5});
                        $('#loader').hide();
                        $('#content-nilai').show();
//                        console.log(data);
                    },
                    error: function () {
                        console.log(data);
                    }
                });
            });
        })
    </script>
@endsection
