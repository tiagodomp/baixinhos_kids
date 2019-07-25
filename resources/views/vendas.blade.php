@extends('layouts.app')
@section('content')

@include('vendas/vendas_padrao')
 
<style type="text/css">
.text-list-filters_u{max-height:200px; width:100%; overflow:hidden; overflow-y:scroll;}
</style>

<div class="card z-depth-1">
    <!-- Nav tabs -->

	<div class="row px-5 mt-2">
        
    </div>


    <form action="{{ route('vendas.search') }}" method="post">
        @csrf
        <div class="row px-5 mt-2">
            <div class="col-sm-2">
                <h5>Filtros Ativos:
                    <i class="icofont icofont-info-square text-info"
                    data-toggle="tooltip" data-original-title="Filtros ativados para os resultados apresentandos na página" data-placement="top" title>
                    </i>
                </h5></br>
                @php
        if(isset($f)) {
        $verifica = $f;
        switch($verifica){
                case 0:
                    $botao_nome = "Todas as Vendas";
                break;
                case 1:
                    $botao_nome = "Todos os Pendentes";
                break;
                case 3:
                    $botao_nome = "Todos para Enviar";
                break;
                case 4:
                    $botao_nome = "Todos Enviados";
                break;
                case 5:
                    $botao_nome = "Todos Entregues";
                break;
                case 6:
                    $botao_nome = "Todos Finalizados";
                break;
                case 7:
                    $botao_nome = "Todos Cancelados";
                break;
                case 8:
                    $botao_nome = "Todos Pick&Pack";
                break;
                defaut:
                    $botao_nome = "Todas as Vendas";
                break;
        }
        }else{
             $botao_nome = "Todas as Vendas";
        }
        @endphp                
                <button type="button" class="btn btn-inverse py-0 px-2 mt-1 mr-2">Vendas</button>
                <button type="button" class="btn btn-inverse py-0 px-2 mt-1 mr-2"> {{ $botao_nome }}</button>
            </div>
            <div class="col-sm-4">
            <h5>Faça sua Busca por Vendas:
                <i class="icofont icofont-info-square text-info"
                data-toggle="tooltip" data-original-title="Digite uma pesquisa e clique em buscar para que o sistema retorne resultados que contenham o termo buscado" data-placement="top" title>
                </i>
            </h5>                                          
                <div class="input-group input-group-button input-group-inverse">
                    <input type="text" class="form-control" name="q" id="q" placeholder="Digite a sua busca...">
                    <span class="input-group-addon">
                        <button class="btn btn-inverse">Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="col-sm-3">
                <h5>Criar novo Grupo:
                    <i class="icofont icofont-info-square text-info"
                    data-toggle="tooltip" data-original-title="Clique no botão para criar um novo Grupo de Anúncios" data-placement="top" title>
                    </i>
                </h5></br>
               
                <a class="btn btn-inverse btn-block py-2 px-3" href="{{route('grupo.create')}}"><i class="icofont icofont-plus"></i>  Novo Grupo</a>
            </div>
            <div class="col-sm-3">
                <h5>Filtre os Resultados:
                    <i class="icofont icofont-info-square text-info"
                    data-toggle="tooltip" data-original-title="Selecione os filtros desejados e clique no botão 'FILTRAR' para segmentar os resultados da página" data-placement="top" title>
                    </i>
                </h5></br>
                <button type="button" class="btn btn-inverse btn-block py-2 px-3" onclick="show_u('filtrosAnuncios');"><i class="icofont icofont-options"></i> 
                    Filtrar Vendas
                </button>
            </div>
        </div>
        
    </form>
    <form action="{{ route('vendas.filtrando') }}" method="post">
    @csrf

    <div class="row px-5 py-5 mb-3 z-depth-1" id="filtrosAnuncios" style="display: none;">
        <div class="col-sm-12">
            <h4 class="text-primary">Selecione os Filtros Desejados
                <i class="icofont icofont-close-squared-alt text-danger float-right f-24" onclick="show_u('filtrosAnuncios');"
                style="cursor: pointer;" data-toggle="tooltip" data-original-title="Cancelar Filtro" data-placement="left" title></i>
            </h4>
        </div>
        <div class="col-sm-4">
        <h5>Todos os tipos de Vendas</h5>
            <nav class="text-list-filters_u mt-3">
                <ul>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="checkboxTodos" value="1" id="checkboxTodos">
                                <label class="border-checkbox-label" for="checkboxTodos">Todos</label>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </br>
        <h5>Organizar Por</h5>
        <nav class="text-list-filters_u mt-3">
            <div class="form-radio">
                <form>
                    <ul>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="1">
                                    <i class="helper"></i>Nome do Cliente (A-Z)
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="2">
                                    <i class="helper"></i>Nome do Cliente (Z-A)
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="3">
                                    <i class="helper"></i>Maior Quantidade
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="4">
                                    <i class="helper"></i>Menor Quantidade
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="5">
                                    <i class="helper"></i>Por Alerta
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="6">
                                    <i class="helper"></i>Data Crescente
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="radio radiofill radio-inline">
                                <label>
                                    <input type="radio" name="orderby" id="orderby" value="7">
                                    <i class="helper"></i>Data Decrescente
                                </label>
                            </div>
                        </li>

                        
                    </ul>
                </form>
            </div>
        </nav>
        </div>
        <div class="col-sm-4">
            
            <h5>Por Período</h5>
            <br>        
            @php
                $beg = date('Y-m-d', strtotime('-7 days'));
                $end = date('Y-m-d');
            @endphp
            <div class="col-sm-6">
                            
                            <input type="date" class="form-control" width="62%"  data-toggle="tooltip" data-original-title="Data Inicial" data-placement="top" value="{{ $beg }}" name="inicial" id="inicial">
                            <label class="border-checkbox-label" for="inicial">Data Inicial</label>
                            <input type="date" size="3" class="form-control" width="62%" data-toggle="tooltip" data-original-title="Data Final" data-placement="top" value="{{ $end }}" name="final" id="final">
                            <label class="border-checkbox-label" for="final">Data Final</label>    
                            
                    </div>
                    
            <h5>Status</h5>
            <nav class="text-list-filters_u mt-3">
                <ul>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="pendentes" id="pendentes" value="1">
                                <label class="border-checkbox-label" for="pendentes">Pendentes</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="pick&pack" id="pick&pack" value="8">
                                <label class="border-checkbox-label" for="pick&pack">Pick&Pack</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="enviar" id="enviar" value="3">
                                <label class="border-checkbox-label" for="enviar">Para Enviar</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="enviados" id="enviados" value="4">
                                <label class="border-checkbox-label" for="enviados">Enviados</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="entregues" id="entregues" value="5">
                                <label class="border-checkbox-label" for="entregues">Entregues</label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" name="finalizados" id="finalizados" value="2">
                                <label class="border-checkbox-label" for="finalizados">Finalizados</label>
                            </div>
                        </div>
                    </li>
 
                </ul>
            </nav>
        </div>
  
        <div class="col-sm-4">
        <h5>Conta</h5>
            <nav class="text-list-filters_u mt-3">
                <ul>
                    @php
                    $mkt = ['ML - Conta 1','ML - Conta 2', 'B2W - Ivam', 'B2W - Benini', 'Amazon - Maykson', 'Simplo7 - Wilson', 'ML - Raquel', 'ML - Urnau', 'ML - Nairo', 'ML - Benini'];
                    $size_array = sizeof($mkt);
                    @endphp 
                    @for($i = 0; $i < $size_array ; $i++)
                    <li>
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary mx-2">
                                <input class="border-checkbox" type="checkbox" id="checkbox{{ $mkt[$i] }}">
                                <label class="border-checkbox-label" for="checkbox{{ $mkt[$i] }}">{{ $mkt[$i] }}</label>
                            </div>
                        </div>
                    </li>
                    @endfor
                </ul>
            </nav>
            <div class="bottom mt-2">           
                <button type="submit" class="btn btn-primary btn-block py-2 px-3"> 
                Filtrar
                </button>
            </div>
        </div>
    
    
    
    </form>
    
    </div> 
 
<ul class="nav nav-tabs tabs px-5 my-2" role="tablist">
    	<li class="nav-item px-3">
            <a class="nav-link" data-toggle="tab" role="tab" aria-expanded="false"><h5>PEDIDOS:</h5></a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
        @php
        if(isset($f)) {
        $verifica = $f;
        if ($verifica == 0){$showa = "active";}else{$showa = "";}
        if ($verifica == 1){$showb = "active";}else{$showb = "";}
        if ($verifica == 8){$showc = "active";}else{$showc = "";}
        if ($verifica == 3){$showd = "active";}else{$showd = "";}
        if ($verifica == 4){$showe = "active";}else{$showe = "";}
        if ($verifica == 5){$showf = "active";}else{$showf = "";}
        if ($verifica == 6){$showg = "active";}else{$showg = "";}
        if ($verifica == 7){$showh = "active";}else{$showh = "";}

        }else {
            $showa = "active";
            $showb = "";
            $showc = "";
            $showd = "";
            $showe = "";
            $showf = "";
            $showg = "";
            $showh = "";

        }
      
            
        @endphp
            <a class="nav-link {{$showa}}" href="{{ route('vendas.filtros', 0)}}" role="tab" aria-expanded="true" >Todos [{{ $soma_todos }}] </a>
            <div class="slide"></div>
        </li>


        
        <li class="nav-item">
            <a class="nav-link {{$showb}}" href="{{ route('vendas.filtros', 1) }}" role="tab" aria-expanded="false">Pendentes [{{ $soma_pende }}]</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showc}}" href="{{ route('vendas.filtros', 8) }}" role="tab" aria-expanded="false">Pick&Pack [{{ $soma_pick }}]</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showd}}" href="{{ route('vendas.filtros', 3)}}" role="tab" aria-expanded="false">Para Enviar [{{ $soma_aenvi }}]</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showe}}" href="{{ route('vendas.filtros', 4)}}" role="tab" aria-expanded="false">Enviados [{{ $soma_envia }}]</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showf}}" href="{{ route('vendas.filtros', 5)}}" role="tab" aria-expanded="false">Entregues [{{ $soma_entre }}]</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showg}}" href="{{ route('vendas.filtros', 6)}}" role="tab" aria-expanded="false">Finalizados [{{ $soma_final }}]  </a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$showh}}" href="{{ route('vendas.filtros', 7)}}" role="tab" aria-expanded="false">Cancelados [{{ $soma_cance }}]  </a>
            <div class="slide"></div>
        </li>         
    </ul>


	<div class="row px-5 mt-2">
        @isset($contasML)
    	@foreach($contasML as $i => $conta)
        <div class="border-checkbox-section">
	    	<div class="border-checkbox-group border-checkbox-group-primary mx-2">
	    		<input class="border-checkbox" type="checkbox" id="checkbox{{ $i }}" checked="">
                <label class="border-checkbox-label" for="checkbox{{ $i }}">ML: {{$conta['nickname']}}</label>
            </div>
        </div>
        @endforeach
        @endisset
    </div>

    <div class="tab-content tabs card-block">
        
        <div class="tab-pane active" id="todos" role="tabpanel" aria-expanded="true">
            <p class="m-0">
                @yield('vendas')
        </div>

    </div>




<script>
    //Ao Clicar 2 vezes sobre o anúncio carrega maiores informações
    function showInfoOrder(x){
        var tr = document.getElementById('show-'+x);
        if(tr.style.display == 'none'){
            tr.style.display = 'flex';
        }else{
            tr.style.display = 'none';
        }
    }
    //Esta função faz com que seja alterado o botão na tela de pedidos, possibilitando a alteração do estado do produto
    function muda_estado_envio_u(id,x) {
        var link = "salva_estado_envio_u('"+id+"')";
        var estados = ['Pendentes','Pick&Pack', 'Para Enviar', 'Enviado', 'Entregue', 'Cancelado'];

        content = '<div class="form-group row mb-0">';
        content = content+'<div class="col-sm-8">';
        content = content+'<select name="select'+id+'" class="form-control">';
        for(var i = 0; i < estados.length; i++){
            content= content+'<option value="'+estados[i]+'">'+estados[i]+'</option>';
        }
        content = content+'</select></div><div class="col-sm-4 pl-0 pt-1">';
        content = content+'<button class="btn btn-success" onclick="'+link+'">';
        content = content+'<i class="fa fa-save mr-0"></i>';
        content = content+'</button></div></div>';
        document.getElementById(id).innerHTML = content;
        
        
    };
    //Esta função salva o estado de envio ao clicar em salvar
    function salva_estado_envio_u(id){
        var action = "muda_estado_envio_u('"+id+"','text');";    
        var meuid = id;
        var code   = meuid.substring(4,100);
        var valor = document.getElementsByName('select'+id)[0].value;
        content = '<button type="button"  onclick="'+action+'" class="btn btn-primary btn-block py-1 mt-1 px-1">'+valor+'</button>';
        document.getElementById(id).innerHTML = content;
                
        $.ajax({
                type: 'GET',
                url: '{{route('vendas.status','')}}/'+code,
                headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                },
                body: {
                    _method:'put',
                },
                data:{
                   'codigo' : code,
                   'state'  : valor,
                },
                success: function(data){
                console.log(data);
            }
           });
    }

    //Esta função gerencia a bandeira de alerta na venda
    function muda_flag_u(id){
        var element = document.getElementById('flag-'+id);
        var meuid = id;
        var name = element.getAttribute("name");
        var content = '';
        if(name == 'danger'){
            content = '<label class="badge align-self-center badge-inverse-default my-0 py-2 hand-pointer_u">';
            element.setAttribute("name", "default");
            flagstatus = 0;
            
            $.notify("Voce removeu um alerta de importância sobre esta venda.", "success");
            
        }else{
            content = '<label class="badge align-self-center badge-danger my-0 py-2 hand-pointer_u">';
            element.setAttribute("name", "danger");
            flagstatus = 1;
            
            $.notify("Voce adicionou um alerta de importância sobre esta venda.", "success");
        }
        content = content+'<i class="fa fa-flag"></i></label>';
        element.innerHTML = content;
     
    // vou iniciar aqui meu ajax para salvar a informacao 
    $.ajax({
                type: 'GET',
                url: '{{route('vendas.alteraflag','')}}/'+meuid,
                headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                },
                body: {
                    _method:'put',
                },
                data:{
                   'codigo' : meuid,
                   'state'  : flagstatus,
                },
                success: function(data){
                console.log(data);
            }
           });

    }
    //Esta função permite o funcionamento dos tooltip na página
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    //Esta função checa se existe imagem e corrige com imagem default se necessario. 
   /* function img_not_found(x){
        document.getElementById(x).src = "{{ url('img/sem-foto.jpg') }}";

    }
    }*/
    $(function() {
        $("#itemSelect").change(function(){
            if (this.checked) {
                $(".item").attr({ checked: true });
               } else {
                    $(".item").attr({ checked: false });
               }
        });
                $(".item").change(function(){
                $(".item").attr({ checked: false });
                
                });
    });     
    function show_u(x){
        var div = document.getElementById(x).style.display;
        var todos    = $("input[id='checkboxTodos']:checked").val();
        var organize = $("input[id='orderby']:checked").val();
        var pende    = $("input[id='pendentes']:checked").val();
        var pickpac  = $("input[id='pick&pack']:checked").val();
        var enviar   = $("input[id='enviar']:checked").val();
        var enviados = $("input[id='enviados']:checked").val();
        var entregues =$("input[id='entregues']:checked").val();

             

        if(div == "flex"){
            document.getElementById(x).style.display = "none";
        }else{
            document.getElementById(x).style.display = "flex";
        }
    }
</script>
<!--
<script type="text/javascript">
    $.onload = alert('Se for o primeiro login do usuario solicitar ao mesmo em um modal qual o tipo de impressora que utiliza (a4 ou Zebra) e se prefere Nota Fiscal ou Declaração de Conteúdo. Além disso informar que o mesmo poderá alterar estas configurações padrões acessando ao menu CONFIGURAÇÕES');
</script>
-->

@endsection





