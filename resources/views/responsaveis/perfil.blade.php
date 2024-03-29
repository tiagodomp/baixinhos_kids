@extends('layouts.pages')

@section('content')
<main class="main-content-inner">
    <div class="card mt-5 mb-5">
        <div class="card-body py-4 my-2">
            <div class="row">
                <div class="col-md-4 pr-md-5">
                    @if(!empty($data['filhos'][0]['imagensB']))
                        <div id="FotosCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($data['filhos'] as $keyD => $filho)
                                    @foreach($filho['imagensB'] as $keyF => $img)
                                        @if($keyD == 0 && $keyF == 0)<div class="carousel-item active"> @else <div class="carousel-item"> @endif
                                                <img src="{{url('storage/'.$img['path'])}}"  alt="foto de {{$filho['nomeB']}}">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>O cabelo de <a href="{{route('baixinho.view', $filho['uuidB'])}}">{{explode(" ", $filho['nomeB'])[0]}}</a> foi cortado em {{date('d/m/Y \á\s H:i\h', strtotime($img['created_at']))}}</h5>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#FotosCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#FotosCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </div>
                    @else
                        <img class="w-100 rounded border" src="{{url('img/avatar/user2.png')}}" />
                    @endif
                    <button type="button" data-toggle="modal" data-target="#addImgModal" class="btn btn-flat btn-outline-secondary btn-lg btn-block"> <i class="ti-image"></i> Adicionar imagem</button>
                    <div class="pt-4 mt-2">
                        <section class="mb-4 pb-1">
                            <h3 class="h6 font-weight-light text-secondary text-uppercase">Permissões</h3>
                            @if(!empty($data['filhos']))
                                @foreach($data['filhos'] as $filho)
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover progress-table text-center">
                                                <tr>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col"><a href="{{route('baixinho.view', $filho['uuidB'])}}" class="text-dark">{{$filho['nomeB']}}</a></th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Idade</th>
                                                    <td>{{now()->diffInYears($filho['nascimentoB'])}} aninhos</td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Autorização</th>
                                                    <td>
                                                        @if($filho['autorizacao_audiovisualB'] == 1 && !empty($filho['ficha_cadastroB']))
                                                        <span class="status-p bg-success" data-toggle="tooltip" data-placement="right" title="Autorização confirmada e ficha de cadastro preenchida">Ok</span>
                                                        @elseif($filho['autorizacao_audiovisualB'] == 1 || !empty($filho['ficha_cadastroB']))
                                                        <span class="status-p bg-warning" data-toggle="tooltip" data-placement="right" title="Autorização ou a ficha de cadastro estão faltando">Pendente</span>
                                                        @else
                                                        <span class="status-p bg-danger" data-toggle="tooltip" data-placement="right" title="Autorização negada e ficha de cadastro em branco">Negada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                @endforeach
                            @else
                                Este responsável não esta associado a nenhum filho
                            @endif
                        </section>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <h2 class="font-weight-bold m-0">
                            {{$data['nomeR']}}
                        </h2>
                        <address class="m-0 pt-2 pl-0 pl-md-4 font-weight-light text-secondary">
                            <i class="fa fa-map-marker"></i>
                            {{$data['tituloC']}}
                        </address>
                    </div>
                    @if(!empty($data['filhos']))
                    <p class="h5 text-primary mt-2 d-block font-weight-light">
                        <dl class="row mt-4 mb-4 pb-3">
                            <dt>Filhos:
                                <dd>
                                    @foreach ($data['filhos'] as $count => $filho)
                                        @if($count > 0) , @endif
                                        <a href="{{route('baixinho.view', $filho['uuidB'])}}" class="ml-1 mr-0">{{$filho['nomeB']}}</a>
                                    @endforeach
                                </dd>
                            </dt>
                        </dl>
                    </p>
                    @endif
                    <section class="d-flex mt-5 row">
                        <div class="col-md-2">
                            <button class="btn btn-flat btn-outline-info mr-3 mb-3"  data-toggle="modal" data-target="#editarModal">
                                <i class="fa fa-pencil"></i>
                                Editar
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-flat btn-outline-danger mr-3 mb-3" data-toggle="modal" data-target="#apagarModal">
                                <i class="fa fa-trash"></i>
                                Apagar
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-flat btn-outline-success mb-3" data-toggle="modal" data-target="#permissoesPerfilModal">
                                <i class="fa fa-check"></i>
                                Alterar permissões
                            </button>
                        </div>
                    </section>
                    <section class="mt-4">
                        <ul class="nav nav-tabs" id="tabPerfil" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="sobre-tab" data-toggle="tab" href="#sobre" role="tab" aria-controls="sobre" aria-selected="true">
                                    Sobre
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false">
                                    filhos
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-4" id="tabPerfilContent">
                            <div class="tab-pane py-3 fade show active" id="sobre" role="tabpanel" aria-labelledby="sobre-tab">
                                <h6 class="text-uppercase font-weight-light text-secondary">
                                    Informações de Contato
                                </h6>
                                @php
                                    $cell = []; $tell = []; $email = [];
                                    foreach($data['contatosR'] as $contato){
                                        if(!empty($contato['cell']) && count($cell) <= 2)
                                            $cell[] = $contato['cell'];

                                        if(!empty($contato['tell']) && count($tell) <= 2)
                                            $tell[] = $contato['tell'];

                                        if(!empty($contato['email']) && count($email) <= 2)
                                            $email[] = $contato['email'];
                                    }

                                    $cell = implode(',', $cell);
                                    $tell = implode(',', $tell);
                                @endphp
                                <dl class="row mt-4 mb-4 pb-3">
                                    <dt class="col-sm-3">Celular</dt>
                                    <dd class="col-sm-9">{{$cell}}</dd>
                                    <dt class="col-sm-3">Telefone</dt>
                                    <dd class="col-sm-9">{{$tell}}</dd>
                                    <dt class="col-sm-3">Email</dt>
                                    <dd class="col-sm-9">
                                        <a href="mailto:{{$email[0]}}">{{$email[0]}}</a>
                                        @if(!empty($email[1]))
                                            , <a href="mailto:{{$email[1]}}">{{$email[1]}}</a>
                                        @endif
                                    </dd>
                                </dl>
                                <h6 class="text-uppercase font-weight-light text-secondary">
                                    Informações Básicas
                                </h6>
                                <dl class="row mt-4 mb-4 pb-3">
                                    <dt class="col-sm-3">Primeira visita</dt>
                                    <dd class="col-sm-9">{{date('d/m/Y', strtotime($data['created_atR']))}}</dd>

                                    <dt class="col-sm-3">Ultima Atualização</dt>
                                    <dd class="col-sm-9">{{date('d/m/Y', strtotime($data['updated_atR']))}}</dd>
                                </dl>
                            </div>
                            <div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
                                @if(!empty($data['filhos']))
                                    <div class="data-tables datatable-primary">
                                        <table id="dataTable2" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Nascimento</th>
                                                    <th>Autorizado</th>
                                                    <th>Total de imagens</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['filhos'] as $key => $filho)
                                                    <tr>
                                                        <td>
                                                            <a href="{{route('baixinho.view', $filho['uuidB'])}}">{{$filho['nomeB']}}</a>
                                                        </td>
                                                        <td>
                                                            {{date('d/m/Y', strtotime($filho['nascimentoB']))}}
                                                        </td>
                                                        <td>
                                                            @if($filho['autorizacao_audiovisualB'] == 1)
                                                                <i class="text-success fa fa-check"></i>
                                                            @else
                                                                <i class="text-danger fa fa-times"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{count($filho['imagensB'])}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <a class="btn btn-outline-info" href="{{route('baixinhos.add')}}"> Criar um baixinho </a>
                                @endif
                            </div>
                            {{-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>

{{--  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Apagar </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Você realmente quer apagar do sistema todos os dados de {{$data['nomeR']}} ?</p>
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
</div>  --}}

{{--  <div class="modal fade bd-example-modal-lg" id="historicoPerfilModal" aria-labelledby="addHistoricoPerfilModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar histórico</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="needs-validation" id="formHistoricoModal" action={{route('baixinho.historico.add', $data['uuidB'])}} method="POST" novalidate="">
                @csrf
                <input type="hidden" id="uuidBHistorico" value="{{$data['uuidB']}}" name="uuidBHistorico">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="cabeleireiroHistoricoModal">Quem foi o cabeleireiro</label>
                            <input type="text" class="form-control" id="cabeleireiroHistoricoModal" name="cabeleireiroHistorico" placeholder="Nome completo do cabeleireiro" value="{{auth()->user()->nome}}" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="responsavelHistoricoModal">Quem veio como responsável</label>
                            <input type="text" class="form-control" id="responsavelHistoricoModal" name="responsavelHistorico" placeholder="Nome completo do responsável" value="{{$data['nomeR']}}" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <p>Como será pago ? </p>
                            <div class="custom-control custom-radio">
                                <input type="radio" checked id="dinheiroRadio" value="dinheiro" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="dinheiroRadio">Dinheiro</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="debitoRadio" value="débito" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="debitoRadio">Débito</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="creditoRadio" value="crédito" name="tipoPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="creditoRadio">Crédito</label>
                            </div>
                            <p>Em quantas vezes será pago ? </p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" checked id="vistaRadio" value="a vista" name="modeloPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="vistaRadio">A vista</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="parceladoRadio" value="parcelado" name="modeloPagamentoHistorico" class="custom-control-input">
                                <label class="custom-control-label" for="parceladoRadio">Parcelado</label>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="col-lg-12 mb-3">
                                <label for="corteCabeloHistoricoModal">Corte de cabelo</label>
                                <input type="text" class="form-control" id="corteCabeloHistoricoModal" name="corteCabeloHistorico" placeholder="Qual foi o corte de cabelo" required>

                                <label for="validationCustom03">Próximo corte</label>
                                <input class="form-control" type="date" value="{{date('Y-m-d', strtotime('+1 months'))}}" name="agendadoParaHistorico" id="agendadoParaHistorico">
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
</div>  --}}

<div class="modal fade" id="apagarModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Apagar </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Você realmente quer apagar do sistema todos os dados de {{$data['nomeR']}} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('deletarResponsavel').submit();">Apagar</button>
                <form id="deletarResponsavel" action={{route('responsavel.del', $data['uuidR'])}} method="POST" style="display: none;">
                    @csrf
                </form>
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addImgModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Inserir imagens</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action={{route('responsavel.addImg', $data['uuidR'])}} class="col-md-12" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="uuidB">Relacionar a qual filho(a)</label>
                            <div class="row">
                                <select class="selectpicker show-tick"
                                        name="uuidB"
                                        title="Escolha um Filho..."
                                        id="uuidB"
                                        data-live-search="true"
                                        data-size="3"
                                        data-width="auto">
                                    @foreach($data['filhos'] as $filho)
                                        <option value={{$filho['uuidB']}}>{{$filho['nomeB']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="imagensB[]" placeholder="insira imagens relacionadas com este responsavel" class="custom-file-input" id="imagensB">
                                <label class="custom-file-label" for="imagensB">Fotos do baixinho</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="permissoesPerfilModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Inserir Ficha de cadastro</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action={{route('baixinho.permissao.edit')}} class="col-md-12" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="uuidB">Relacionar a qual filho(a)</label>
                            <div class="row">
                                <select class="selectpicker show-tick col-md-12"
                                        name="uuidB"
                                        title="Escolha um Filho..."
                                        id="uuidBSelectAjax"
                                        data-live-search="true"
                                        data-url={{route('base')}}
                                        data-size="3"
                                        data-width="auto">
                                    @foreach($data['filhos'] as $filho)
                                        <option value={{$filho['uuidB']}} data-url={{route('baixinhos.get.permissoes.ajax', $filho['uuidB'])}}>{{$filho['nomeB']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="camposInput">
                        <div class="form-group col-md-12 d-none" id="autorizacaoAudiovisualDiv">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="autorizacaoAudiovisual" name="autorizacaoAudiovisual" class="custom-control-input">
                                <label class="custom-control-label" for="autorizacaoAudiovisual">O responsável autoriza a divulgação e publicação das fotos desta criança nos canais da BaixinhosKids?</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 d-none" id="fichaCadastroImg">
                            <div class="tz-gallery">
                                <div class="thumbnail">
                                    <a class="lightbox" id="fichaCadastroUrl" href="#">
                                        <img class="rounded border" id="fichaCadastroUrl" src="#"/>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" id="delFichaCadastro">Deletar ficha de cadastro</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 d-none" id="fichaCadastroInput">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="fichaCadastro[]" placeholder="insira uma foto da ficha de cadastro" class="custom-file-input" id="fichaCadastro">
                                    <label class="custom-file-label" for="fichaCadastro">Ficha de cadastro</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-info d-none" id="restFichaCadastro">Restaurar ficha de cadastro</button>
                        <input type="hidden" id="delFichaCadastroInput" name="delFichaCadastroInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
