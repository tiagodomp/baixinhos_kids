@extends('layouts.pages')

@section('content')

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Galeria de fotos</h4>
                @if(!empty($data))
                    <div class="tz-gallery">
                        <div class="row mt-2 mb-2">
                            @foreach($data as $key => $baixinho)
                                @foreach($baixinho['imagens'] as $seq => $img)
                                    <div class="col-sm-6 col-md-4 ">
                                        <div class="thumbnail">
                                            <a class="lightbox" href="{{ url('storage/'.$img['path']) }}">
                                                <img src="{{url('storage/'.$img['path'])}}" style="height: 300px" alt="foto de {{$baixinho['nomeB']}}">
                                            </a>
                                            <div class="caption">
                                                <h3><a class="header-title" href="{{route('baixinho.view', $baixinho['uuidB'])}}"> {{$baixinho['nomeB']}}</a></h3>
                                                <p>Esta foto foi tirada em {{date('d/m/Y \á\s H:i\h', strtotime($img['created_at']))}} e inserida no sistema por <a href="{{route('user.view', $img['criado_por'][1])}}">{{$img['criado_por'][0]}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @else
                    As fotos de todos os seus baixinhos aparecerão aqui
                @endif
            </div>
        </div>
    </div>
</div>

@endsection()
