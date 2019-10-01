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
    // Funções da área home
    Route::get('/dashboard','HomeController@index')                         ->name('home');


    Route::get('/funcionarios','UserController@index')                         ->name('user.home');
    Route::get('/funcionarios/visualizar/{uuid}','UserController@index')       ->name('user.view');
    Route::get('/funcionarios/add','UserController@index')                     ->name('user.add');
    Route::get('/funcionarios/editar/{uuid}','UserController@index')           ->name('user.edit');
    Route::get('/funcionarios/apagar/{uuid}','UserController@index')           ->name('user.del');

    //Funções da area dos responsaveis
    Route::get('/responsaveis','ResponsavelController@index')               ->name('responsaveis');
    Route::get('/responsaveis/novo','ResponsavelController@index')          ->name('responsaveis.add');
    Route::get('/responsavel/visualizar/{uuid}','ResponsavelController@index')->name('responsavel.view');
    Route::get('/responsaveis/associaveis','ResponsavelController@index')   ->name('responsaveis.associar');

    Route::get('/baixinhos','BaixinhoController@index')                     ->name('baixinhos');
    Route::get('/baixinho/novo','BaixinhoController@add')                 ->name('baixinhos.add');
    Route::post('/baixinho/historico/salvar/{uuid}','BaixinhoController@addHistorico')->name('baixinho.historico.add');
    Route::get('/baixinho/visualizar/{uuid}','BaixinhoController@view')     ->name('baixinho.view');
    Route::get('/baixinho/editar/{uuid}','BaixinhoController@index')        ->name('baixinho.edit');
    Route::post('/baixinho/apagar/{uuid}','BaixinhoController@apagar')      ->name('baixinho.del');
    Route::get('/baixinhos/galeria','BaixinhoController@galeria')           ->name('baixinhos.galerias');
    Route::get('/baixinhos/fichas-de-cadastro','BaixinhoController@index')  ->name('baixinhos.fichas');
    Route::get('/baixinhos/historico-cortes','BaixinhoController@index')    ->name('baixinhos.historicos');

    Route::get('/canais','HomeController@index')                            ->name('canais');
    Route::get('/canais/view/{uuid}','HomeController@index')                ->name('canais.view');
    Route::get('/canais/novo','HomeController@index')                       ->name('canais.add');
    Route::get('/canais/analise','HomeController@index')                    ->name('canais.analise');

    Route::post('/ficha/cadastrar','HomeController@cadastrarFicha')->name('ficha.cadastro');
});
