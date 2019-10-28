<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $msg = [
            'required'      => 'Este campo é de preenchimento obrigatório',
            'password.min'  => 'A senha tem que conter no minimo 8 caracteres',
            'email.email'   => 'E-mail inválido',
            'email.unique'  => 'Este E-mail já esta cadastrado',
            'apelido.unique'=> 'Este apelido já foi cadastrado',
            'confirmed'     => 'As senhas não conferem'
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'apelido' => ['string', 'max:16', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $msg);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nome' => $data['name'],
            'email' => $data['email'],
            'apelido' => $data['apelido'],
            'password' => Hash::make($data['password']),
        ]);

    }
}
