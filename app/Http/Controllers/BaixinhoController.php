<?php

namespace App\Http\Controllers;

use App\Baixinho;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\FichaCadastroTrait;

class BaixinhoController extends Controller
{
    use FichaCadastroTrait;
    public function index()
    {
        $b = new Baixinho();
        $data = [
            'listBaixinhos' => $b->getListBaixinhos()
        ];
        return view('baixinhos.home', compact('data'));
    }

    public function view(Request $request, string $uuid)
    {
        $b = new Baixinho();
        $date = new Carbon();
        $hoje = $date->now();
        $data = $b->viewBaixinho($uuid);
        $primeiro = $date->createFromFormat('Y-m-d', $data['primeiro_corteB']);
        $diffM = $primeiro->diffInMonths($hoje);
        $totalCortes = !empty($data['historicoB'])?count($data['historicoB']):0;
        if($totalCortes < $diffM){ // caso ele não tenha cortado no minimo uma vez todos os meses desde o primeiro corte
            $p = $totalCortes * 10 / $diffM; //calculo a porcentagem referente
            $data['ranking'] = $p/2; // e coloco de 1 a 5
        }elseif($totalCortes == 0 && $diffM == 0){
            $data['ranking'] = 0;
        }else{
            $data['ranking'] = 5;
        }
        $data['primeiro_corteB'] = $primeiro->format('d/m/Y');
        $data['nascimentoB'] = $date->createFromFormat('Y-m-d', $data['nascimentoB'])->format('d/m/Y');
        $data['createdB'] = $date->createFromFormat('Y-m-d H:i:s', $data['createdB'])->format('d/m/Y');
        $data['sexoB'] = $data['sexoB']?'Menina' : 'Menino';

        //dd($data);
        return view('baixinhos.perfil', compact('data'));
    }

    public function addHistorico(Request $request, string $uuid)
    {

        $cabeleleiro = [auth()->user()->nome, auth()->user()->uuid] ;
        if($request->cabeleleiroHistorico == $cabeleleiro[0]){
            $nome = $request->cabeleleiroHistorico;
            $search = DB::table('users')->whereRaw("nome LIKE '%".$nome."%' OR apelido LIKE '%".$nome."%'")->selectRaw('nome, uuid')->get();
            if(!empty($search) && $search->count() === 1){
                $cabeleleiro = [$search[0]->nome, $search[0]->uuid];
            }else{
                $cabeleleiro = [$nome,''];
            }
        }

        $responsavel = $request->responsavelHistorico;
        $search = DB::table('responsaveis')->whereRaw("nome LIKE '%".$responsavel."%'")->selectRaw('nome, uuid')->get();
        if(!empty($search) && $search->count() === 1){
            $responsavel = [$search[0]->nome, $search[0]->uuid];
        }else{
            $responsavel = [$nome,''];
        }

        $data = [
            'cabeleleiro'       => $cabeleleiro,
            'responsavel'       => $responsavel,
            'metodo_pagamento'  => [$request->tipoPagamentoHistorico, $request->modeloPagamentoHistorico],
            'tipo_corte'        => $request->corteCabeloHistorico,
            'obs'               => $request->obsHistorico,
            'agendado_para'     => $request->agendadoParaHistorico,
        ];
        $b = new Baixinho;
        $save = $b->historicoCorte($data);
        $b->addHistorico($save, ['uuid' => $uuid]);
        return $this->index();
    }

    public function add()
    {
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

        return view('baixinhos.add', compact('responsaveis', 'canais'));
    }

    public function addImg(Request $request, string $uuid)
    {
        $data = ($request->hasfile('imagensB'))?$this->imagensJson($request->imagensB, $uuid):[];
        if(empty($data))
            return false;

        return $this->atualizarJsonTb('baixinhos', 'imagens', ['uuid' => $uuid], '$[*]', $data);
    }

    public function addFicha(Request $request, string $uuid)
    {
        $b = new Baixinho();
        $baix = $b->where('uuid', $uuid)->select('ficha_cadastro')->first();
        $data = ($request->hasfile('fichaCadastro'))?$this->imagensJson($request->fichaCadastro, $uuid):[];

        if(empty($data) || empty($baix))
            return false;

        $baix->ficha_cadastro = $data;
        return $baix->save();
    }

    public function galeria()
    {
        return view('baixinhos.galeria');
    }

    public function apagar(Request $request, string $uuid)
    {
        $b = new Baixinho();
        $baixinho = $b->find($uuid);
        $baixinho->deleted_at = now();
        $baixinho->save();

        return $this->index();
    }
}
