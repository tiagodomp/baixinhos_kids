@extends('layouts.pages')

@section('content')
<div class="row">
    <!-- sales area start -->
    <div class="col-xl-12 col-ml-9 col-lg-9 mt-5 mb-5">
        <!-- Primary table start -->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Todos os Canais</h4>
                <div class="data-tables datatable-dark">
                    <table id="dataTable" class="text-center">
                        <thead class="text-capitalize">
                            <tr>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>Técnicas</th>
                                <th>Registrado Por</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                            @foreach($data as $canal)
                                <tr>
                                    <td>{{$canal['tituloC']}}</td>
                                    <td>{{$canal['descricaoC']}}</td>
                                    <td>{{$canal['tecnicasC']}}</td>
                                    <td><a href="{{route('user.view', $canal['uuidU'])}}">{{$canal['nomeU']}}</a></td>
                                    <td class="row">
                                        <div class="dropdown col-lg-6 col-md-4 col-sm-6">
                                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                Mais opções
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item btn" href="{{route('canal.edit', $canal['uuidC'])}}">Editar</a>
                                                <a class="dropdown-item btn" data-toggle="modal" data-url="{{route('canal.del', $canal['uuidC'])}}" data-nomeB="{{$canal['tituloC']}}" data-target="#apagarModalCenter">Apagar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Nenhum canal cadastrado</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
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
                <p>Você realmente quer apagar do sistema todos os dados deste canal ?</p>
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
