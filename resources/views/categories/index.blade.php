<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 10:57 AM
 */
?>
@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-header">Kategori Kelas</h3></div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/categories') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control'))  }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="true" class="col-md-6 control-label">
                                        {{ Form::radio('status',true,true,array('id'    =>  'true')) }}
                                        Active</label>
                                    <label for="false" class="col-md-6 control-label">
                                        {{ Form::radio('status',false,false,array('id'    =>  'false')) }}
                                        Not Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    @foreach($roles as $role)
                                        <label>
                                            {{ Form::checkbox('pic[]',$role['id'],null)}}
                                            {{ $role['name'] }}</label><br>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
