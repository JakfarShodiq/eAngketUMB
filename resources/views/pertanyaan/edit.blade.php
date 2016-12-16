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
    Master Pertanyaan
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
                        <form id="form-data" method="post" class="form-horizontal" role="form" action="{{ route('pertanyaan.update',$model->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::textarea('text',$model->text,array('class'   => 'form-control','id'  =>  'text'))  }}
                                </div>
                            </div>
                            <!-- Multiple Radios -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="status">Status</label>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label for="status-0">
                                            <input type="radio" name="status" id="status-0" value="1" checked="checked">
                                            Active
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="status-1">
                                            <input type="radio" name="status" id="status-1" value="0">
                                            InActive
                                        </label>
                                    </div>
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
