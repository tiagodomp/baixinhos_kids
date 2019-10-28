<?php

namespace App\Http\Controllers;

use App\Responsavel;
use Illuminate\Http\Request;
use App\Traits\FichaCadastroTrait;

class ResponsavelController extends Controller
{
    use FichaCadastroTrait;
    public function index()
    {
        $r = new Responsavel();
        $data = $r->getListResponsaveis();

        return view('responsaveis.home', compact('data'));
    }

    public function apagar(Request $request, string $uuid)
    {
        $r = new Responsavel();
        $resp = $r->find($uuid);
        $resp->deleted_at = now();

        return ($resp->save())
                    ?redirect()->route('responsaveis')->with('success', 'Este responsável foi deletado')
                    :redirect()->back()->with('danger', 'Erro ao deletar responsável, tente novamente');
    }

    public function add()
    {   //obtém os canais
        $canais = $this->getCanais();

        return view('responsaveis.add', compact('canais'));
    }

    public function inserir(Request $request)
    {
        if(!empty($request->canalUuid)){
            $uuidCanal = $request->canalUuid;
        }else{
            $canal = $this->inserirCanal($request);
            $uuidCanal = ($canal[0])?$canal[1]:'';
        }

        $responsavel = (!empty($uuidCanal))?$this->inserirResponsavel($request, $uuidCanal):[false, ''];
        $uuidR = ($responsavel[0])?$responsavel[1]:'';

        return (!empty($uuidR))
                    ?redirect()->route('responsaveis')->with('success', 'Novo responsável criado com sucesso!')
                    :redirect()->back()->with('danger', 'Erro ao inserir responsável, tente novamente');
    }

    public function edit(string $uuid)
    {
        $r = new Responsavel();
        $data = $r->viewResponsavel($uuid);

        return (!empty($data))
                    ?view('responsaveis.edit', compact('data'))
                    :redirect()->back()->with('danger', 'Responsável não encontrado');
    }

    public function view(string $uuid)
    {
        $r = new Responsavel();
        $data = $r->viewResponsavel($uuid);
        return (!empty($data))
                ?view('responsaveis.perfil', compact('data'))
                :redirect()->back()->with('danger', 'Responsável não encontrado');
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

    public function addFichaCadastro(Request $request, string $uuidB = null)
    {
        $uuid = $uuidB;

        if(empty($uuid))
           $uuid = $request->uuidB;

        $salvou = BaixinhoController::addFicha($request, $uuid);

        if(!$salvou)
            return redirect()->back()->with('danger', 'Não foi possível inserir a ficha de cadastro');

        return redirect()->back()->with('success', 'Ficha de cadastro inserida com sucesso');

    }
    public function associar()
    {
        return view('responsaveis.associar');
    }

    public function addPermissao(Request $request, string $uuidB)
    {

    }
}
