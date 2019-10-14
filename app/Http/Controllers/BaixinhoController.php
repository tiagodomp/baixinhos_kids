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

    public function add()
    {
        //Obtém os responsaveis e os nomes dos filhos
        $responsaveis = $this->getResponsaveis();
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

    public function addFichaCadastro(Request $request, string $uuid)
    {
        $retorno = $this->addFicha($request, $uuid);

        return redirect(route('baixinho.view', $uuid), 302, $request->header());
    }

    public function addHistorico(Request $request, string $uuid)
    {
        $cabeleireiro = [auth()->user()->nome, auth()->user()->uuid] ;
        if($request->cabeleireiroHistorico == $cabeleireiro[0]){
            $nome = $request->cabeleireiroHistorico;
            $search = DB::table('users')->whereRaw("nome LIKE '%".$nome."%' OR apelido LIKE '%".$nome."%'")->selectRaw('nome, uuid')->get();
            if(!empty($search) && $search->count() === 1){
                $cabeleireiro = [$search[0]->nome, $search[0]->uuid];
            }else{
                $cabeleireiro = [$nome,''];
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
            'cabeleireiro'       => $cabeleireiro,
            'responsavel'       => $responsavel,
            'metodo_pagamento'  => [$request->tipoPagamentoHistorico, $request->modeloPagamentoHistorico],
            'tipo_corte'        => $request->corteCabeloHistorico,
            'obs'               => $request->obsHistorico,
            'agendado_para'     => $request->agendadoParaHistorico,
            'tag'               => $request->has('tagHistorico')
        ];

        $b = new Baixinho();
        $save = $b->historicoCorte($data);
        $b->addHistorico($save, ['uuid' => $uuid]);
        return redirect(route('baixinho.view', $uuid), 302, $request->header());
    }

    public function addImg(Request $request, string $uuid)
    {
        $data = ($request->hasfile('imagensB'))?$this->imagensJson($request->imagensB, $uuid):[];
        if(empty($data))
            return redirect()->back()->with('danger', 'Erro em inserir imagens');

        return ($this->arrayInsertJsonTb('baixinhos', 'imagens', ['uuid' => $uuid], $data[0]))
            ?redirect()->back()->with('success', 'As imagens foram inseridas com sucesso')
            :redirect()->back()->with('danger', 'Erro em inserir imagens');
    }

    public function addFicha(Request $request, string $uuid)
    {
        $b = Baixinho::find($uuid);
        if(empty($b))
            return false;

        if($request->hasfile('fichaCadastro')){
            $b->ficha_cadastro = $this->imagensJson($request->fichaCadastro, $uuid);
        }

        $b->autorizacao_audiovisual = $request->has('autorizacaoAudiovisual');
        return $b->save();
    }

    public function galeria()
    {
        $b = new Baixinho();
        $data = $b->getImgGaleria();
        return view('baixinhos.galeria', compact('data'));
    }

    public function fichascadastro()
    {
        $b = new Baixinho();
        $data = $b->getImgFichaCadastro();
        return view('baixinhos.fichascadastro', compact('data'));
    }

    public function historico()
    {
        $b = new Baixinho();
        $data = $b->getListHistoricaBaixinhos();
        return view('baixinhos.historico', compact('data'));
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
