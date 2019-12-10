@extends('layouts.pages')

@section('content')
<div class="row">
    <!-- sales area start -->
    <div class="col-xl-12 col-ml-12 col-lg-12 mt-5 mb-5">
        <!-- Primary table start -->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Histórico de cortes</h4>
                <div class="data-tables datatable-primary">
                    <table id="dataTable2" class="text-center">
                        <thead class="text-capitalize">
                            <tr>
                                <th>Cortou em</th>
                                <th>Nome</th>
                                <th>Cabeleireiro</th>
                                <th>Responsável</th>
                                <th>Tipo de Corte</th>
                                <th>ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach($data as $d)
                                    @if(!empty($d['historicoB']))
                                        @foreach($d['historicoB'] as $key => $hist)
                                            <tr>
                                                <td>
                                                    {{date('d/m/Y H:i', strtotime($hist['created_at']))}}
                                                </td>
                                                <td>
                                                    <a href="{{route('baixinho.view', $d['uuidB'])}}">{{$d['nomeB']}}</a>
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
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Nenhum corte de cabelo registrado</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
