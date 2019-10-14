@extends('layouts.pages')

@section('content')
<div class="row">
    <!-- sales area start -->
    <div class="col-xl-12 col-ml-9 col-lg-9 mt-5 mb-5">
        <!-- Primary table start -->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Todos os Responsáveis</h4>
                <div class="data-tables datatable-dark">
                    <table id="dataTable" class="text-center">
                        <thead class="text-capitalize">
                            <tr>
                                <th>Nome</th>
                                <th>Primeira Visita</th>
                                <th>Veio através</th>
                                <th>Atendido Por</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach($data as $responsavel)
                                    <tr>
                                        <td><a href="{{route('responsavel.view', $responsavel['uuidR'])}}">{{$responsavel['nomeR']}}</a></td>
                                        <td>{{date('d/m/Y', strtotime($responsavel['created_at']))}}</td>
                                        <td><a href="{{route('canais.view', $responsavel['uuidC'])}}">{{$responsavel['tituloC']}}</a></td>
                                        <td><a href="{{route('user.view', $responsavel['uuidU'])}}">{{$responsavel['nomeU']}}</a></td>
                                        <td class="row">
                                            <div class="dropdown col-lg-6 col-md-4 col-sm-6">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                    Mais opções
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item btn" href="{{route('responsavel.view', $responsavel['uuidR'])}}">Visualizar</a>
                                                    <a class="dropdown-item btn" href="{{route('responsavel.edit', $responsavel['uuidR'])}}">Editar</a>
                                                    <a class="dropdown-item btn" data-toggle="modal" data-url="{{route('responsavel.del', $responsavel['uuidR'])}}" data-nomeB="{{$responsavel['nomeR']}}" data-target="#apagarModalCenter">Apagar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Nenhum responsável cadastrado</td>
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
                <p>Você realmente quer apagar do sistema todos os dados deste responsável ?</p>
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
