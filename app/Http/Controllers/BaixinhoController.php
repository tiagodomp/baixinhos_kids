<?php

namespace App\Http\Controllers;

use App\Baixinho;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\FichaCadastroTrait;
use Illuminate\Support\Facades\Storage;

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

        return view('baixinhos.perfil', compact('data'));
    }

    public function add()
    {
        //Obtém os responsaveis e os nomes dos filhos
        $responsaveis = $this->getResponsaveis();

        //obtém os canais
        $canais = $this->getCanais();

        return view('baixinhos.add', compact('responsaveis', 'canais'));
    }
    public function edit(Request $request, string $uuid)
    {
            $b = new Baixinho();
            $data = $b->viewBaixinho($uuid);
            $responsaveis = $this->getResponsaveis();
            $canais = $this->getCanais();

            $data['primeiro_corteB'] = date('d/m/Y', strtotime($data['primeiro_corteB']));
            $data['createdB'] = date('Y-m-d', strtotime($data['createdB']));

            return view('baixinhos.edit', compact('data', 'responsaveis', 'canais'));
    }

    public function editSave(Request $request, string $uuid)
    {
            $data = $request->all();
            $b = new Baixinho();

            if(!empty($data['delImg'])){
                if($this->delImg($uuid, $data['delImg'])){
                    $request->flash('success', count($data['delImg']) . ' imagens foram deletadas');
                }else{
                    $request->flash('danger', 'Erro em apagar imagens');
                }
            }
            
            if($b->editBaixinhos($data, $uuid))
                return redirect()->route('baixinho.view', $uuid);


        return redirect()->back()->with('danger', 'Erro em editar este baixinho, tente novamente!');

    }

    public function editPermissao(Request $request, string $uuidB = null)
    {
        $b = new Baixinho();
        $d = true; $f = true; $a = true;
        if(empty($uuidB))
            $uuidB = $request->uuidB;

        if($request->has('delFichaCadastroInput') && $request->delFichaCadastroInput == 1)
            $d =  $b->delSoftPermissao($uuidB);

        if($request->hasfile('fichaCadastro')){
            $data = $this->imagensJson($request->fichaCadastro, $uuidB);
            $f =  $b->arrayInsertJsonTb('baixinhos', 'ficha_cadastro', ['uuid' => $uuidB], $data, '$[0]');
        }

        if($request->has('autorizacaoAudiovisual')){
            $a = $b->where('uuid', $uuidB)
                    ->update(['autorizacao_audiovisual' => 1]);
        }else{
            $a = $b->where('uuid', $uuidB)
                    ->update(['autorizacao_audiovisual' => 0]);
        }

        return ($d && $f && $a)
                ?redirect()->back()->with('success', 'Permissões alteradas com sucesso')
                :redirect()->back()->with('danger', 'Erros em alterar permissões');
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

    public function delImg(string $uuidB, array $paths):bool
    {
        $b = new Baixinho();
        $data = $b->delImg($uuidB, $paths);
        return Storage::delete($paths);
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

    public function getPermissoesAjax(Request $request, string $uuid = null)
    {
        if(empty($uuid))
            $uuid = $request->has('uuidB')?$request->uuidB:$request->input('uuid', '');

        $b = new Baixinho();
        $data = $b->getPermissoes($uuid);

        if(empty($data))
            return response()->json([])->with('warning', 'Baixinho não encontrado');

        if(!empty($data['fichaCadastro']['path']))
            $data['fichaCadastro']['path'] = (string) route('base').'/storage/'.$data['fichaCadastro']['path'];

        return response()->json($data);
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
