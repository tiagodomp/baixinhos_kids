<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FichaCadastroTrait;

class HomeController extends Controller
{
    use FichaCadastroTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * cadastrar as fichas de cadastro
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fichaCadastro(Request $request)
    {
        return response()->json($this->fichaCompleta($request));
    }
}
