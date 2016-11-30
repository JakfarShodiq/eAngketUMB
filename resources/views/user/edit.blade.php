<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/30/2016
 * Time: 1:39 PM
 */
?>
@extends('layouts.index')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Profile User</h3>
        </div>
        <div class="box-body">
                {{ Form::open([
                'method'    =>  'put',
                'url'   =>  route('user.update',$model->id),
                'class' =>  'form-horizontal'
                ]) }}
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">Nama</label>
                        <div class="col-md-4">
                            <input id="name" name="name" type="text" placeholder="" class="form-control input-md" value="{{ $model->name }}">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="education">Pendidikan Terakhir</label>
                        <div class="col-md-4">
                            <input id="education" name="education" type="text" placeholder="" class="form-control input-md" value="{{ $model->education }}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="phone">No. Telepon</label>
                        <div class="col-md-4">
                            <input id="phone" name="phone" type="text" placeholder="" class="form-control input-md" value="{{ $model->phone }}">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">E-mail</label>
                        <div class="col-md-4">
                            <input id="email" name="email" type="text" placeholder="" value="{{ $model->email }}" class="form-control input-md">

                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="address">Alamat</label>
                        <div class="col-md-4">
                            <textarea class="form-control" id="address" name="address">{{ $model->address }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::submit('Edit Data',['class' => 'btn btn-info']) }}
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection