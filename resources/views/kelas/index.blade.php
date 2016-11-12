<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 12:57 PM
 */
?>
@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-header">Jenis Kelas</h3></div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/kelas') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Kelas</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control','id'  =>  'name'))  }}
                                </div>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-md-6">
                                    @foreach($category as $categories)
                                        <label>
                                            {{ Form::checkbox('categories[]',$categories['id'],null)}}
                                            {{ $categories['name'] }}</label><br>
                                    @endforeach
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
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" id="btn-add" name="btn-add" class="btn btn-success">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="text/javascript">
        //        jQuery(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#kelas-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('kelas.datatables') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#btn-add').click(function () {
            var name = $('#name').val();
            var kelas = $('#kelas').val();
            var categories = [];
            $('input[name="categories[]"]:checked').each(function() {
                categories.push(this.value);
            });
            $.ajax({
                url: "{{ URL::Route('kelas.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'name': name,
                    'status': true,
                    'categories': categories
                },
                success: function (result) {
                    alert(result.message);
                    table.ajax.reload();
                }
            });
            return false;
        });
    </script>
@endsection