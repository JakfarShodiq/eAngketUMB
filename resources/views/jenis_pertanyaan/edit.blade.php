<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/5/2016
 * Time: 1:41 PM
 */
?>
@extends('layouts.index')
@section('header')
    Jenis Pertanyaan
@endsection
@section('submenu')
    Edit Data
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <form id="form-data" method="post" class="form-horizontal" role="form" action="{{ route('jenis_pertanyaan.update',$model->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::text('name',$model->name,array('class'   => 'form-control','id'  =>  'name'))  }}
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
