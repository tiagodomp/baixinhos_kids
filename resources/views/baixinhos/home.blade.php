@extends('layouts.pages')

@section('content')
<div class="row">
    <!-- sales area start -->
    <div class="col-xl-12 col-ml-9 col-lg-9 mt-5 mb-5">
        <!-- Primary table start -->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Todos os baixinhos</h4>
                <div class="data-tables datatable-primary">
                    <table id="dataTable" class="text-center">
                        <thead class="text-capitalize">
                            <tr>
                                <th>Nome</th>
                                <th>Responsável</th>
                                <th>Primeiro Corte</th>
                                <th>Último Corte</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data['listBaixinhos']))
                                @foreach($data['listBaixinhos'] as $key => $list)
                                    <tr>
                                        <td><a href="{{route('baixinho.view', $list['uuidB'])}}">{{$list['nomeB']}}</a></td>
                                        <td><a href="{{route('responsavel.view', $list['uuidR'])}}">{{$list['nomeR']}}</a></td>
                                        <td>{{$list['primeiro_corte']}}</td>
                                        <td>{{$list['ultimo_corte']}}</td>
                                        <td class="row">
                                            <div class="dropdown col-lg-6 col-md-4 col-sm-6">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                    Mais opções
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item btn" data-toggle="modal" data-url="{{route('baixinho.historico.add', $list['uuidB'])}}" data-target="#historicoModal">Cortou hoje?</a>
                                                    <a class="dropdown-item btn" href="{{route('baixinho.view', $list['uuidB'])}}">Visualizar</a>
                                                    <a class="dropdown-item btn" href="{{route('baixinho.edit', $list['uuidB'])}}">Editar</a>
                                                    <a class="dropdown-item btn" data-toggle="modal" data-url="{{route('baixinho.del', $list['uuidB'])}}" data-nomeB="{{$list['nomeB']}}" data-target="#apagarModalCenter">Apagar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Nenhum Baixinho cadastrado</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Primary table end -->
    </div>
    {{--  <!-- sales area end --> --}}
</div>

<div class="modal fade bd-example-modal-lg" id="historicoModal" aria-labelledby="addHistoricoModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar histórico</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="needs-validation" id="formHistoricoModal" method="POST" novalidate="">
                @csrf
                <input type="hidden" id="uuidBHistorico" value="" name="uuidBHistorico">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="cabeleireiroHistoricoModal">Quem Cortou</label>
                            <input type="text" class="form-control" id="cabeleireiroHistoricoModal" name="cabeleireiroHistorico" placeholder="Nome completo do cabeleireiro" value="{{auth()->user()->nome}}" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="responsavelHistoricoModal">Quem veio como responsável</label>
                            <input type="text" class="form-control" id="responsavelHistoricoModal" name="responsavelHistorico" placeholder="Nome completo do responsável" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <p>Como será pago ? </p>
                            <div class="custom-control custom-radio">
                                <input type="radio" checked id="customRadio1" value="dinheiro" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3">Dinheiro</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" value="débito" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio1">Débito</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" value="crédito" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">Crédito</label>
                            </div>
                            <p>Em quantas vezes será pago ? </p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" checked id="customRadio4" value="a vista" name="modeloPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio4">A vista</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio5" value="parcelado" name="modeloPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio5">Parcelado</label>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="col-lg-12 mb-3">
                                <label for="corteCabeloHistoricoModal">Corte de cabelo</label>
                                <input type="text" class="form-control" id="corteCabeloHistoricoModal" name="corteCabeloHistorico" placeholder="Qual foi o corte de cabelo" required>

                                <label for="validationCustom03">Próximo corte</label>
                                <input class="form-control" type="date" value="{{date('Y-m-d')}}" name="agendadoParaHistorico" id="agendadoParaHistorico">
                            </div>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-12 mb-3">
                            <label for="corteCabeloHistoricoModal">Observações</label>
                            <textarea class="form-control" name="obsHistorico" aria-label="Observacoes"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="apagarModalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Apagar </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Você realmente quer apagar do sistema todos os dados desta criança ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('deletarBaixinho').submit();">Apagar</button>
                <form id="deletarBaixinho" method="POST" style="display: none;">
                    @csrf
                </form>
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
