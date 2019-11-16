@extends('layouts.pages')

@section('content')
{{--  Ficha Cadastro area start  --}}

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Editar Baixinho</h4>
                <form action={{route('baixinho.edit', $data['uuidB'])}} class="col-md-12" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="responsavelUuid">Responsável</label>
                            <div class="row">
                                <div class="card card-body">
                                    <div class="form-group">
                                        <label for="nomeR">Nome</label>
                                        <input type="text" name="nomeR" class="form-control" value="{{$data['nomeR']}}" id="nomeR" placeholder="Nome completo do responsável" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="contatosR[0][email]">E-mail</label>
                                        <input type="email" name="contatosR[0][email]" class="form-control" value="{{$data['contatosR'][0]['email']}}" id="email" placeholder="E-mail principal do Responsável" readonly>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="contatosR[0][tell]">Telefone</label>
                                            <input type="text" name="contatosR[0][tell]" class="form-control" value="{{$data['contatosR'][0]['tell']}}" id="tell" placeholder="Telefone principal do Responsável" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="contatosR[0][cell]">Celular</label>
                                            <input type="text" name="contatosR[0][cell]" class="form-control" value="{{$data['contatosR'][0]['cell']}}" id="cell" placeholder="Celular principal do Responsável" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col align-self-start">
                                            <a class="btn btn-outline-info col-12" href="{{route('responsavel.edit', $data['uuidR'])}}">Editar</a>
                                        </div>
                                        <div class="form-group col align-self-end">
                                            <a class="btn btn-outline-warning col-12"
                                                role="button"
                                                data-toggle="collapse"
                                                data-target="#collapseResponsaveis"
                                                aria-expanded="false"
                                                aria-controls="collapseResponsaveis">
                                                Alterar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="canalUuid">Canal de acesso</label>
                            <div class="row">
                                <div class="card card-body">
                                    <div class="form-group">
                                        <label for="tituloCanal">Titulo</label>
                                        <input type="text" name="tituloCanal" value="{{$data['tituloC']}}" class="form-control" id="tituloCanal" placeholder="Titulo do Canal" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="descricaoCanal">Descrição</label>
                                        <input type="textarea" name="descricaoCanal" value="{{$data['descricaoC']}}" class="form-control" id="descricaoCanal" placeholder="Breve descrição..." readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tecnicasCanal">Regras</label>
                                        <input type="textarea" name="tecnicasCanal" value="{{$data['tecnicasC']}}" class="form-control" id="tecnicasCanal" placeholder="Regras para lidar com os membros deste canal..." readonly>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col align-self-start">
                                            <a class="btn btn-outline-info col-12" href="{{route('canal.edit', $data['uuidR'])}}">Editar</a>
                                        </div>
                                        <div class="form-group col align-self-end">
                                            <a class="btn btn-outline-warning col-12"
                                                role="button"
                                                data-toggle="collapse"
                                                data-target="#collapseCanais"
                                                aria-expanded="false"
                                                aria-controls="collapseCanais" >
                                                Alterar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="collapse multi-collapse justify-content-center mb-4" id="collapseResponsaveis">
                                <select class="selectpicker show-tick col-12"
                                        name="responsavelUuid"
                                        title="Selecione outro Responsável..."
                                        id="responsavelUuid"
                                        data-show-subtext="true"
                                        data-live-search="true"
                                        data-size="5"
                                        data-width="auto">
                                    @foreach($responsaveis as $responsavel)
                                        <option value={{$responsavel['uuid']}} @if(!empty($data['uuidR']) && $data['uuidR'] == $responsavel['uuid']) selected @endif data-tokens={{implode('-', $responsavel['contatos'])}} data-subtext={{implode(',', $responsavel['filhos'])}}>
                                            {{$responsavel['nome']}}
                                        </option>
                                    @endforeach
                                </select>
                                <hr />
                            </div>
                        </div>
                        <div class="col">
                            <div class="collapse multi-collapse justify-content-center mb-4" id="collapseCanais">
                                <select class="selectpicker show-tick col-12"
                                        name="canalUuid"
                                        title="Escolha outro canal"
                                        id="canalUuid"
                                        data-live-search="true"
                                        data-size="5"
                                        data-width="auto">
                                    @foreach($canais as $canal)
                                        <option value={{$canal['uuid']}} @if(!empty($data['uuidC']) && $data['uuidC'] == $canal['uuid']) selected @endif >{{$canal['titulo']}}</option>
                                    @endforeach
                                </select>
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nomeB">Nome completo do Baixinho</label>
                        <input type="text" name="nomeB" value="{{$data['nomeB']}}" class="form-control" id="nomeB" placeholder="Nome">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nascimentoB">Data de Nascimento do baixinho</label>
                            <input type="date" name="nascimentoB" value="{{$data['nascimentoB']}}" class="form-control" id="nascimentoB">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="primeiroCorteB">Data da primeira visita</label>
                            <input type="date" name="primeiroCorteB" value="{{$data['createdB']}}" class="form-control" id="primeiroCorteB">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="custom-control custom-radio">
                                <input type="radio" @if($data['sexoB'] == 1) checked @endif id="radioMenino" name="sexoB" value="menino" class="custom-control-input">
                                <label class="custom-control-label" for="radioMenino"><i class="icofont icofont-boy"></i> Menino</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radioMenina" @if($data['sexoB'] == 0) checked @endif name="sexoB" value="menina" class="custom-control-input">
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
                    <div class="form-row">
                        @if(!empty($data['imagensB']))
                            <div class="tz-gallery">
                                <div class="row mt-2 mb-2">
                                    @foreach($data['imagensB'] as $key => $img)
                                        <div class="col-sm-6 col-md-4 ">
                                            <div class="thumbnail">
                                                <a class="lightbox" href="{{ url('storage/'.$img['path']) }}">
                                                    <img src="{{url('storage/'.$img['path'])}}" style="height: 300px" alt="foto de {{$data['nomeB']}}">
                                                </a>
                                                <div class="caption">
                                                    <h3><a class="header-title" href="{{route('baixinho.view', $data['uuidB'])}}"> {{$data['nomeB']}}</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger mb-3">Apagar <span class="badge badge-light">9</span>
                                <span class="sr-only">você realmente quer apagar todas essas imagens ?</span>
                            </button>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{--  Ficha Cadastro area end  --}}
@endsection()
