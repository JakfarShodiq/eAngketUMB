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
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/master/','HomeController@master');
Route::resource('categories','CategoriesController');
Route::get('kelas/category/{id}',[
    'uses'  =>  'KelasController@kelas_categories',
    'as'    =>  'kelas.category'
]);
Route::get('kelas/datatables',array(
    'uses'  =>  'KelasController@getDatatables',
    'as'    =>  'kelas.datatables'
));
Route::resource('kelas','KelasController');

Route::get('jenis_pertanyaan/datatables',array(
    'uses'  =>  'JenisPTController@getDatatables',
    'as'    =>  'jenis_pertanyaan.datatables'
));
Route::resource('jenis_pertanyaan','JenisPTController');
Route::get('pertanyaan/datatables',array(
    'uses'  =>  'PertanyaanController@getDatatables',
    'as'    =>  'pertanyaan.datatables'
));
Route::resource('pertanyaan','PertanyaanController');
Route::resource('user','UserController');