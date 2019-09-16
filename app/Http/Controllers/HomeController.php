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

        return $this->index();
    }

    public function searchResponsaveis(Request $request)
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
        $responsaveis = $this->getResponsaveis(10);

        foreach($responsaveis as $key => &$value){
            $responsaveis[$key]['contatos'] = [
                $value['contatos']['cell'],
                $value['contatos']['tell'],
                $value['contatos']['email']
            ];
            $responsaveis[$key]['filhos'] = $this->getFilhosResponsaveis($value['uuid']);
        }

        $data = [
            'totalBaixinhosFrequentes'  => 0,
            'totalFichasFaltando'       => 0,
        ];

        // $responsaveis = [
        //     [
        //         'uuid'      => Str::uuid()->toString(),
        //         'nome'      => 'teste',
        //         'filhos'    => ['filho1', 'filho2', 'filho3'],
        //         'contatos'      => ['numerotell1', 'email1', 'numeroCell1'],
        //     ],
        //     [
        //         'uuid'      => Str::uuid()->toString(),
        //         'nome'      => 'teste2',
        //         'filhos'    => ['filho21', 'filho22', 'filho23'],
        //         'contatos'      => ['numerotell2', 'email2', 'numeroCell2'],
        //     ],
        //     [
        //         'uuid'      => Str::uuid()->toString(),
        //         'nome'      => 'teste3',
        //         'filhos'    => ['filho31', 'filho32', 'filho33'],
        //         'contatos'      => ['numerotell3', 'email3', 'numeroCell3'],
        //     ],
        // ];

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
