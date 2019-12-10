@extends('layouts.pages')

@section('content')
{{--  Ficha Cadastro area start  --}}
<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Criar novo Responsável</h4>
                <form action={{route('responsaveis.inserir')}} class="col-md-12" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="canalUuid">Como nos conheceu?</label>
                            <div class="row">
                                <a class="btn btn-outline-success mr-3"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#collapseCanais"
                                    aria-expanded="false"
                                    aria-controls="collapseCanais" >
                                    add
                                </a>
                                <select class="selectpicker show-tick"
                                        name="canalUuid"
                                        title="Escolha um Canal..."
                                        id="canalUuid"
                                        data-live-search="true"
                                        data-size="5"
                                        data-width="auto">
                                    @foreach($canais as $canal)
                                        <option value={{$canal['uuid']}}>{{$canal['titulo']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="collapse multi-collapse" id="collapseCanais">
                                <div class="card card-body">
                                    <div class="form-group">
                                        <label for="tituloCanal">Titulo</label>
                                        <input type="text" name="tituloCanal" class="form-control" id="tituloCanal" placeholder="Titulo do Canal">
                                    </div>
                                    <div class="form-group">
                                        <label for="descricaoCanal">Descrição</label>
                                        <input type="textarea" name="descricaoCanal" class="form-control" id="descricaoCanal" placeholder="Breve descrição...">
                                    </div>
                                    <div class="form-group">
                                        <label for="tecnicasCanal">Regras</label>
                                        <input type="textarea" name="tecnicasCanal" class="form-control" id="tecnicasCanal" placeholder="Regras para lidar com os membros deste canal...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nomeR">Nome</label>
                        <input type="text" name="nomeR" class="form-control" id="nomeR" placeholder="Nome completo do responsável">
                    </div>
                    <div class="form-group">
                        <label for="contatosR[0][email]">E-mail</label>
                        <input type="email" name="contatosR[0][email]" class="form-control" id="email" placeholder="E-mail principal do Responsável">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contatosR[0][tell]">Telefone</label>
                            <input type="text" name="contatosR[0][tell]" class="form-control" id="tell" placeholder="Telefone principal do Responsável">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contatosR[0][cell]">Celular</label>
                            <input type="text" name="contatosR[0][cell]" class="form-control" id="cell" placeholder="Celular principal do Responsável">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="imagensR[]" placeholder="clique e selecione uma imagem" class="custom-file-input" id="imagensR" multiple>
                                <label class="custom-file-label" for="imagensB">Adicione fotos associada a este responsável</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{--  Ficha Cadastro area end  --}}
@endsection()
