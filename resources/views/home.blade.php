@extends('layouts.app')

@section('content')
<div class="main-content-inner">
        <div class="row">
            <!-- seo fact area start -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="icofont icofont-baby"></i> Frequência</div>
                                    <h2>{{$data['totalBaixinhosFrequentes']}}</h2>
                                </div>
                                <canvas id="seolinechart1" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="icofont icofont-contact-add"></i> Fichas Faltando</div>
                                    <h2>{{$data['totalFichasFaltando']}}</h2>
                                </div>
                                <canvas id="seolinechart2" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ficha Cadastro area start -->
                <div class="row">
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
                <!-- Ficha Cadastro area end -->
            </div>
            <!-- seo fact area end -->
            <!-- Social Campain area start -->
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-md-12 mt-5 mb-3">
                        <div class="card">
                            <div class="card-body pb-0">
                                <h4 class="header-title">Ranking dos melhores canais</h4>
                                <div class="timeline-area">
                                    @foreach ( $data['rankingCanais'] as $top => $canal)
                                        <div class="timeline-task">
                                            @if($top == 0 || $top == 1 || $top == 2)
                                                <div class="icon bg3">
                                                    <i class="icofont icofont-star"></i>
                                                </div>
                                            @else
                                                <div class="icon bg1">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                            @endif

                                            <div class="tm-title">
                                                Canal: <a href="{{route('canais.view', $canal['uuid'])}}"<h4  class="header-title">{{$canal['titulo']}}</h4></a><br />
                                                Total de membros: <span>{{$canal['totalMembros']}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Social Campain area end -->
        </div>
    </div>
@endsection
