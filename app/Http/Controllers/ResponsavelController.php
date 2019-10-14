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
        $resp->save();

        return redirect()->route('responsaveis');
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

        return redirect()->route('responsaveis');
    }

    public function associar()
    {
        return view('responsaveis.associar');
    }
}
