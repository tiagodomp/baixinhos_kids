@extends('layouts.pages')


@section('content')

<main class="main-content-inner">
        <div class="card mt-5 mb-5">
            <div class="card-body py-4 my-2">
                <div class="row">
                    <div class="col-md-4 pr-md-5">
                        @if(!empty($data['imagensB']))
                            <div id="FotosCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($data['imagensB'] as $key => $img)
                                        @if($key == 0)<div class="carousel-item active"> @else <div class="carousel-item"> @endif
                                                <img src="{{url('storage/'.$img['path'])}}"  alt="foto de {{$data['nomeB']}}">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>cortado por <a href="{{route('user.view', $img['criado_por'][1])}}">{{$img['criado_por'][0]}}</a> em {{date('d/m/Y \á\s H:i\h', strtotime($img['created_at']))}}</h5>
                                            </div>
                                        </div>
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
                                <div class="work-experience pt-2">
                                    <div class="work mb-4">
                                        @if($data['sexoB'] == 'Menina')
                                            <strong class="h5 d-block text-secondary font-weight-bold mb-1">Esta Baixinha</strong>
                                            <strong class="h6 d-block text-warning mb-1">
                                                @if($data['autorizacaoB'] == 1)
                                                    foi autorizada
                                                @else
                                                    NÃO foi autorizada
                                                @endif
                                            </strong>
                                        @else
                                            <strong class="h5 d-block text-secondary font-weight-bold mb-1">Este Baixinho</strong>
                                            <strong class="h6 d-block text-warning mb-1">
                                                @if($data['autorizacaoB'] == 1)
                                                    foi autorizado
                                                @else
                                                    NÃO foi autorizado
                                                @endif
                                            </strong>
                                        @endif
                                        <p class="text-secondary">a compartilhar publicamente suas fotos</p>
                                    </div>
                                    @if(!empty($data['fichaB']))
                                        <div class="work mb-4">
                                            <strong class="h5 d-block text-secondary font-weight-bold mb-1">Assinatura do Responsável</strong>
                                            <div class="tz-gallery">
                                                <div class="thumbnail">
                                                    <a class="lightbox" href="{{ url('storage/'.$data['fichaB'][0]['path']) }}">
                                                        <img class="w-100 rounded border" src="{{url('storage/'.$data['fichaB'][0]['path'])}}" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="according accordion-s3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <a class="btn btn-flat btn-outline-info mr-3 mb-3" data-toggle="collapse" href="#autorizacao">
                                                        Autorizar ou inserir ficha de cadastro
                                                    </a>
                                                </div>
                                                <div id="autorizacao" class="collapse show" data-parent="#autorizacao">
                                                    <div class="card-body">
                                                        <form action={{route('baixinho.ficha.add', $data['uuidB'])}} class="col-md-12" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-row col-md-12">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" name="autorizacaoAudiovisual" class="custom-control-input" id="permissao" @if($data['autorizacaoB'] == 1) checked @endif>
                                                                        <label class="custom-control-label" for="permissao">O responsável autorizou a publicação das imagens deste Baixinho ?</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row col-md-12">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="fichaCadastro[]" class="custom-file-input" id="fichaCadastro">
                                                                            <label class="custom-file-label" for="fichaCadastro">Ficha de cadastro</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-success align-center">Salvar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <h2 class="font-weight-bold m-0">
                                {{$data['nomeB']}}
                            </h2>
                            <address class="m-0 pt-2 pl-0 pl-md-4 font-weight-light text-secondary">
                                <i class="fa fa-map-marker"></i>
                                {{$data['tituloC']}}
                            </address>
                        </div>
                        <a href="{{route('responsavel.view', $data['uuidR'])}}">
                            <p class="h5 text-primary mt-2 d-block font-weight-light">
                                {{$data['nomeR']}}
                            </p>
                        </a>
                        @if(!empty($data['historicoB']))
                            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($data['historicoB'] as $key => $historico)
                                        @if(!empty($historico['obs']))
                                        <div class="carousel-item">
                                            <p class="lead mt-4">{{$historico['obs']}}</p>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <section class="mt-5">
                            <h3 class="h5 font-weight-light text-secondary text-uppercase">Pontuação de frequência</h3>
                            <div class="d-flex align-items-center">
                                <strong class="h1 font-weight-bold m-0 mr-3">{{round($data['ranking'], 2)}}</strong>
                                <div>
                                    <input data-filled="fa fa-2x fa-star mr-1 text-warning" data-empty="fa fa-2x fa-star-o mr-1 text-light" value="{{$data['ranking']}}" type="hidden" class="rating" data-readonly />
                                </div>
                            </div>
                        </section>
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
                                <button class="btn btn-flat btn-outline-success mb-3" data-toggle="modal" data-target="#historicoPerfilModal">
                                    <i class="fa fa-check"></i>
                                    Cortou hoje?
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
                                        Histórico
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                        Recent Projects
                                    </a>
                                </li> --}}
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
                                        <dt class="col-sm-3">Nascimento</dt>
                                        <dd class="col-sm-9">{{$data['nascimentoB']}}</dd>

                                        <dt class="col-sm-3">Sexo</dt>
                                        <dd class="col-sm-9">{{$data['sexoB']}}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
                                    <div class="data-tables datatable-primary">
                                        <table id="dataTable2" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>Cortou em</th>
                                                    <th>Cabeleireiro</th>
                                                    <th>Responsável</th>
                                                    <th>Tipo de Corte</th>
                                                    <th>ver</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($data['historicoB']))
                                                    @foreach($data['historicoB'] as $key => $hist)
                                                        <tr>
                                                            <td>
                                                                {{date('d/m/Y', strtotime($hist['created_at']))}}
                                                            </td>
                                                            <td>
                                                                <a href="{{route('user.view', $hist['cabeleireiro'][1])}}">{{$hist['cabeleireiro'][0]}}</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{route('responsavel.view', $hist['responsavel'][1])}}">{{$hist['responsavel'][0]}}</a>
                                                            </td>
                                                            <td>
                                                                {{$hist['tipo_corte']}}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary btn-xs mb-3" type="button">
                                                                    Histórico Completo
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">Nenhum histórico cadastrado</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
</main>

<div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Apagar </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Você realmente quer apagar do sistema todos os dados de {{$data['nomeB']}} ?</p>
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

<div class="modal fade bd-example-modal-lg" id="historicoPerfilModal" aria-labelledby="addHistoricoPerfilModal">
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
</div>

<div class="modal fade" id="apagarModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Apagar </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Você realmente quer apagar do sistema todos os dados de {{$data['nomeB']}} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('deletarBaixinho').submit();">Apagar</button>
                <form id="deletarBaixinho" action={{route('baixinho.del', $data['uuidB'])}} method="POST" style="display: none;">
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
                <form action={{route('baixinhos.addImg', $data['uuidB'])}} class="col-md-12" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="imagensB[]" placeholder="teste" class="custom-file-input" id="imagensB">
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
@endsection
