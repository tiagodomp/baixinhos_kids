<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <title>{{ config('app.name', 'Baixinhos Kids') }}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="#">
	<meta name="keywords" content="Baixinhos Kids, Cabeleireiro infantil, Cabeleireiro Vila Matilde - SP, Nitroempreenda">
    <meta name="author" content="Tiago Pereira - Nitroempreenda">
	<link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">


   <!--  Custom Style -->
   <link rel="stylesheet" href="{{ url('assets/css/estilo.css') }}">
   <!-- JQuery 3.3.1 last version -->
   <script src="{{ url('assets/jquery/jquery-3.3.1.min.js') }}"></script>
   <!-- Menu Horizontal -->
   <link rel="stylesheet" type="text/css" href="{{ url('assets/menu/styles-menu.css') }}">
   <script src="{{ url('assets/menu/script-menu.js') }}"></script>
	{{-- <!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Mada:300,400,500,600,700" rel="stylesheet"> --}}
	<!-- Required Fremwork -->
	{{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/bower_components/bootstrap/css/bootstrap.min.css') }}"> --}}
	<!-- themify icon -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/icon/themify-icons/themify-icons.css') }}">
  <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/icon/font-awesome/css/font-awesome.min.css') }}">
	<!-- ico font -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/icon/icofont/css/icofont.css') }}">
	<!-- flag icon framework css -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/pages/flag-icon/flag-icon.min.css') }}">
	<!-- Menu-Search css -->
   <link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/pages/menu-search/css/component.css') }}">
   <!-- Style.css -->
   <link rel="stylesheet" type="text/css" href="{{ url('assets/tema_1/assets/css/style.css?1') }}">

   <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

   <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script> let URL = "{{url('/')}}"; </script>

</head>
<body>
<div id="app">
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="ball-scale">
          <div></div>
      </div>
  </div>

<!-- start menu -->
  <div id='menu-fixed'>
    <div id='cssmenu'>
        @php
        $current_url = url()->current();
        $pedaco = explode('/',str_replace(url(''),'',$current_url));
        @endphp
      <ul>
         <li class="d-flex justify-content-center"><img class="my-1 mx-1" src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" width="30%" height="30%" margin="0" alt="Logo" /></li>
         <li @if($current_url == route("home")) class="active" @endif>          <a href="{{ route('home') }}">Início</a></li>
         <li @if($current_url == route('responsaveis')) class="active" @endif>  <a href="{{ route('responsaveis') }}">Responsáveis</a></li>
         <li @if($current_url == route('baixinhos')) class="active" @endif>     <a href="{{ route('baixinhos') }}">Baixinhos</a></li>
         <li @if($current_url == route('funcionarios')) class="active" @endif>  <a href="{{ route('funcionarios') }}">Funcionários</a></li>
         <li @if($current_url == route('canais')) class="active" @endif>        <a href="{{ route('canais') }}">Canais</a></li>
         <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form></li>
      </ul>
    </div>
  </div>
  <div class="menu-space"></div>
<!-- End Menu -->
  <div class="">
      <div class="">
          <div class="">
              <div class="">
                  <div class="">
                      <div class="page-body">
                          <!-- start conteudo -->
                          @yield('content')
                          <!-- end conteduo -->

                          <div class="fab">
                                <button class="main"></button>
                                <ul>
                                    <li>
                                        <label for="opcao1">Novo B</label>
                                        <button id="opcao1">
                                            <i class="icofont icofont-baby"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <label for="opcao2">Novo R</label>
                                        <button id="opcao2">
                                            <i class="icofont icofont-users-alt-4"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <label for="opcao3">Novo C</label>
                                        <button id="opcao3">
                                            <i class="icofont icofont-map-pins"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>

  <script src="{{ url('assets/tema_1/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/popper.js/js/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- jquery slimscroll js -->
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
  <!-- i18next.min.js -->
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/i18next/js/i18next.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/tema_1/bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
  <!-- Custom js -->
  <script type="text/javascript" src="{{ url('assets/tema_1/assets/js/script.js') }}"></script>
  <!-- Start datatable js -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!--Bootstrap select -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
