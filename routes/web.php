<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Controller@index');
Route::get('/Kriteria', 'Controller@Kriteria');



Route::get("/PerhitunganFT","Controller@PerhitunganFT");
Route::get("/Seleksi_FT","Controller@Seleksi_FT");

Route::get('/NFDM','Controller@NFDM');
Route::get('/PBHNFDM','Controller@PBHNFDM');
Route::get('/FPIS_FNIS','Controller@FPIS_FNIS');
Route::get('/jarak_FPIS_FNIS','Controller@jarak_FPIS_FNIS');
Route::get('/hasilAwal','Controller@hasilAwal');



Route::get('sawPage','Controller@sawPage');
Route::get('fuzzytopsisPage','PageController@fuzzytopsisPage');

Route::get('/PenilaianFT', 'PageController@PenilaianFT');

Route::get('/Penilaian', 'Controller@Penilaian');


Route::get('/Skkm', 'SKKMController@Skkm');


Route::get('/Mahasiswa', 'Controller@Mahasiswa');


Route::get('Skkm/route_tambah_skkm', 'SKKMController@route_tambah_skkm');
Route::post('/Skkm/store_skkm','SKKMController@store_skkm');
Route::post('/Skkm/edit_skkm/{id}', 'SKKMController@edit_skkm');
Route::post('/Skkm/delete_skkm/{id}', 'SKKMController@delete_skkm');
Route::get('/Skkm/hasil', 'SKKMController@hasil_skkm');


Route::get('/adak_registrasi','AdakRegistrasiController@index');
Route::get('/adak_registrasi/export_excel','AdakRegistrasiController@export_excel');
Route::post('/adak_registrasi/import_excel', 'AdakRegistrasiController@import_excel');

Route::get('/askm_dim_penilaian','DimPenilaianController@index');
Route::get('/askm_dim_penilaian/export_excel','DimPenilaianController@export_excel');
Route::post('/askm_dim_penilaian/import_excel', 'DimPenilaianController@import_excel');

Route::get('/dimx_dim','DimxDimController@index');
Route::get('/dimx_dim/export_excel','DimxDimController@export_excel');
Route::post('/dimx_dim/import_excel', 'DimxDimController@import_excel');
