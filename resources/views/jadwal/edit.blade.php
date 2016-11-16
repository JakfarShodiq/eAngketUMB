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
    Jadwal Mata Kuliah
@endsection
@section('submenu')
    Edit Data
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">
                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('jadwal.update',$model->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Tahun Ajaran</label>
                                <div class="col-xs-3">
                                    {{ Form::text('tahun_ajaran',$model->tahun_ajaran,array('class'   => 'form-control','id'  =>  'tahun_ajaran'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Mata Kuliah</label>
                                <div class="col-md-4">
                                    {{ Form::select('matkul',$matkul,$model->id_matkul,['id'   =>  'matkul','class'   =>  'form-control select2'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Mata Kuliah</label>
                                <div class="col-md-4">
                                    {{ Form::select('dosen',$dosen,$model->id_dosen,['id'   =>  'dosen','class'   =>  'form-control select2'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Ruang</label>
                                <div class="col-xs-1">
                                    {{ Form::text('ruang',$model->ruang,array('class'   => 'form-control','id'  =>  'ruang'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="time_start" class="col-md-4 control-label">Waktu Mulai</label>
                                <div class="col-xs-1 bootstrap-timepicker">
                                    {{ Form::text('time_start',$model->time_start,array('class'   => 'form-control','id'  =>  'time_start'))  }}
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="time_end" class="col-md-4 control-label">Waktu Selesai</label>
                                <div class="col-xs-1 bootstrap-timepicker">
                                    {{ Form::text('time_end',$model->time_end,array('class'   => 'form-control','id'  =>  'time_end'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hari" class="col-md-4 control-label">Hari</label>
                                <div class="col-md-3">
                                    {{ Form::select('hari',$day,$model->hari,['id'    => 'hari','class'   =>  'form-control select2']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Quota</label>
                                <div class="col-xs-1">
                                    {{ Form::number('qty', $model->qty,['id'   =>  'qty','min'    =>  0]) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success" id="btn-add" name="btn-add">
                                        Update
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $('select').select2();

            $('#time_start').timepicker({
                showInputs: false,
                showMeridian: false
            });
            $('#time_end').timepicker({
                showInputs: false,
                showMeridian: false
            });

        })
    </script>
@endsection