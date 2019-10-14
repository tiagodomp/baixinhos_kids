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
    Route::get('/responsaveis','ResponsavelController@index')                       ->name('responsaveis');
    Route::get('/responsaveis/novo','ResponsavelController@add')                    ->name('responsaveis.add');
    Route::post('/responsaveis/inserir','ResponsavelController@inserir')            ->name('responsaveis.inserir');
    Route::get('/responsavel/visualizar/{uuid}','ResponsavelController@view')       ->name('responsavel.view');
    Route::get('/responsavel/editar/{uuid}','ResponsavelController@edit')           ->name('responsavel.edit');
    Route::view('/responsaveis/associar','responsaveis.associar')                   ->name('responsaveis.associar');
    Route::post('/responsaveis/apagar/{uuid}','ResponsavelController@deletar')      ->name('responsavel.del');

    Route::get('/baixinhos','BaixinhoController@index')                                 ->name('baixinhos');
    Route::get('/baixinho/novo','BaixinhoController@add')                               ->name('baixinhos.add');
    Route::post('/baixinho/historico/salvar/{uuid}','BaixinhoController@addHistorico')  ->name('baixinho.historico.add');
    Route::get('/baixinho/visualizar/{uuid}','BaixinhoController@view')                 ->name('baixinho.view');
    Route::get('/baixinho/editar/{uuid}','BaixinhoController@index')                    ->name('baixinho.edit');
    Route::post('/baixinho/apagar/{uuid}','BaixinhoController@apagar')                  ->name('baixinho.del');
    Route::get('/baixinhos/galeria','BaixinhoController@galeria')                       ->name('baixinhos.galerias');
    Route::post('/baixinhos/inserir/img/{uuid}','BaixinhoController@addImg')                    ->name('baixinhos.addImg');
    Route::get('/baixinhos/fichas-de-cadastro','BaixinhoController@fichascadastro')     ->name('baixinhos.fichas');
    Route::post('/baixinho/ficha-de-cadastro/{uuid}','BaixinhoController@addFichaCadastro')  ->name('baixinho.ficha.add');
    Route::get('/baixinhos/historico-cortes','BaixinhoController@historico')            ->name('baixinhos.historicos');

    Route::get('/canais','CanalController@index')                            ->name('canais');
    Route::get('/canais/view/{uuid}','CanalController@index')                ->name('canais.view');
    Route::view('/canais/novo','canais.add')                                 ->name('canais.add');
    Route::post('/canais/inserir','CanalController@inserir')                 ->name('canais.inserir');
    Route::get('/canais/editar/{uuid}','CanalController@index')              ->name('canal.edit');
    Route::get('/canais/apagar/{uuid}','CanalController@index')              ->name('canal.del');
    Route::view('/canais/analise','canais.analise')                          ->name('canais.analise');

    Route::post('/ficha/cadastrar','HomeController@cadastrarFicha')->name('ficha.cadastro');
});
