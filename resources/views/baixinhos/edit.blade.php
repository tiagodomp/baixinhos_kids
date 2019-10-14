@extends('layouts.pages')

@section('content')
{{--  Ficha Cadastro area start  --}}
<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Ficha de cadastro</h4>
                <form action={{route('ficha.cadastro')}} class="col-md-12" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="responsavelUuid">Quem é o Responsável?</label>
                            <div class="row">
                                <a class="btn btn-outline-success mb-3 col-md-2"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#collapseResponsaveis"
                                    aria-expanded="false"
                                    aria-controls="collapseResponsaveis">
                                    <i class="fa fa-user-plus"></i>
                                    add
                                </a>
                                <select class="selectpicker show-tick col-md-8"
                                        name="responsavelUuid"
                                        title="Selecione o Responsável..."
                                        id="responsavelUuid"
                                        data-show-subtext="true"
                                        data-live-search="true"
                                        data-size="5"
                                        data-width="auto">
                                        <option value={{$data['uuid']}}  data-tokens={{implode('-', $data['contatos'])}} data-subtext={{implode(',', $data['filhos'])}}>
                                            {{$data['nome']}}
                                        </option>
                                    @foreach($responsaveis as $responsavel)
                                        <option value={{$responsavel['uuid']}}  data-tokens={{implode('-', $responsavel['contatos'])}} data-subtext={{implode(',', $responsavel['filhos'])}}>
                                            {{$responsavel['nome']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="canalUuid">Como nos conheceu?</label>
                            <div class="row">
                                <a class="btn btn-outline-success mb-3 col-md-2"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#collapseCanais"
                                    aria-expanded="false"
                                    aria-controls="collapseCanais" >
                                    add
                                </a>
                                <select class="selectpicker show-tick col-md-8"
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
                        <div class="collapse multi-collapse" id="collapseResponsaveis">
                            <div class="card card-body">
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
                            </div>
                        </div>
                        </div>
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
                        <label for="nomeB">Nome completo do Baixinho</label>
                        <input type="text" name="nomeB" class="form-control" id="nomeB" placeholder="Nome">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nascimentoB">Data de Nascimento do baixinho</label>
                            <input type="date" name="nascimentoB" class="form-control" id="nascimentoB">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="primeiroCorteB">Data da primeira visita</label>
                            <input type="date" name="primeiroCorteB" value="{{date('Y-m-d')}}" class="form-control" id="primeiroCorteB">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="custom-control custom-radio">
                                <input type="radio" checked id="radioMenino" name="sexoB" value="menino" class="custom-control-input">
                                <label class="custom-control-label" for="radioMenino"><i class="icofont icofont-boy"></i> Menino</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radioMenina" name="sexoB" value="menina" class="custom-control-input">
                                <label class="custom-control-label" for="radioMenina"><i class="icofont icofont-kid"></i> Menina</label>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="fichaCadastro[]" class="custom-file-input" id="fichaCadastro">
                                    <label class="custom-file-label" for="fichaCadastro">Ficha de cadastro</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="imagensB[]" placeholder="teste" class="custom-file-input" id="imagensB" multiple>
                                    <label class="custom-file-label" for="imagensB">Fotos do baixinho</label>
                                </div>
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
