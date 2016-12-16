<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/25/2016
 * Time: 9:10 PM
 */
?>
@extends('layouts.index')
@section('header')
    Ticket
@endsection
@section('submenu')
    History
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <!-- The time line -->
                <ul class="timeline">
                    <!-- timeline time label -->
                    <li class="time-label">
                  <span class="bg-red">
                      {{ date(' d M Y', strtotime($model->created_at )) }}
                  </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-envelope bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i>
                                {{ $model->created_at }}
                            </span>

                            <h3 class="timeline-header"><a href="#">{{ $roles->name }}</a> Membuat Ticket</h3>

                            <div class="timeline-body">
                                {{ $model->note }}
                            </div>
                            <div class="timeline-footer">

                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    @foreach($detail as $details)
                        <li>
                            <i class="fa fa-user bg-aqua"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $details->waktu }}</span>

                                <h3 class="timeline-header no-border"><a href="#">{{ $details->username }}</a>
                                    mengupdate status menjadi {{ $details->status }}</h3>
                                <div class="timeline-body">
                                    {{ $details->note }}
                                </div>
                            </div>
                        </li>
                @endforeach
                <!-- END timeline item -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-envelope bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i>
                                {{ $model->updated_at }}
                            </span>

                            <h3 class="timeline-header"><a href="#">{{ $roles->name }}</a> Menutup Ticket</h3>

                            <div class="timeline-footer">

                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline time label -->
                    <li class="time-label">
                  <span class="bg-green">
                      {{ date(' d M Y', strtotime($model->updated_at )) }}
                  </span>
                    </li>
                </ul>
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection
@section('script')
@endsection
