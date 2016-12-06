<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
//    return view('welcome');
    return redirect()->to('/home');
});
Auth::routes();
Route::get('/register', [
    'uses' => 'Auth\RegisterController@showRegistrationForm',
    'as' => 'register'
]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/master/', 'HomeController@master');
    Route::get('categories/role', [
        'uses' => 'CategoriesController@testRelation',
        'as' => 'categories.relation'
    ]);
    Route::get('categories/datatables', array(
        'uses' => 'CategoriesController@getDatatables',
        'as' => 'categories.datatables'
    ));
    Route::get('categories/jenispt/{id}', [
        'uses' => 'CategoriesController@getJenisPT',
        'as' => 'categories.jenispt'
    ]);
    Route::resource('categories', 'CategoriesController');
    Route::get('kelas/category/{id}', [
        'uses' => 'KelasController@kelas_categories',
        'as' => 'kelas.category'
    ]);
    Route::get('kelas/categories/jenispt', [
        'as' => 'kelas.categories.jenispt',
        'uses' => 'KelasController@getJenisPTCat'
    ]);
    Route::get('kelas/jenispt/{id}', [
        'uses' => 'KelasController@getJenisPt',
        'as' => 'kelas.jenispt'
    ]);
    Route::get('kelas/datatables', array(
        'uses' => 'KelasController@getDatatables',
        'as' => 'kelas.datatables'
    ));
    Route::resource('kelas', 'KelasController');

    Route::get('jenis_pertanyaan/datatables', array(
        'uses' => 'JenisPTController@getDatatables',
        'as' => 'jenis_pertanyaan.datatables'
    ));
    Route::resource('jenis_pertanyaan', 'JenisPTController');
    Route::get('pertanyaan/datatables', array(
        'uses' => 'PertanyaanController@getDatatables',
        'as' => 'pertanyaan.datatables'
    ));
    Route::resource('pertanyaan', 'PertanyaanController');
    Route::get('user/datatables', array(
        'uses' => 'UserController@getDatatables',
        'as' => 'user.datatables'
    ));
    Route::get('user-mgt', [
        'uses' => 'UserController@manageUsers',
        'as' => 'user.role'
    ]);
    Route::post('user/permission-update', [
        'uses' => 'UserController@permission_update',
        'as' => 'user.permission-update'
    ]);
    Route::get('reset-password/{id}', [
        'uses' => 'UserController@resetpassword',
        'as' => 'user.reset-password'
    ]);
    Route::resource('user', 'UserController');
    Route::get('matakuliah/datatables', array(
        'uses' => 'MatakuliahController@getDatatables',
        'as' => 'matakuliah.datatables'
    ));
    Route::resource('matakuliah', 'MatakuliahController');
    Route::get('jadwal/datatables', array(
        'uses' => 'JadwalController@getDatatables',
        'as' => 'jadwal.datatables'
    ));
    Route::resource('jadwal', 'JadwalController');

    Route::get('jadwal-mhs-jadwal/datatables', array(
        'uses' => 'JadwalMhsController@getJadwalDatatables',
        'as' => 'jadwal_mhs_jadwal.datatables'
    ));
    Route::get('jadwal-mhs-enroll/datatables', array(
        'uses' => 'JadwalMhsController@getMhsDatatable',
        'as' => 'jadwal_mhs_enroll.datatables'
    ));
    Route::resource('jadwal-mhs', 'JadwalMhsController');
    Route::get('angket/datatables', array(
        'uses' => 'AngketsController@getMhsDatatable',
        'as' => 'angket.datatables'
    ));
    Route::get('angket/jadwal/{id}', [
        'uses' => 'AngketsController@jadwal',
        'as' => 'angket.jadwal'
    ]);
    Route::resource('angket', 'AngketsController');
    Route::get('dosen/datatables', array(
        'uses' => 'DosenController@getDatatables',
        'as' => 'dosen.datatables'
    ));
    Route::post('dosen/nilai', [
        'uses' => 'DosenController@nilai',
        'as' => 'dosen.nilai'
    ]);
    Route::resource('dosen', 'DosenController');
    //REPORT ISSUE
    Route::get('report/datatables-general', array(
        'uses' => 'ReportController@datatables_general',
        'as' => 'report.datatables-general'
    ));
    //DISPLAY GENERAL ISSUE
    Route::post('report/general-detail',
        [
            'uses' => 'ReportController@general_detail',
            'as' => 'report.general-detail'
        ]
    );
    //DISPLAY GENERAL DETAIL ISSUE
    Route::get('report/datatables-general-detail', array(
        'uses' => 'ReportController@datatables_general_detail',
        'as' => 'report.datatables-general-detail'
    ));

    Route::get('report/perf', [
        'uses' => 'ReportController@index_perf',
        'as' => 'report.perf'
    ]);

    Route::get('report/datatables-performance', array(
        'uses' => 'ReportController@datatables_performance',
        'as' => 'report.datatables-performance'
    ));

    //DISPLAY GENERAL ISSUE
    Route::post('report/perf-detail',
        [
            'uses' => 'ReportController@performance_detail',
            'as' => 'report.perf-detail'
        ]
    );

    Route::get('report/datatables-perf-detail', array(
        'uses' => 'ReportController@datatables_performance_detail',
        'as' => 'report.datatables-perf-detail'
    ));

    Route::get('report/datatables-penilaian-mhs', array(
        'uses' => 'ReportController@datatables_penilaian_mhs',
        'as' => 'report.datatables-penilaian-mhs'
    ));

    Route::get('report/penilaian-mhs', array(
        'uses' => 'ReportController@index_penilaian_mhs',
        'as' => 'report.index-penilaian-mhs'
    ));

    Route::resource('report', 'ReportController');

    Route::get('issue/datatables', array(
        'uses' => 'IssueController@getDatatables',
        'as' => 'issue.datatables'
    ));
    Route::resource('issue', 'IssueController');

    Route::get('ticket/datatables', array(
        'uses' => 'FeedbacksController@getDatatables',
        'as' => 'ticket.datatables'
    ));
    Route::get('ticket/datatables-detail', array(
        'uses' => 'FeedbacksController@generateTableDetail',
        'as' => 'ticket.datatables-detail'
    ));
    Route::post('ticket/history', [
        'uses' => 'FeedbacksController@history',
        'as' => 'ticket.history'
    ]);
    Route::resource('ticket', 'FeedbacksController');

    Route::resource('ticket-details', 'FeedbackDetailsController');

    Route::get('pengumuman/datatables', array(
        'uses' => 'PengumumanController@getPengumuman',
        'as' => 'pengumuman.datatables'
    ));
    Route::resource('pengumuman', 'PengumumanController');

    Route::get('roles/datatables', array(
        'uses' => 'RolesController@getDatatables',
        'as' => 'roles.datatables'
    ));
    Route::post('roles/update-role', array(
        'uses' => 'RolesController@updateRoles',
        'as' => 'roles.update-role'
    ));
    Route::resource('roles', 'RolesController');
});