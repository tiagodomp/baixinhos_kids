<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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

    public function cadastrarFicha(Request $request){
        // $p = $this->novaFichaCadastro($request);
        // if($p[0])
        //     return redirect(route('home'), 200);

        if(!empty($request->canalUuid)){
            $uuidCanal = $request->canalUuid;
        }else{
            $canal = $this->inserirCanal($request);
            $uuidCanal = ($canal[0])?$canal[1]:'';
        }

        if(!empty($request->responsavelUuid)){
            $uuidR = $request->responsavelUuid;
        }else{
            $responsavel = (!empty($uuidCanal))?$this->inserirResponsavel($request, $uuidCanal):[false, ''];
            $uuidR = ($responsavel[0])?$responsavel[1]:'';
        }

        $data = (!empty($uuidR))?$this->inserirBaixinho($request, $uuidR):[false, ''];

        // if(!$data[0])
        //     return redirect()->back()->withErrors($request)->withInput();

        return redirect()->route('home');
    }

    public function searchBaixinhos(Request $request)
    {
        $responsaveis = [];
        if($request->ajax()){
            $responsaveis = $this->searchResponsaveis($request->search);
        }

        dd($responsaveis);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $frequencia = $this->getBaixinhosFrequentes();
        $fichas     = $this->getFichasFaltando();
        $data = [
            'totalBaixinhosFrequentes'  => $frequencia['total'],
            'baixinhosFrequentes'       => $frequencia['baixinhos'],
            'totalFichasFaltando'       => $fichas['total'],
            'fichasFaltando'            => $fichas['baixinhos'],
            'rankingCanais'             => $this->getCanaisResponsaveis(),
        ];

        //Obtém os responsaveis e os nomes dos filhos
        $responsaveis = $this->getResponsaveis(50);
        foreach($responsaveis as $key => &$value){
            $responsaveis[$key]['contatos'] = [
                $value['contatos']['cell'],
                $value['contatos']['tell'],
                $value['contatos']['email']
            ];
            $responsaveis[$key]['filhos'] = $this->getFilhosResponsaveis($value['uuid'])['nomes'];
        }

        //obtém os canais
        $canais = $this->getCanais(50);

        return view('home', compact('data', 'responsaveis', 'canais'));
    }
}
