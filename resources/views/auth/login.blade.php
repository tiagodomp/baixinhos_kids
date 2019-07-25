@extends('layouts.app_login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="login-card card-block auth-body m-auto">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="auth-box">
                        <div class="text-center">
                            <img src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" alt="Logo" width="80%">
                        </div>
                        <hr/>
                        <div class="input-group">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus  placeholder="E-mail">
                            <span class="md-line"></span>
                        </div>
                        @if($errors->has('email'))
                            <strong class="text-red">{{ $errors->first('email') }}</strong>
                        @endif
                        <div class="input-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required  placeholder="Senha">
                            <span class="md-line"></span>
                        </div>
                        @if ($errors->has('password'))
                            <strong class="text-red">{{ $errors->first('password') }}</strong>
                        @endif
                        <div class="row m-t-25 text-left">
                            <div class="col-sm-7 col-xs-12">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                        <span class="text-inverse">Lembrar-me</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                                <a href="{{ route('password.request') }}" class="text-right f-w-600 text-inverse"> Esqueceu sua senha?</a>
                            </div>
                        </div>
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Entrar</button>
                            </div>
                            <div class="col-12 text-center">
                                <a href="{{ route('register') }}" class="text-right f-w-600 text-inverse">Não é cadastrado ? registre-se aqui</a>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-inverse text-left m-b-0">Sistema interno de registro de clientes</p>
                                <p class="text-inverse text-left"><b>Desenvolvido por Tiago Pereira</b></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
