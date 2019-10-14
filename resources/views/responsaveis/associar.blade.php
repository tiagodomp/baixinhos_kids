@extends('layouts.pages')

@section('content')
<!-- preloader area end -->
<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
            <form>
                <div class="login-form-head">
                    <h4>Associar Responsáveis</h4>
                    <img src="{{url('img/padlock.png')}}" width="30%" height="30%" alt="bloqueio">
                </div>
                <div class="login-form-body">
                    <p class="text-justify">
                        Esta página possibilitará associar os Responsáveis entre os baixinhos,
                        facilitando na busca e na organização histórica dos dados.
                    </p>
                    <p  class="text-justify">Desbloqueie esta página entrando em contato com a <a target="_blank" href="https://www.linkedin.com/in/tiago-pereira1997/">Nitroempreenda</p></h5>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->
@endsection
