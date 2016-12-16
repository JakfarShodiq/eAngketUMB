<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/5/2016
 * Time: 12:57 PM
 */
?>
@extends('layouts.index')
@section('header')
    Jadwal Mata Kuliah
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
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="#">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 control-label">Tahun Ajaran</label>
                                <div class="col-sm-6">
                                    {{ Form::text('tahun_ajaran',date('Y').'/'.date('Y', strtotime('+1 year')),array('class'   => 'form-control','id'  =>  'tahun_ajaran'))  }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="roles">Mata Kuliah</label>
                                <div class="col-sm-6">
                                    {{ Form::select('matkul',$matkul,'',['id'   =>  'matkul','class'   =>  'select2'])}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="roles">Mata Kuliah</label>
                                <div class="col-sm-6">
                                    {{ Form::select('dosen',$dosen,'',['id'   =>  'dosen','class'   =>  'select2'])}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ruang" class="col-sm-4 control-label">Ruang</label>
                                <div class="col-sm-6">
                                    {{ Form::text('ruang','',array('class'   => 'form-control','id'  =>  'ruang'))  }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time_start" class="col-sm-4 control-label">Waktu</label>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-6  bootstrap-timepicker">
                                            {{ Form::text('time_start','',array('class'   => 'form-control','id'  =>  'time_start'))  }}
                                        </div>
                                        <div class="col-xs-6 bootstrap-timepicker">
                                            {{ Form::text('time_end','',array('class'   => 'form-control col-xs-6','id'  =>  'time_end'))  }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hari" class="col-sm-4 control-label">Hari</label>
                                <div class="col-sm-6">
                                    {{ Form::select('hari',$day,'',['id'    => 'hari','class'   =>  'select2']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="roles">Quota</label>
                                <div class="col-sm-6">
                                    {{ Form::number('qty', '',['id'   =>  'qty','min'    =>  0, 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 col-md-offset-4">
                                    <a id="btn-add" name="btn-add" class="btn btn-success">
                                        Tambahkan
                                    </a>
                                </div>
                            </div>
                        </form>

                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
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

            $('#time_start').timepicker({
                showInputs: false,
                showMeridian: false
            });
            $('#time_end').timepicker({
                showInputs: false,
                showMeridian: false
            });

            var table = $('#kelas-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('jadwal.datatables') }}',
                columns: [
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
            $('#btn-add').click(function () {
                var matkul = $('#matkul').val();
                var tahun_ajaran = $('#tahun_ajaran').val();
                var dosen = $('#dosen').val();
                var ruang = $('#ruang').val();
                var hari = $('#hari').val();
                var qty = $('#qty').val();
                var time_start = $('#time_start').val();
                var time_end = $('#time_end').val();
                $.ajax({
                    url: "{{ URL::Route('jadwal.store') }}",
                    type: "post",
                    data: {
                        _token: "<?php echo csrf_token(); ?>",
                        'matkul': matkul,
                        'tahun_ajaran': tahun_ajaran,
                        'dosen': dosen,
                        'ruang': ruang,
                        'hari': hari,
                        'qty': qty,
                        'time_start': time_start,
                        'time_end': time_end
                    },
                    success: function (result) {
                        alert(result.message);
                        table.ajax.reload();
                        $('.form-horizontal').reset();
                    }
                });
            });
        })
    </script>
@endsection