@extends('layouts.auth')

@section('content')

<!-- login area start -->
<div class="login-area login-bg">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form-head">
                    <img src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" alt="Logo" style="margin:0px">
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="email">Seu E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        <i class="ti-email"></i>
                    </div>
                    <div class="form-gp">
                        <label for="exampleInputPassword1">Sua senha</label>
                        <input id="password" type="password"  name="password" required>
                        <i class="ti-lock"></i>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" name="remember" id="customControlAutosizing" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customControlAutosizing">
                                Lembrar-se
                                </label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('password.request') }}">Esqueci a senha</a>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">Entrar <i class="ti-arrow-right"></i></button>
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Não tem uma conta? <a href="{{route('register')}}"> Cadastre-se</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->
@endsection
