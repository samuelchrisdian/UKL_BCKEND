<?php

use Illuminate\Http\Request;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('siswa/{limit}/{offset}', 'SiswaController@getAll');

Route::middleware(['jwt.verify'])->group(function(){
    
    //petugas
    Route::get('user/{limit}/{offset}', "UserController@getAll");
    Route::post('user/{limit}/{offset}', "UserController@find");
    Route::delete('user/delete/{id}', "UserController@delete");
    Route::post('user/ubah', "UserController@ubah");

    //siswa
    Route::post('siswa/daftar', 'SiswaController@daftar');
	Route::post('siswa/{limit}/{offset}', 'SiswaController@find');
	Route::post('siswa/update', 'SiswaController@update');
    Route::delete('siswa/delete/{id}', 'SiswaController@delete');
    
    //pelanggaran
    Route::get('pelanggaran/{limit}/{offset}', 'PelanggaranController@getAll');
    Route::post('pelanggaran/tambah', 'PelanggaranController@tambah');
	Route::post('pelanggaran/{limit}/{offset}', 'PelanggaranController@find');
	Route::post('pelanggaran/update', 'PelanggaranController@update');
    Route::delete('pelanggaran/delete/{id}', 'PelanggaranController@delete');

    //poin
    Route::post('addPoin/{id}', "PoinSiswaController@add");
    Route::get('detail/{limit}/{offset}', "PoinSiswaController@detailPoin");
	Route::get('poin/{limit}/{offset}', "PoinSiswaController@getAll");
	Route::post('pinjam/{limit}/{offset}', "PinjamController@find");
});
