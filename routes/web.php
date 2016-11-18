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
    Route::resource('categories', 'CategoriesController');
    Route::get('kelas/category/{id}', [
        'uses' => 'KelasController@kelas_categories',
        'as' => 'kelas.category'
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
});