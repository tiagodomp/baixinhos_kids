@extends('layouts.pages')

@section('content')

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Galeria de fotos</h4>
                <div class="tz-gallery">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <a class="lightbox" href="{{ url($data['path']) }}">
                                    <img src="{{ url($data['path']) }}" alt="{{$data['nomeB']}}">
                                </a>
                                <div class="caption">
                                    <h3>{{$data['nomeB']}}</h3>
                                    <p>{{$data['descricao']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <a class="lightbox" href="{{ url('img/background.png') }}">
                                    <img src="{{ url('img/background.png') }}" alt="background">
                                </a>
                                <div class="caption">
                                    <h3>Thumbnail label</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <a class="lightbox" href="{{ url('img/background.png') }}">
                                    <img src="{{ url('img/background.png') }}" alt="background">
                                </a>
                                <div class="caption">
                                    <h3>Thumbnail label</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection()
