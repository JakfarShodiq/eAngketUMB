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
    <h1 class="page-header">Isi Angket : {{ $matkul->matkul }} <small>{{ Auth::user()->identity_number }}</small></h1>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    @if (session('status'))
                        <div class="box-header">
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{ session('status') }}
                            </div>
                    </div>
                    @endif
                    <div class="box-body">
                        <form method="post" action="{{ route('angket.store') }}">
                            {{ csrf_field() }}
                            {{ Form::hidden('id',$id->id) }}
                            @foreach($jenispt as $jenispts)
                                <h3>{{ $jenispts->categories }}</h3>
                                @foreach($pertanyaan as $pertanyaans)
                                    @if($jenispts->categories == $pertanyaans->category)
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>
                                                    {{ $pertanyaans->pertanyaan }}
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="{{ $pertanyaans->id }}" id="{{ $pertanyaans->id }}"
                                                       class="kv-ltr-theme-default-star rating rating-loading" value="0" data-min="0"
                                                       data-step="1" data-max="5" data-size="xs">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach

                            <div class="form-group">
                                <h3>
                                    Komentar mengenai mata kuliah
                                </h3>
                                {{ Form::textarea('note','',['id'   =>  'note','class'  =>  'form-control']) }}
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Submit Angket">
                                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
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