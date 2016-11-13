<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/5/2016
 * Time: 10:57 AM
 */
?>
@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-header">Kategori Kelas</h3></div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/categories') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    {{ Form::text('name','',array('class'   => 'form-control','id'  =>  'name'))  }}
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
                                <label class="col-md-4 control-label" for="roles">Roles</label>
                                <div class="col-md-4">
                                    @foreach($roles as $role)
                                        <label class="checkbox-inline" for="roles-0">
                                            <label>
                                                {{ Form::checkbox('pic[]',$role['id'],null,['class' =>  'minimal'])}}
                                                {{ $role['name'] }}</label>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-success" id="btn-add" name="btn-add">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered" id="categories-table" name="categories-table">
                            <thead>
                            <tr>
                                <th>Nama Layanan</th>
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

        var table = $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('categories.datatables') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#btn-add').click(function () {
            var name = $('#name').val();
            var pic = [];
            $('input[name="pic[]"]:checked').each(function () {
                pic.push(this.value);
            });
            var status = $("input[name=status]:checked").val();
            console.log(name,pic,status);
            $.ajax({
                url: "{{ URL::Route('categories.store') }}",
                type: "post",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    'name': name,
                    'status': status,
                    'pic': pic
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