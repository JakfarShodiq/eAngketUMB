<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 1:41 PM
 */
?>
@extends('layouts.index')
@section('header')
    Jenis Pertanyaan
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
                        <form id="form-data" class="form-horizontal" role="form" action="" url="">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="kelas" class="col-md-4 control-label">Pilih Kelas</label>
                                <div class="col-md-6">
                                    {{ Form::select('kelas',$kelas,'',array('id'   =>  'kelas','class'  => 'form-control select2')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categories" class="col-md-4 control-label">Pilih Jenis Pelayanan</label>
                                <div class="col-md-6">
                                    {{ Form::select('categories',$categories,'',array('id'   =>  'categories','class'  => 'form-control select2')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control','id'  =>  'name'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="btn-add" name="btn-add" class="btn btn-success">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table class="display" cellspacing="0" width="100%" id="users-table" name="users-table">
                            <thead>
                            <tr>
                                <th>Jenis Pertanyaan</th>
                                <th>Kategory Layanan</th>
                                <th>Kategory Kelas</th>
                                <th>Created At</th>
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

        var table = $('#users-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('jenis_pertanyaan.datatables') }}',
            columns: [
                {data: 'jenispt_name', name: 'jenispt_name'},
                {data: 'categories_name', name: 'categories_name'},
                {data: 'kelas_name', name: 'kelas_name'},
                {data: 'created', name: 'created',orderable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#kelas').change(function () {
            var kelas = $('#kelas').val();
            console.log(kelas);
            $.get('kelas/category/'+kelas, function (data) {
                console.log(data);
                $('#categories').empty();
                $('#categories').html(data.select_categories);
                console.log(data.select_categories);
            })
        });

        $('#btn-add').click(function () {
            var name = $('#name').val();
            var kelas = $('#kelas').val();
            var categories = $('#categories').val();
            $.ajax({
                url: "{{ URL::Route('jenis_pertanyaan.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'name': name,
                    'kelas': kelas,
                    'categories': categories
                },
                success: function (result) {
                    alert(result.message);
                    table.ajax.reload();
                }
            });
            return false;
        });

//        $('#btn-delete').click(function () {
//            var del_url = $('btn-delete').attr('href');
//            alert(del_url);
//            $.ajax({
//                        url: del_url,
//                        type: 'DELETE',
//                        success: function () {
//                            console.log(result.message);
//                            table.ajax.reload();
//                        }
//                    }
//            )
//            return false;
//        });

        function DeleteData(id) {
            $.ajax({
                url: id,
                type: 'DELETE',
                success: function (result) {
                    console.log(result.message);
                    console.log(result.request);
                    table.ajax.reload();
                }
            })
        }

    </script>
@endsection