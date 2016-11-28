<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/22/2016
 * Time: 8:15 PM
 */
?>
@extends('layouts.index')
@section('header')
    Performance Dosen
@endsection
@section('submenu')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3>
                            Jadwal
                        </h3>
                    </div>
                    <div class="box-body">

                        <table class="display" cellspacing="0" width="100%" id="kelas-table" name="kelas-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mata Kuliah</th>
                                <th>Tahun Ajaran</th>
                                <th>Ruang</th>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Qty</th>
                                <th>Dosen</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12" id="centent-data">
                        <div id="loader" class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="box box-default" id="content-nilai">
                            <div class="box-header">
                                Penilaian
                            </div>
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div id="data-nilai">

                                    </div>
                                </div>
                            </div>
                        </div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

//            $('select').select2();
            $('#loader').hide();
            $('#content-nilai').hide();
            var table = $('#kelas-table').DataTable({ rowReorder: { 	selector: 'td:nth-child(2)'             }, 	responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('dosen.datatables') }}',
                columns: [
                    {data: 'jadwal_id', name: 'jadwal_id', visible: false},
                    {data: 'matkul', name: 'matkul'},
                    {data: 'tahun_ajaran', name: 'tahun_ajaran'},
                    {data: 'ruang', name: 'ruang'},
                    {data: 'hari', name: 'hari'},
                    {data: 'time_start', name: 'time_start'},
                    {data: 'time_end', name: 'time_end'},
                    {data: 'qty', name: 'qty'},
                    {data: 'nama_dosen', name: 'nama_dosen'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#kelas-table tbody').on('click', 'button', function () {
                var id = table.row($(this).parents('tr')).data().jadwal_id;
//                var matkul = table.row($(this).parents('tr')).data().matkul;
//                alert(id + ' ' + matkul);
//                console.log(id);
//                console.log(matkul);
                $('#loader').show();
                $.ajax({
                   url: "{{ route('dosen.nilai') }}",
                    type: 'post',
                    data: {
                        _token: "<?php echo csrf_token(); ?>",
                        id: id
                    },
                    success: function (data) {
                        if(data.data.length == 0){
                            data.data = 'Tidak ada Data Angket untuk Jadwal ini !';
                        }
                        $('#data-nilai').html(data.data);
                        $(".display-rating-tok").rating({displayOnly: true, step: 0.5});
                        $('#loader').hide();
                        $('#content-nilai').show();
//                        console.log(data);
                    },
                    error: function () {
                        console.log(data);
                    }
                });
            });

        })
    </script>
@endsection
