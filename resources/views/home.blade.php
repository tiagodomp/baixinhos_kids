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
                                <p class="text-muted f-18 m-0">
                                    @if($data['totalBaixinhosFrequentes'] == 1)
                                        Baixinho frequente
                                    @else
                                        Baixinhos frequentes
                                    @endif
                                </p>
                            </div>
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
                                <p class="text-muted f-18 m-12">
                                        @if($data['totalFichasFaltando'] == 1)
                                            Ficha faltando
                                        @else
                                            Fichas faltando
                                        @endif
                                </p>
                            </div>
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
                            <button class="btn btn-info btn-icon"><i class="icofont icofont-map-pins"></i></button>
                            <div class="card-contain">
                                <h6>{{$data['rankingCanais'][0]['totalMembros']}}</h6>
                                <p class="text-muted f-18 m-12">Advindo do canal: {{$data['rankingCanais'][0]['titulo']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Busca de Baixinhos</h4>
                        <div class="data-tables datatable-dark">
                            <table id="dataTable3" class="text-center">
                                <thead class="text-capitalize">
                                    <tr class="text-uppercase">
                                        <th>Baixinho</th>
                                        <th>Responsável</th>
                                        <th>Último Corte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    	<tr>
                                            <td>Teste</td>
                                            <td>pai</td>
                                            <td>18/09/2019</td>
                                    	</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-block">
                        <h5>Busca de baixinhos</h5>
                    </div>
                    <div class="card-block reset-table p-t-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Baixinho</th>
                                        <th>Responsável</th>
                                        <th>Último Corte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
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
                                                <option value={{$responsavel['uuid']}}  data-tokens={{implode('-', $responsavel['contatos'])}} data-subtext={{implode(',', $responsavel['filhos'])}}>
                                                    {{$responsavel['nome']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a class="btn btn-success"
                                        data-toggle="collapse"
                                        href="#collapseResponsaveis"
                                        role="button"
                                        aria-expanded="false"
                                        aria-controls="collapseResponsaveis">
                                        add
                                    </a>
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
                                            <option value="">Escolha um Canal...</option>
                                            @foreach($canais as $canal)
                                                <option value={{$canal['uuid']}}>{{$canal['titulo']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a  class="btn btn-success"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#collapseCanais"
                                        aria-expanded="false"
                                        aria-controls="collapseCanais" >
                                        add
                                    </a>
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
                                            <input type="email" name="contatosR[0][email]" class="form-control" id="contatosR[0][email]" placeholder="E-mail principal do Responsável">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="contatosR[0][tell]">Telefone</label>
                                                <input type="text" name="contatosR[0][tell]" class="form-control" id="contatosR[0][tell]" placeholder="Telefone principal do Responsável">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contatosR[0][cell]">Celular</label>
                                                <input type="text" name="contatosR[0][cell]" class="form-control" id="contatosR[0][cell]" placeholder="Celular principal do Responsável">
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
                                    <input type="date" name="primeiroCorteB" class="form-control" id="primeiroCorteB">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary col-md-12">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Launch demo modal
              </button>
              <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){
        e.preventDefault();

        var name = $("input[name=name]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();

        $.ajax({
            type:'POST',
            url:'/ajaxRequest',
            data:{name:name, password:password, email:email},
            success:function(data){
                alert(data.success);
            }
        });
    });
</script>
@endsection
