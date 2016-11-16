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
    Kelas
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
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('kelas.update',$model->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Kelas</label>
                                <div class="col-md-6">
                                    {{ Form::text('name',$model->name,array('class'   => 'form-control','id'  =>  'name'))  }}
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Kategori Layanan</label>
                                <div class="col-md-4">
                                    @foreach($category as $categories)
                                        <label class="checkbox-inline" for="roles-0">
                                            <label>
                                                {{ Form::checkbox('categories[]',$categories['id'],(in_array($categories['id'],$selected) ? true : ''))}}
                                                {{ $categories['name'] }}</label>
                                        </label>
                                    @endforeach
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