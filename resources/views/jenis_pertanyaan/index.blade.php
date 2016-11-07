<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 1:41 PM
 */
?>
@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-header">Kategori Pertanyaan</h3></div>
                    <div class="box-body">
                        <form id="form-data" class="form-horizontal" role="form" method="POST" action="">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="kelas" class="col-md-4 control-label">Pilih Kelas</label>
                                <div class="col-md-6">
                                    {{ Form::select('kelas',$kelas) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control'))  }}
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

                        <table class="table table-bordered" id="users-table" name="users-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Kategory Kelas</th>
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
        var name = $('#name').val();
        var kelas = $('#kelas').val();
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('jenis_pertanyaan.datatables') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'kelas_category', name: 'kelas_category'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#btn-add').click(function () {
            alert('test');
            $.ajax({
                url: "{{ URL::Route('jenis_pertanyaan.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'name': name,
                    'kelas': kelas
                },
                success: function (result) {
                    if (!result.success) {
                        $('#report-data').append(result.message);
                    } else {
                        $('#report-data').append(result.result);
                    }
                    table.ajax.reload();
                }
            });
        });
        //        });
    </script>
@endsection