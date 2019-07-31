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
                                <!--foreach($pendente as $pd)
                                <h6>R$ number_format($pd->total,2,'.','.')   </h6>
                            <p class="text-muted f-18 m-0">  $pd->quantidade   Pendentes</p>
                                endforeach -->
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
                                    <!--foreach($status as $stts)
                                            <tr>
                                            <td>  $stts->quantidade   </td>
                                                <td>  $stts->total  </td>
                                                if ($stts->nome == "Cancelado")
                                                <td><button type="button" class="btn btn-danger btn-round">  $stts->nome </button></td>
                                                else
                                                <td><button type="button" class="btn btn-primary btn-round">  $stts->nome </button></td>
                                                endif
                                            </tr>
                                    endforeach-->
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
                                <label for="responsavelUuid">Responsável</label>
                                <input type="text" id="responsavelUuid" placeholder="Nome do Responsável">
                                <div class="row-fluid">
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="true">
                                          <option data-subtext="Rep California">Tom Foolery</option>
                                          <option data-subtext="Sen California">Bill Gordon</option>
                                          <option data-subtext="Sen Massacusetts">Elizabeth Warren</option>
                                          <option data-subtext="Rep Alabama">Mario Flores</option>
                                          <option data-subtext="Rep Alaska">Don Young</option>
                                          <option data-subtext="Rep California" disabled="disabled">Marvin Martinez</option>
                                        </select>
                                        <span class="help-inline">With <code>data-show-subtext="true" data-live-search="true"</code>. Try searching for california</span>
                                      </div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputPassword4">Senha</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Senha">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="inputAddress">Endereço</label>
                              <input type="text" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0">
                            </div>
                            <div class="form-group">
                              <label for="inputAddress2">Endereço 2</label>
                              <input type="text" class="form-control" id="inputAddress2" placeholder="Apartamento, hotel, casa, etc.">
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputCity">Cidade</label>
                                <input type="text" class="form-control" id="inputCity">
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputEstado">Estado</label>
                                <select id="inputEstado" class="form-control">
                                  <option selected>Escolher...</option>
                                  <option>...</option>
                                </select>
                              </div>
                              <div class="form-group col-md-2">
                                <label for="inputCEP">CEP</label>
                                <input type="text" class="form-control" id="inputCEP">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                  Clique em mim
                                </label>
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
@endsection
