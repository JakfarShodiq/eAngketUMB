<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 12/1/2016
 * Time: 3:54 PM
 */
?>
@extends('layouts.index')
@section('header')
    Roles
@endsection
@section('submenu')
    Index
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
                        {{ Form::open(['class'  => 'form-horizontal',
                        'method'    =>  'post',
                        'url'   =>  route('roles.store')
                        ]) }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nama Role</label>
                            <div class="col-md-6">
                                {{ Form::text('name','',array('class'   => 'form-control','id'  =>  'name'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="btn-add" name="btn-add" class="btn btn-success">
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                        {{ Form::close() }}

                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>Namesss</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-body">
                        {{ Form::open(['class'  => 'form-horizontal',
                            'method'    =>  'post',
                            'url'   =>  ''
                            ]) }}
                        <div class="form-group">
                            <label for="id" class="col-md-4 control-label">Role ID</label>
                            <div class="col-md-6">
                                {{ Form::text('id','',array('class'   => 'form-control','id'  =>  'id','readonly'))  }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_name" class="col-md-4 control-label">Nama Role</label>
                            <div class="col-md-6">
                                {{ Form::text('role_name','',array('class'   => 'form-control','id'  =>  'role_name'))  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="btn-update" name="btn-add" class="btn btn-success"
                                        disabled="true">
                                    Update
                                </button>
                            </div>
                        </div>
                        {{ Form::close() }}
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
        $(document).ready(function () {
            $('#btn-update').prop('disabled', 'disabled');
            var table = $('#kelas-table').DataTable({
                rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                select: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('roles.datatables') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            var id = $('#id');
            var role = $('#role_name');

            table
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = table.rows(indexes).data().toArray();
//                        var user_id = rowData[0].id;
                        id.val(rowData[0].id);
                        role.val(rowData[0].name);
                        $('#btn-update').prop('disabled', false);
                    })
                    .on('deselect', function (e, dt, type, indexes) {
                        id.val(null);
                        role.val(null);
                        $('#btn-update').prop('disabled', 'disabled');
                    });
        });

    </script>
@endsection
