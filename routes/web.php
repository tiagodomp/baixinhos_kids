<?php

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('home', function () {
    return redirect()->route('home');
});
Route::get('teste',	'HomeController@teste');
Route::get('teste1',	'TesteController@teste');
Route::get('teste3',	'HomeController@teste3');

Auth::routes();
Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard','HomeController@index')      ->name('home');
	Route::get('/responsaveis','HomeController@index')   ->name('responsaveis');
	Route::get('/baixinhos','HomeController@index')      ->name('baixinhos');
	Route::get('/funcionarios','HomeController@index')   ->name('funcionarios');
    Route::get('/canais','HomeController@index')         ->name('canais');

    Route::post('/ficha/cadastrar','HomeController@cadastrarFicha')->name('ficha.cadastro');
});
