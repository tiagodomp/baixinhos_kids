@extends('layouts.pages')

@section('content')

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Fichas de cadastro</h4>
                @if(!empty($data))
                <div class="tz-gallery">
                    <div class="row mt-2 mb-2">
                        @foreach($data as $key => $baixinho)
                                <div class="col-sm-6 col-md-4 ">
                                    <div class="thumbnail">
                                        <a class="lightbox" href="{{ url('storage/'.$baixinho['ficha']['path']) }}">
                                            <img src="{{url('storage/'.$baixinho['ficha']['path'])}}" style="height: 300px" alt="Ficha de cadastro de {{$baixinho['nomeB']}}">
                                        </a>
                                        <div class="caption">
                                            <h3><a class="header-title" href="{{route('baixinho.view', $baixinho['uuidB'])}}"> {{$baixinho['nomeB']}}</a></h3>
                                            <p>Esta ficha foi cadastrada em {{date('d/m/Y \á\s H:i\h', strtotime($baixinho['ficha']['created_at']))}}
                                                por <a href="{{route('user.view', $baixinho['ficha']['criado_por'][1])}}">{{$baixinho['ficha']['criado_por'][0]}}</a></p>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>
                @else
                    As fichas de cadastro de todos os seus baixinhos aparecerão aqui
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
