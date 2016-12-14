<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/30/2016
 * Time: 3:45 PM
 */
?>
@extends('layouts.index')
@section('header')
    User Management
@endsection
@section('submenu')

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
                        <form class="form-horizontal" id="data-filter" role="form" method="POST" action="#">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="periode" class="col-md-4 control-label">Role</label>
                                <div class="col-sm-6">
                                    {{ Form::select('roles',$roles,'all',['id'    =>  'roles','class'    =>  'form-control select2']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="semester" class="col-md-4 control-label">Nama</label>
                                <div class="col-sm-6">
                                    {{ Form::text('name','',['id'=>'name']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" id="filter" name="filter" class="btn btn-info">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK / NIM</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="box-header">
                            <h3>Update Role</h3>
                        </div>
                        {{ Form::open([
                        'method'    =>  'post',
                        'url'   =>  route('user.permission-update')
                        ]) }}
                        <div class="form-group row">
                            <label for="id_user" class="col-sm-4 control-label">ID User</label>
                            <div class="col-sm-6">
                                {{ Form::text('id_user','',array('class'   => 'form-control','id'  =>  'id_user','readonly'))  }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-6">
                                {{ Form::text('nama','',array('class'   => 'form-control','id'  =>  'nama'))  }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="identity_number" class="col-sm-4 control-label">NIM / NIK</label>
                            <div class="col-sm-6">
                                {{ Form::text('identity_number','',array('class'   => 'form-control','id'  =>  'identity_number'))  }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_id" class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-6">
                                {{ Form::select('role_id',$default_roles,'',['id'  =>  'role_id','class'   =>  'select2']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="btn-add" type="submit" name="btn-add" class="btn btn-success">
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
        $(document).ready(function () {
            $('#btn-add').prop('disabled', 'disabled');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#kelas-table').DataTable({
                rowReorder: {selector: 'td:nth-child(2)'}, responsive: true,
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
                "<'row'<'col-xs-12't>>" +
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                select: true,
                ajax: {
                    url: '{{ route('user.datatables') }}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.role_id = $('#roles').val();
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'identity_number', name: 'identity_number'},
                    {data: 'role', name: 'role', orderable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
//            $('select').select2();
            $('#data-filter').submit(function (e) {
                e.preventDefault();
                var name = $('#name').val();
                var roles = $('#roles').val();
                console.log(name);
                console.log(roles);
                table.draw();
                return false;
            });

            var id_user = $('#id_user');
            var nama = $('#nama');
            var nim = $('#identity_number');
            var role_id = $('#role_id');

            table
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = table.rows(indexes).data().toArray();
//                        var user_id = rowData[0].id;
                            console.log(rowData[0]);
                        id_user.val(rowData[0].id);
                        nama.val(rowData[0].name);
                        nim.val(rowData[0].identity_number);
                        role_id.val(rowData[0].role_id);
                        $('#btn-add').prop('disabled', false);
                    })
                    .on('deselect', function (e, dt, type, indexes) {
                        id_user.val(null);
                        nama.val(null);
                        nim.val(null);
                        role_id.val(null);
                        $('#btn-add').prop('disabled', 'disabled');
                    });
        })
    </script>
@endsection
