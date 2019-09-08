<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait CrudJsonTrait
{
    /**
     * Verifica se o caminho Json existe na tabela notificacoes_apis.
     * @return bool
     */
    protected function validarPathJson(string $Tb, int $lojaId, int $apiId, string $collumn, string $pathjson)
    {
        $pathValido = DB::table($Tb)->where('loja_id', $lojaId)
                                    ->where('api_id',$apiId)
                                    ->selectRaw("JSON_CONTAINS_PATH(".$collumn.",'one','".$pathjson."') AS retorno")
                                    ->first();
        //Se existir
        if(!is_null($pathValido) && $pathValido->retorno == 1)
            return true;

        return false;
    }

    /**
     * Atualiza parcialmente ou insere caso não exista dados em uma coluna json
     * @param string $Tb
     * @param string $collumn
     * @param array $wheres
     * @param string $path
     * @param array $data
     * @return bool true || false
     */
    protected function atualizarJsonTb(string $Tb, string $collumn, array $where, string $path, array $data)
    {
        $whereString = $this->geradorWhereString($where);

        if($this->salvarRotaJson($Tb, $collumn, $where, $path)){
            $data    = (is_string($data) || is_int($data) || is_bool($data))? $this->utf8_ansi($data): "CAST('".$this->utf8_ansi(json_encode($data))."' AS JSON)";
            $sql     = (string) "JSON_UNQUOTE(JSON_SET(".$collumn.", '".$path."', ".$data." ))";
            $data[0] = DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where '.$whereString);
            $data[1] = DB::table($Tb)->whereRaw($whereString)->update(["updated_at" => now()->toDateTimeString()]);

            return ($data[0] == 1 && $data[1] == 1)?true:false;
        }
        return false;
    }

    /**
     * De forma recursiva insere ou atualiza no banco um caminho json
     * @param string $Tb | Tabela
     * @param int $lojaId
     * @param int $apiId
     * @param string $collumn | Coluna que deseja afetar
     * @param string $path | Caminho em forma de $.dot.json
     * @param string $pathJson | Não deve ser passado nenhum valor para este parametro, pois ele é dependente da recursividade
     * @return bool | true
     */
    private function salvarRotaJson(string $Tb, string $collumn, array $where, string $path, string $pathJson = '')
    {
        $whereString = $this->geradorWhereString($where);

        //obtém um vetor a partir do caminho cedido
        $vetorOrigem = (array) $this->str_explode($path, ['.', '$', '\'' ]);
        $countOrigem = (int) count($vetorOrigem);

        //obtem um vetor a partir do caminho que esta sendo salvo no banco
        $vetorLocal = (array) $this->str_explode($pathJson, ['.', '$', '\'' ]);
        $countLocal = (int) count($vetorLocal);

        //facilitar na validação abaixo
        $pathLocal = (string) ($pathJson != '')?$pathJson:'$';
        $pathQuery = (string) ($countLocal == 0)?$path:$pathLocal;

        //Verifico se este caminho json existe no BD
        $pathValido = DB::table($Tb)->whereRaw($whereString)
                                    ->selectRaw("JSON_CONTAINS_PATH(".$collumn.",'one','".$pathQuery."') AS retorno")
                                    ->first();

        //Se existir
        if(!is_null($pathValido) && $pathValido->retorno == 1){
           if($countLocal == 0 || $countLocal == $countOrigem){
               return true;
           }else{
                $pathLocal .= '.'.$vetorOrigem[$countLocal];
                //dd(2,$Tb, $lojaId, $apiId, $collumn, $path, $pathLocal);
                return $this->salvarRotaJson($Tb,  $collumn, $where, $path, $pathLocal);
           }
        //Se for o primeiro campo e ele não existir no banco
        }elseif($countLocal == 1){
            //dd(2,$Tb, $lojaId, $apiId, $collumn, $path, $pathLocal);
            $sql = (string) "JSON_UNQUOTE(JSON_SET(".$collumn.", '".$pathLocal."', CAST('{}' AS JSON)))";
            DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where  '.$whereString);
            return $this->salvarRotaJson($Tb, $collumn, $where, $path, $pathLocal);

        //Em quanto o $path tiver campos.
        }else{
            if($countLocal == 0){
                $pathLocal .= '.'.$vetorOrigem[$countLocal];
                //dd(1,$Tb, $lojaId, $apiId, $collumn, $path, $pathLocal);
                return $this->salvarRotaJson($Tb, $collumn, $where, $path, $pathLocal);
            }

            $sql = (string) "JSON_UNQUOTE(JSON_SET(".$collumn.", '".$pathLocal."', CAST('{}' AS JSON)))";
            DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where '.$whereString);


            if($countLocal < $countOrigem){
                $pathLocal .= '.'. $vetorOrigem[$countLocal];
            }
            //dd(4,$Tb, $lojaId, $apiId, $collumn, $path, $pathLocal);
            return $this->salvarRotaJson($Tb,  $collumn, $where, $path, $pathLocal);
        }
    }

    /**
     * Retorna um array simples contendo cada palavra separada pelos caracteres especificados no array
     * @param string $data      | string para explode
     * @param array $retirar    | Vetor com todos os caracteres que serão retirados
     * @return array $retorno   | Vetor contendo o resultado
     */
    public function str_explode(string $data, array $retirar = [])
    {
        $retirar = (array) ($retirar)?:array('"',',',' ', '[',']','\\', '/');
        $substituir = str_replace($retirar, $retirar[0], $data);
        $explode = explode($retirar[0], $substituir);

        return array_divide(array_filter($explode))[1];
    }
    /**
    * retorna a versão em string para executar um where
    * @param array $where - [campo => value]
    * @param bool $valueInArray
    * @return array [whereStringComValue, value] || [whereStringCom?, value]
    */
    public function geradorWhereString(array $where, bool $valueInArray = false)
    {
        $where = array_divide($where);
        $whereString = '';
        foreach($where[0] as $key=>$value){
            if(is_int($value)){
				$whereString .= $where[1][$key];
			}else{
				$whereString .= ($valueInArray)?$value." = '".$where[1][$key]. "'": $value. ' = ?';
			}
        }
        return [$whereString, $where[1]];
    }

}
