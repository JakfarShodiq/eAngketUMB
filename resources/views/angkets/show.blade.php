<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/19/2016
 * Time: 2:14 AM
 */
?>
@extends('layouts.index')
@section('header')
    Data Angket : {{ $matkul->matkul }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">
                        <table class="display" cellspacing="0" width="100%">
                            <tr>
                                <th colspan="2">Data Responden</th>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $user->name }}</td>
                            <tr>
                            <tr>
                                <td>NIM</td>
                                <td>{{ $user->identity_number }}</td>
                            <tr>
                        </table>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{ route('angket.store') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($categories as $category)
                                        <h2>{{ $category->categories }}</h2>
                                        @foreach($jenispt as $jpt)
                                            @if($jpt->categories == $category->categories)
                                                <h3> {{ $jpt->jenis_pertanyaan }}</h3>
                                            @endif
                                            @foreach($pertanyaan as $pertanyaans)
                                                @if($category->categories == $pertanyaans->category and $pertanyaans->jpt == $jpt->jenis_pertanyaan)
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            {{ $pertanyaans->pertanyaan }}
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input name="{{ $pertanyaans->id }}"
                                                                   id="{{ $pertanyaans->id }}"
                                                                   class="rating rating-loading display-rating-tok"
                                                                   value="{{ $pertanyaans->rate }}" data-size="xs">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
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
                                        {{ Form::textarea('note',$note,['disabled','id'   =>  'note','class'  =>  'form-control']) }}
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
    <script type="text/javascript">
        $(document).ready(function () {
        });
        $(".display-rating-tok").rating({displayOnly: true, step: 0.5});
    </script>
@endsection