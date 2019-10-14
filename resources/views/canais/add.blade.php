
@extends('layouts.pages')

@section('content')
<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Criar novo canal</h4>
                <form action={{route('canais.inserir')}} class="col-md-12" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="card card-body">
                            <div class="form-group">
                                <label for="tituloCanal">Titulo</label>
                                <input type="text" name="tituloCanal" class="form-control" id="tituloCanal" placeholder="Titulo do Canal">
                            </div>
                            <div class="form-group">
                                <label for="descricaoCanal">Descrição</label>
                                <input type="textarea" name="descricaoCanal" class="form-control rounded-0" id="descricaoCanal" placeholder="Breve descrição...">
                            </div>
                            <div class="form-group">
                                <label for="tecnicasCanal">Regras</label>
                                <input type="textarea" name="tecnicasCanal" class="form-control rounded-0" id="tecnicasCanal" placeholder="Regras para lidar com os membros deste canal...">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
