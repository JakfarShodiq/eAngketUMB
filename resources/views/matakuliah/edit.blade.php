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
    Mata Kuliah
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('matakuliah.update',$model->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Mata Kuliah</label>
                                <div class="col-md-6">
                                    {{ Form::text('name',$model->name,array('class'   => 'form-control','id'  =>  'name'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Jumlah SKS</label>
                                <div class="col-md-4">
                                    {{ Form::number('sks', $model->sks,['id'   =>  'sks','min'    =>  0]) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Kelas</label>
                                <div class="col-md-4">
                                            {{ Form::select('kelas',$kelas,$model->id_kelas,['id'   =>  'kelas','class'   =>  'form-control select2'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Semester</label>
                                <div class="col-md-4">
                                    {{ Form::select('semester',['Ganjil'  =>  'Ganjil','Genap'  =>  'Genap'],$model->semester,['id'   =>  'semester','class'   =>  'form-control select2'])}}
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