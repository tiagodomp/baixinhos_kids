@extends('layouts.app_login')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="login-card card-block auth-body m-auto">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf


                        <div class="auth-box">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="text-center">
                                <img src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" alt="Logo" width="80%">
                            </div>
                            <hr/>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Seu E-mail principal" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Crie uma nova senha" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Repita a senha" required>
                                </div>
                            </div>

                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Atualizar Senha</button>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="{{ route('register') }}" class="text-right f-w-600 text-inverse">Não é cadastrado ? registre-se aqui</a>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-inverse text-left m-b-0">Redefinir senha</p>
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
