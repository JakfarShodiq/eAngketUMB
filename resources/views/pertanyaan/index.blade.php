<?php
/**
 * Created by PhpStorm.
 * User: Fajar Ramdhani
 * Date: 11/5/2016
 * Time: 1:41 PM
 */
?>
@extends('layouts.index')
@section('header')
    Master Pertanyaan
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
                                    {{ Form::select('kelas',$kelas,'',array('id'   =>  'kelas','class'   =>  'form-control select2')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categories" class="col-md-4 control-label">Pilih Layanan</label>
                                <div class="col-md-6">
                                    {{ Form::select('categories',$categories,'',array('id'   =>  'categories','class'   =>  'form-control select2')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jenispt" class="col-md-4 control-label">Pilih Jenis Pertanyaan</label>
                                <div class="col-md-6">
                                    {{ Form::select('jenispt',$jenispt,'',array('id'   =>  'jenispt','class'   =>  'form-control select2')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pertanyaan" class="col-md-4 control-label">Pertanyaan </label>
                                <div class="col-md-6">
                                    {{ Form::textarea('pertanyaan','',array('class'   => 'form-control','id'  =>  'pertanyaan'))  }}
                                </div>
                            </div>

                            <!-- Multiple Radios -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="status">Status</label>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label for="status-0">
                                            <input type="radio" name="status" id="status-0" value="1" checked="checked">
                                            Active
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="status-1">
                                            <input type="radio" name="status" id="status-1" value="0">
                                            InActive
                                        </label>
                                    </div>
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
                                <th>Kategory Kelas</th>
                                <th>Kategory Layanan</th>
                                <th>Jenis Pertanyaan</th>
                                <th>Pertanyaan</th>
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

        var table = $('#users-table').DataTable({
            rowReorder: {selector: 'td:nth-child(2)'},
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('pertanyaan.datatables') }}',
            columns: [
//                ->select(['jenis_pt.id as id', 'jenis_pt.name as jenispt_name', 'categories.name as categories_name','kelas.name as kelas_name']);
//                ->select(['pertanyaan.id as id', 'pertanyaan.text', 'pertanyaan.status','categories.name as categories_name','kelas.name as kelas_name']);
                {data: 'kelas_name', name: 'kelas.name'},
                {data: 'categories_name', name: 'categories.name'},
                {data: 'jenis_pt_name', name: 'jenis_pt.name'},
                {data: 'text', name: 'text'},
                {data: 'status', name: 'status',searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function generate_categories() {
            var kelas = $('#kelas').val();
            var categories = $('#categories').val();
            $.ajax({
                url: "{{ route('kelas.categories.jenispt') }}",
                type: "get",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    kelas: kelas,
                    categories: categories
                },
                success: function (result) {
                    console.log(result.select_jenispt)
                    $('#jenispt').empty();
                    $('#jenispt').html(result.select_jenispt);
                }
            });
        }

        generate_categories();

        $('#kelas').change(function () {
            var kelas = $('#kelas').val();
            $.get('kelas/category/' + kelas, function (data) {
                console.log(data);
                $('#categories').empty();
                $('#categories').html(data.select_categories);
                generate_categories();
//                $('#jenispt').empty();
//                $('#jenispt').html(data.select_jenispt);
            })
        });

        $('#categories').change(function () {
            generate_categories();
        });
        $('#btn-add').click(function () {
            var kelas = $('#kelas').val();
            var categories = $('#categories').val();
            var jenispt = $('#jenispt').val();
            var pertanyaan = $('#pertanyaan').val();
            var status = $("input[name='status']:checked").val();

            $.ajax({
                url: "{{ URL::Route('pertanyaan.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'kelas': kelas,
                    'categories': categories,
                    'jenis_pt': jenispt,
                    'text': pertanyaan,
                    'status': status
                },
                success: function (result) {
                    console.log(result.messages);
                    alert(result.messages);
                    table.ajax.reload();
                    $('.form-horizontal').reset();
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