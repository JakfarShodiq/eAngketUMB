<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/19/2016
 * Time: 2:14 AM
 */
?>
@extends('layouts.index')
@section('header')
    Isi Angket : {{ $matkul->matkul }}
@endsection
@section('submenu')
    {{ Auth::user()->identity_number }}
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
                        <form method="post" action="{{ route('angket.store') }}">
                            {{ csrf_field() }}
                            {{ Form::hidden('id',$id->id) }}
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($jenispt as $jenispts)
                                        <h3>{{ $jenispts->categories }}</h3>
                                        @foreach($pertanyaan as $pertanyaans)
                                            @if($jenispts->categories == $pertanyaans->jpt)
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        {{ $pertanyaans->pertanyaan }}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input name="{{ $pertanyaans->id }}" id="{{ $pertanyaans->id }}"
                                                               class="rating rating-loading" value="3" data-min="0"
                                                               data-step="1" data-max="5" data-size="xs">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <h3>
                                            Komentar mengenai mata kuliah
                                        </h3>
                                        {{ Form::textarea('note','',['id'   =>  'note','class'  =>  'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                </div>
                                <div class="col-xs-3">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6"></div>
                                <div class="col-xs-3">
                                    <div class="row">
                                        <input type="submit" class="btn btn-success" value="Submit Angket">
                                        <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                                    </div>
                                </div>
                                <div class="col-xs-3">

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
@endsection