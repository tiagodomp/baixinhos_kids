@extends('layouts.app')

@section('content')
<div style="margin-top: 4.4rem">

    <div class="row px-5 my-2">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-block-big card-visitor-block">
                    <div class="row">
                        <div class="col-sm-8  card-visitor-button">
                            <button class="btn btn-primary btn-icon"><i class="icofont icofont-baby"></i></button>
                            <div class="card-contain">
                                <h6>{{$data['totalBaixinhosFrequentes']}}</h6>
                                <p class="text-muted f-18 m-0">Baixinhos frequentes</p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <span class="visitor-chart"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-block-big card-visitor-block">
                    <div class="row">
                        <div class="col-sm-8 card-visitor-button">
                            <button class="btn btn-warning btn-icon"><i class="icofont icofont-contact-add"></i></button>
                            <div class="card-contain">
                                <h6>{{$data['totalFichasFaltando']}}</h6>
                                <p class="text-muted f-18 m-12">Fichas faltando</p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <span class="sale-chart"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-block-big card-visitor-block">
                    <div class="row">
                        <div class="col-sm-8  card-visitor-button">
                            <button class="btn btn-info btn-icon"><i class="icofont icofont-ticket"></i></button>
                            <div class="card-contain">
                                {{--  @foreach($pendente as $pd)
                                    <h6>R$ {{number_format($pd->total,2,'.','.') }}</h6>
                                    <p class="text-muted f-18 m-0"> {{ $pd->quantidade}}   Pendentes</p>
                                @endforeach  --}}
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <span class="visitor-chart"><canvas width="100" height="65" style="display: inline-block; width: 100px; height: 65px; vertical-align: top; margin-bottom: -2px; margin-left: -2px;"></canvas></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h5>Status dos Pedidos</h5>
                    </div>
                    <div class="card-block reset-table p-t-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Quantidade</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--foreach($status as $stts)
                                            <tr>
                                            <td>  $stts->quantidade   </td>
                                                <td>  $stts->total  </td>
                                                if ($stts->nome == "Cancelado")
                                                <td><button type="button" class="btn btn-danger btn-round">  $stts->nome </button></td>
                                                else
                                                <td><button type="button" class="btn btn-primary btn-round">  $stts->nome </button></td>
                                                endif
                                            </tr>
                                    endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <span>Inserir nova</span>
                        <h5>Ficha de cadastro</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <form action={{route('ficha.cadastro')}} class="col-md-12" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="responsavelUuid">Quem é o Responsável?</label>
                                    <div class="row-fluid">
                                        <select class="selectpicker show-tick"
                                                name="responsavelUuid"
                                                title="Selecione o Responsável..."
                                                id="responsavelUuid"
                                                data-show-subtext="true"
                                                data-live-search="true"
                                                data-size="5"
                                                data-width="auto">
                                            <option value="" >Selecione o Responsável...</option>
                                            @foreach($responsaveis as $responsavel)
                                                <option value={{$responsavel['uuid']}}  data-tokens={{implode('-', $responsavel['data'])}} data-subtext={{implode(',', $responsavel['filhos'])}}>
                                                    {{$responsavel['nome']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-success"> add </button>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="canalUuid">Como nos conheceu?</label>
                                    <div class="row-fluid">
                                        <select class="selectpicker show-tick"
                                                name="canalUuid"
                                                title="Escolha um Canal..."
                                                id="canalUuid"
                                                data-live-search="true"
                                                data-size="5"
                                                data-width="auto">
                                                {{--  <option value="" >Escolha um Canal...</option>  --}}
                                            @foreach($canais as $canal)
                                                <option value={{$canal['uuid']}}>{{$canal['titulo']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button"
                                            class="btn btn-success"
                                            data-toggle="modal"
                                            data-target="#canalModal">
                                            add
                                    </button>
                                </div>
                            </div>
                              <div class="form-group">
                                <label for="nomeB">Nome completo do Baixinho</label>
                                <input type="password" class="form-control" id="nomeB" placeholder="Senha">
                              </div>
                            <div class="form-row"
                                <div class="form-group">
                                    <label for="inputAddress">Data de Nascimento</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Data da primeira visita</label>
                                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartamento, hotel, casa, etc.">
                                </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group">
                                <label for="inputCity">Autorizaçao audio-visual</label>
                                <input type="text" class="form-control" id="inputCity">
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>
    </div>

</div>
<!-- aqui comeca o template -->
<script>
    var menuSelecao = document.getElementById('contas');
      menuSelecao.onchange= function() {
      var urlSelecionada = menuSelecao.options[menuSelecao.selectedIndex].value;
      self.location = urlSelecionada;
    }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
@endsection
