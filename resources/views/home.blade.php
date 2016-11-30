@extends('layouts.index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">News Feed</div>

                    <div class="panel-body">
                        @foreach($pengumuman as $pengumumans)
                            <div class="col-xs-12">
                                <!-- The time line -->
                                <ul class="timeline">
                                    <!-- timeline time label -->
                                    <li class="time-label">
                                        <span class="bg-green">{{ date(' d M Y', strtotime($pengumumans->created_at )) }}</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-feed bg-blue"></i>
                                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i>
                                {{ $pengumumans->created_at }}
                            </span>

                                            <h3 class="timeline-header"><a href="#">{{ $pengumumans->username}}</a>
                                                Membuat Pengumuman</h3>

                                            <div class="timeline-body">
                                                {{ $pengumumans->note }}
                                            </div>
                                            <div class="timeline-footer">
                                                {{ Form::open([
                                                'method'  =>   'post',
                                                'target'    =>  '_blank',
                                                'url'   =>  route('ticket.history')
                                                ]) }}
                                                {{ Form::hidden('id',$pengumumans->id_feedbacks) }}
                                                {{ Form::submit('Lihat Detail Ticket',['class'  =>  'btn btn-default']) }}
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
