<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    public function index()
    {
        $responsaveis =[
            [
                'nome' =>'',
                'contatos' =>[
                    [
                        'email' => '',
                        'celular' => '',
                        'telefone' => '',
                    ],
                ],
                'canal' =>[
                    'uuid'=> '',
                    'titulo' => '',
                ],
                'criado_por' =>[
                    'uuid' => '',
                    'nome' => '',
                ],
                'created_at' =>'',
            ],
        ];
        return view('responsaveis.home', compact('responsaveis'));
    }
}
