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

Route::get('/dimx_dim','DimxDimController@index');
Route::get('/dimx_dim/export_excel','DimxDimController@export_excel');
Route::post('/dimx_dim/import_excel', 'DimxDimController@import_excel');

Route::get('/adak_registrasi','AdakRegistrasiController@index');
Route::get('/adak_registrasi/export_excel','AdakRegistrasiController@export_excel');
Route::post('/adak_registrasi/import_excel', 'AdakRegistrasiController@import_excel');

Route::get('/askm_dim_penilaian','DimPenilaianController@index');
Route::get('/askm_dim_penilaian/export_excel','DimPenilaianController@export_excel');
Route::post('/askm_dim_penilaian/import_excel', 'DimPenilaianController@import_excel');

Route::get('/Mahasiswa', 'SawController@index');
Route::get('/PenilaianSaw', 'SawController@PenilaianSaw');
Route::get('/hasilAkhirSaw', 'SawController@hasilAkhirSaw');

Route::get("/PerhitunganFT","FuzzyTopsisController@PerhitunganFT");
Route::get("/Seleksi_FT","FuzzyTopsisController@Seleksi_FT");
Route::get('/NFDM','FuzzyTopsisController@NFDM');
Route::get('/PBHNFDM','FuzzyTopsisController@PBHNFDM');
Route::get('/FPIS_FNIS','FuzzyTopsisController@FPIS_FNIS');
Route::get('/jarak_FPIS_FNIS','FuzzyTopsisController@jarak_FPIS_FNIS');
Route::get('/hasilAwal','FuzzyTopsisController@hasilAwal');
Route::get('/hasilAkhirFT','FuzzyTopsisController@hasilAkhirFT');

Route::get('Skkm/route_tambah_skkm', 'SKKMController@route_tambah_skkm');
Route::post('/Skkm/store_skkm','SKKMController@store_skkm');

Route::post('/Skkm/edit_skkm/{id}', 'SKKMController@edit_skkm');
Route::post('/Skkm/edit_skkm_ft/{id}', 'SKKMController@edit_skkm_ft');

Route::post('/Skkm/delete_skkm/{id}', 'SKKMController@delete_skkm');

Route::get('/perbandingan','PageController@perbandingan');
