<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
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

        $data = [
            'totalBaixinhosFrequentes'  => 0,
            'totalFichasFaltando'       => 0,
        ];
        $responsaveis = [
            [
                'uuid'      => Str::uuid()->toString(),
                'nome'      => 'teste',
                'filhos'    => ['filho1', 'filho2', 'filho3'],
                'data'      => ['numerotell1', 'email1', 'numeroCell1'],
            ],
            [
                'uuid'      => Str::uuid()->toString(),
                'nome'      => 'teste2',
                'filhos'    => ['filho21', 'filho22', 'filho23'],
                'data'      => ['numerotell2', 'email2', 'numeroCell2'],
            ],
            [
                'uuid'      => Str::uuid()->toString(),
                'nome'      => 'Mano Felps',
                'filhos'    => ['filho31', 'filho32', 'filho33'],
                'data'      => ['numerotell3', 'email3', 'numeroCell3'],
            ],
        ];

        $canais = [
            [
            'uuid'      => Str::uuid()->toString(),
            'titulo'    => Str::random(10),
            ],
            [
            'uuid'      => Str::uuid()->toString(),
            'titulo'    => Str::random(10),
            ],
            [
            'uuid'      => Str::uuid()->toString(),
            'titulo'    => Str::random(10),
            ],
        ];

        return view('home', compact('data', 'responsaveis', 'canais'));
    }
}
