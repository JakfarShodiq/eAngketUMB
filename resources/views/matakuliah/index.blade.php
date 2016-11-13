<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 12:57 PM
 */
?>
@extends('layouts.index')
@section('header')
    Mata Kuliah
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
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Mata Kuliah</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control','id'  =>  'name'))  }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Jumlah SKS</label>
                                <div class="col-md-4">
                                    {{ Form::number('sks', '',['id'   =>  'sks','min'    =>  0]) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Kelas</label>
                                <div class="col-md-4">
                                            {{ Form::select('kelas',$kelas,'',['id'   =>  'kelas','class'   =>  'form-control select2'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="roles">Semester</label>
                                <div class="col-md-4">
                                    {{ Form::select('semester',['Ganjil'  =>  'Ganjil','Genap'  =>  'Genap'],'',['id'   =>  'semester','class'   =>  'form-control select2'])}}
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
                                <th>Mata Kuliah</th>
                                <th>Semester</th>
                                <th>SKS</th>
                                <th>Jenis Kelas</th>
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
            ajax: '{{ route('matakuliah.datatables') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'semester', name: 'semester'},
                {data: 'sks', name: 'sks'},
                {data: 'kelas_name', name: 'kelas_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
//                ->select(['matakuliah.id', 'matakuliah.name', 'matakuliah.semester','matakuliah.sks','kelas.name as kelas_name']);
        ]
        });
        $('#btn-add').click(function () {
            var name = $('#name').val();
            var sks = $('#sks').val();
            var semester = $('#semester').val();
            var kelas = $('#kelas').val();

            $.ajax({
                url: "{{ URL::Route('matakuliah.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'name': name,
                    'sks': sks,
                    'semester': semester,
                    'kelas'    : kelas
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