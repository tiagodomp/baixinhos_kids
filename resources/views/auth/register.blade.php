@extends('layouts.auth')

@section('content')

<!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form>
                    <div class="login-form-head">
                        {{--  <h4>Sign up</h4>
                        <p>Hello there, Sign up and Join with Us</p>  --}}
                        <img src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" alt="Logo">
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="name">Nome Completo</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                            <i class="ti-user"></i>
                        </div>
                        <div class="form-gp">
                            <label for="email">Seu E-mail principal</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="apelido">Como as crianças te chamam?</label>
                            <input id="apelido" type="text" name="apelido" value="{{ old('apelido') }}" required>
                            <i class="ti-user"></i>
                        </div>
                        <div class="form-gp">
                            <label for="password">Crie uma Senha</label>
                            <input id="password" type="password"  name="password" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label for="password-confirm">Repita a senha</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Repita a senha" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Registrar <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Ja tem uma conta ?<a href="{{ route('login') }}"> Faça Login</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection
