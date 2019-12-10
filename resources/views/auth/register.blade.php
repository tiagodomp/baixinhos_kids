@extends('layouts.auth')

@section('content')

<!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
        @include('erros')
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('cadastrar.store') }}">
                    @csrf
                    <div class="login-form-head">
                        <img src="{{ url('assets/img/logo-400px-145px-Baixinhos-kids.png') }}" alt="Logo">
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="name" @error('nome')class="text-danger" @enderror >Nome Completo</label>
                            <input id="nome" type="text" name="nome" value="{{ old('nome') }}" required>
                            <i class="ti-user"></i>
                            @error('nome') <p class="text-danger">{{$errors->first('nome')}}</p> @enderror
                        </div>
                        <div class="form-gp">
                            <label for="email" @error('email') class="text-danger" @enderror>Seu E-mail principal</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            <i class="ti-email"></i>
                            @error('email') <p class="text-danger">{{$errors->first('email')}}</p> @enderror
                        </div>
                        <div class="form-gp">
                            <label for="apelido" @error('apelido') class="text-danger" @enderror>Como as crianças te chamam?</label>
                            <input id="apelido" type="text" name="apelido" value="{{ old('apelido') }}" required>
                            <i class="ti-user"></i>
                            @error('apelido') <p class="text-danger">{{$errors->first('apelido')}}</p> @enderror
                        </div>
                        <div class="form-gp">
                            <label for="password" @error('password')class="text-danger" @enderror>Crie uma Senha</label>
                            <input id="password" type="password"  name="password" required>
                            <i class="ti-lock"></i>
                            @error('password') <p class="text-danger">{{$errors->first('password')}}</p> @enderror
                        </div>
                        <div class="form-gp">
                            <label for="password-confirm"  @error('password')class="text-danger" @enderror>Repita a senha</label>
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                            <i class="ti-lock"></i>
                            @error('password') <p class="text-danger">{{$errors->first('password')}}</p> @enderror
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
