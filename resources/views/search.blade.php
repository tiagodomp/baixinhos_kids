@php 
    $baixinhosSearch    = session('baixinhosSearch');
    $responsaveisSearch = session('responsaveisSearch');
    $canaisSearch       = session('canaisSearch');
    $funcionariosSearch = session('funcionariosSearch');    
@endphp
@if(!empty($baixinhosSearch) || !empty($responsaveisSearch) || !empty($canaisSearch) || !empty($funcionariosSearch))
<div class="col-lg-12 mt-3">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @if(!empty($baixinhosSearch))
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-baixinhos-tab" data-toggle="pill" href="#pills-baixinhos" role="tab" aria-controls="pills-baixinhos" aria-selected="true">Baixinhos</a>
                    </li>
                @endif
                @if(!empty($responsaveisSearch))
                <li class="nav-item">
                    <a class="nav-link" id="pills-responsaveis-tab" data-toggle="pill" href="#pills-responsaveis" role="tab" aria-controls="pills-responsaveis" aria-selected="false">Responsaveis</a>
                </li>
                @endif
                @if(!empty($canaisSearch))
                <li class="nav-item">
                    <a class="nav-link" id="pills-canais-tab" data-toggle="pill" href="#pills-canais" role="tab" aria-controls="pills-canais" aria-selected="false">Canais</a>
                </li>
                @endif
                @if(!empty($funcionariosSearch))
                <li class="nav-item">
                    <a class="nav-link" id="pills-funcionarios-tab" data-toggle="pill" href="#pills-funcionarios" role="tab" aria-controls="pills-funcionarios" aria-selected="false">Funcionários</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @if(!empty($baixinhosSearch))
                <div class="tab-pane fade show active" id="pills-baixinhos" role="tabpanel" aria-labelledby="pills-baixinhos-tab">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Responsavel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($baixinhosSearch as $key => $baix)
                                                <tr>
                                                    <td><a href="{{route('baixinho.view', $baix['uuidB'])}}">{{$baix['nomeB']}}</a></td>
                                                    <td><a href="{{route('responsavel.view', $baix['uuidR'])}}">{{$baix['nomeR']}}</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(!empty($responsaveisSearch))
                <div class="tab-pane fade" id="pills-responsaveis" role="tabpanel" aria-labelledby="pills-responsaveis-tab">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Celular</th>
                                                <th scope="col">Telefone</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Filho(a)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($responsaveisSearch as $key => $resp)
                                                <tr>
                                                    <td><a href="{{route('responsavel.view', $resp['uuidR'])}}">{{$resp['nomeR']}}</a></td>
                                                    <td>{{$resp['contatosR']['cell']}}</td>
                                                    <td>{{$resp['contatosR']['tell']}}</td>
                                                    <td>{{$resp['contatosR']['email']}}</td>
                                                    <td><a href="{{route('baixinho.view', $resp['filhos']['uuidB'])}}">{{$resp['filhos']['nomeB']}}</a></td>
                                                </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(!empty($canaisSearch))
                <div class="tab-pane fade" id="pills-canais" role="tabpanel" aria-labelledby="pills-canais-tab">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th scope="col">Titulo</th>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Técnicas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($canaisSearch as $key => $can)
                                                <tr>
                                                    <td><a href="{{'canais.view', $can['uuidC']}}">{{$can['tituloC']}}</a></td>
                                                    <td>{{$can['descricaoC']}}</td>
                                                    <td>{{$can['tecnicasC']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(!empty($funcionariosSearch))
                <div class="tab-pane fade" id="pills-funcionarios" role="tabpanel" aria-labelledby="pills-funcionarios-tab">
                    <div class="card col-lg-12">
                        <div class="card-body">
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">E-mail</th>
                                                <th scope="col">Apelido</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($funcionariosSearch as $func)
                                            <tr>
                                                <td><a href="{{'canais.view', $func['uuidU']}}">{{$func['nomeU']}}</a></td>
                                                <td>{{$func['emailU']}}</td>
                                                <td>{{$func['apelidoU']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@php
session('baixinhosSearch', []);
session('responsaveisSearch', []);
session('canaisSearch', []);
session('funcionariosSearch', []);
@endphp