<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class TesteController extends Controller
{
    //use ConfigBlingTrait;

    public function teste()
    {
        $time = now()->toDateTimeString();
        dd(Carbon::hasFormat('2019-02-25 10:30:21', 'Y-m-d H:i:s'));

        //$loja      = DB::table('lojas')->where('id', auth()->user()->loja_id)->select('apis')->first();
        $emissor = [['a'=>1,'b'=>2,'c'=>3],['d'=>1,'e'=>2,'f'=>3], ['g'=>1,'h'=>2,'i'=>3], ['j'=>1,'k'=>2,'l'=>3], 3];
        $receptor = ['Venda de mercadorias', 1];

        $keyPadrao = array_last($emissor);
        $i  = count($receptor) - 1;

        if(is_int($keyPadrao)){
            $n = count($emissor) - 1;
            $keyPadrao += $i;
            foreach($emissor as $key=>$value){
                if($key < $n)
                    $receptor[$i] = $value;
                $i++;
            }
        }else{
            $keyPadrao = 0;
            foreach($emissor as $value){
                $receptor[$i] = $value;
                $i++;
            }
        }

        if($keyPadrao > count($receptor))
            $keyPadrao = 0;

        $receptor[] = $keyPadrao;

        dd($receptor);



        $config = [
            'uuid'          => Str::uuid(),
            'nome'          => null, //(string) $loja->apis,
            'descricao'     => 'testee',
            'created_at'    => now()->toDateTimeString(),
            'updated_at'    => now()->toDateTimeString(),
            'deleted_at'    => now()->toDateTimeString(),
            'preferencias'  => [
                'contaIdMestre'         => 1,                                               // a conta_id salva no banco da api_bling na tabela bling campo contas
                'tipoNotaFiscal'        => ['Nota Fiscal', 'Nfce', 1],                      // o número representa o tipo selecionado e sempre deverá ser o ultimo no array
                'emitirAutomaticamente' => true,                                            // emitir ou apenas inserir a nota fiscal
                'emailParaReceberNf'    => auth()->user()->email,                           // Email padrão para receber o código, numero e link de uma NF ou Nfce quando esta for emitida
                'configPadrão'          => 'default',                                       // Nome ou uuid da configPadrãoBling
                'nat_operacao'          => $antiga,                                          // o número representa a casa da natureza de operação mais recente utlizada e sempre deverá ser o ultimo no array
            ],
        ];

        //return $this->configMestreBling($config);
    }
}
