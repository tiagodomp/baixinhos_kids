<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Canal;
use App\Traits\FichaCadastroTrait;

class CanalController extends Controller
{
    use FichaCadastroTrait;

    public function index()
    {
        $c = new Canal();
        $data = $c->getListCanais();

        return view('canais.home', compact('data'));
    }

    public function inserir(Request $request)
    {
        $c = $this->inserirCanal($request);
        return redirect()->route('canais');
    }
}
