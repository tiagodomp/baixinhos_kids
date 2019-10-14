<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait CrudJsonTrait
{
    /**
     * Verifica se o caminho Json existe na tabela
     * @return bool
     */
    protected function validarPathJson(string $Tb, string $collumn, array $where, string $pathjson)
    {
        $whereString = $this->geradorWhereString($where);
        $pathValido = DB::table($Tb)->whereRaw($whereString)
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
     * @param $data
     * @return bool true || false
     */
    protected function atualizarJsonTb(string $Tb, string $collumn, array $where, string $path, $data)
    {
        $whereString = $this->geradorWhereString($where);
        if($this->salvarRotaJson($Tb, $collumn, $where, $path)){
			$data       = (is_string($data) || is_int($data))? $this->utf8_ansi($data): "CAST('".$this->utf8_ansi(json_encode($data))."' AS JSON)";
            $sql        = "JSON_UNQUOTE(JSON_SET(".$collumn.", '".$path."', $data))";
            $data[0]    = DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.', updated_at = "'.now()->toDateTimeString().'" where '.$whereString);

            return ($data[0] == 1 && $data[1] == 1)?true:false;
        }
        return false;
    }

    /**
     * insere um dado em um array json
     * @param string $Tb
     * @param string $collumn
     * @param array $wheres
     * @param string $path
     * @param $data
     * @return bool true || false
     */
    public function arrayInsertJsonTb(string $Tb, string $collumn, array $where, $data, string $path = '$')
    {
        $whereString    = $this->geradorWhereString($where);
        $data           = (is_string($data) || is_int($data))?$this->utf8_ansi($data):"CAST('".$this->utf8_ansi(json_encode($data))."' AS JSON)";
        $sql            = "JSON_ARRAY_APPEND(".$collumn.", '".$path."', $data)";
        $data[0]        = DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.', updated_at = "'.now()->toDateTimeString().'" where '.$whereString);

        return ($data[0] == 1)?true:false;
    }

    /**
     * Apaga um array ou objeto Json
     * @param string $Tb
     * @param string $collumn
     * @param array $wheres
     * @param string $path
     * @return bool true || false
     */
    protected function removerJsonTb(string $Tb, string $collumn, array $where, string $path)
    {
        $whereString = $this->geradorWhereString($where);

        if($this->validarPathJson($Tb, $collumn, $where, $path)){

            $sql        = "JSON_REMOVE(".$collumn.", '".$path."')";
            $data[0]    = DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where '.$whereString);
            $data[1]    = DB::table($Tb)->whereRaw($whereString)->update(["updated_at" => now()->toDateTimeString()]);

            return ($data[0] == 1 && $data[1] == 1)?true:false;
        }
        return false;
    }

    public function searchPath(string $Tb, string $column, array $where, string $pathSearch,  string $query,  string $oneOrAll = 'one', string $scape = '')
    {
        $whereString = $this->geradorWhereString($where);
        $data = DB::table($Tb)
                    ->whereRaw($whereString)
                    ->selectRaw("JSON_SEARCH(".$column.", ".$oneOrAll.", ".$query.", ".$scape." , ".$pathSearch." ) as path")
                    ->get();

        return (!empty($data))?$data->path:'';
    }

    /**
	 * Método que busca dados dentro de uma coluna JSON
	 *
     * @param string $Tb            | Tabela de consulta
     * @param string $column        | Coluna json consulta e extração
     * @param string $pathResponse  | Caminho json da resposta
     * @param string $pathSearch    | Caminho json da validação
     * @param string $oneOrAll      | one OR all
     * @param mixed  $query         | valor de busca
     * @return object $query
     */
    public function searchJson(string $Tb, string $column, array $where, string $pathResponse, string $pathSearch, string $oneOrAll = 'one', $query)
    {

        $whereString = $this->geradorWhereString($where);
        $response = DB::table($Tb)
                    ->whereRaw($whereString)//$column."->'".$pathResponse."'"." is not null")
                    ->selectRaw(
                        "JSON_EXTRACT(
                            ".$column."->'".$pathResponse."',
                            JSON_UNQUOTE(
                                JSON_SEARCH(
                                    ".$column."->'".$pathSearch."',
                                    '".$oneOrAll."',
                                    '".$query."'
                                )
                            )
                        ) AS data"
                    )
                    ->get();
        return $response;
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

        //dd(0,$Tb, $collumn, $where, $path, $pathLocal);
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
                //dd(5,$Tb, $lojaId, $apiId, $collumn, $path, $pathLocal);
                return $this->salvarRotaJson($Tb,  $collumn, $where, $path, $pathLocal);
           }
        //Se a coluna estiver sem nenhum registro
        }elseif($countLocal == 1 && is_null($pathValido->retorno)){
            //dd(2,$Tb, $collumn, $where, $path, $pathLocal);
            $sql = (string) "CAST('{\"".$vetorOrigem[0]."\":{}}' AS JSON)";
            DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where '.$whereString);
            return $this->salvarRotaJson($Tb, $collumn, $where, $path, $pathLocal);

        //Em quanto o $path tiver campos.
        }else{
            if($countLocal == 0){
                $pathLocal .= '.'.$vetorOrigem[$countLocal];
                //dd(1,$Tb, $collumn, $where, $path, $pathLocal);
                return $this->salvarRotaJson($Tb, $collumn, $where, $path, $pathLocal);
            }

            //dd(3,$Tb, $collumn, $where, $path, $pathLocal);
            $sql = (string) "JSON_UNQUOTE(JSON_SET(".$collumn.", '".$pathLocal."', CAST('{}' AS JSON)))";
            DB::update('update '.$Tb.' set '.$collumn.' = '.$sql.' where '.$whereString);


            if($countLocal < $countOrigem){
                $pathLocal .= '.'. $vetorOrigem[$countLocal];
            }
            //dd(4,$Tb, $collumn, $where, $path, $pathLocal);
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

        return Arr::divide(array_filter($explode))[1];
    }

    /**
    * retorna a versão em string para executar um where
    * @param array $where - [campo => value]
    * @param bool $valueInArray
    * @return array [whereStringComValue, value] || [whereStringCom?, value]
    */
    public function geradorWhereString(array $where, bool $valueInArray = false)
    {
        $where = Arr::divide($where);
        if(empty($where))
            return ['', []];

        $first = array_key_first($where[0]);
        $whereString = '';
        foreach($where[0] as $key=>$value){
            if(is_int($value)){
				$data = $where[1][$key];
			}else{
				$data = ($valueInArray)?$value. ' = ?':$value." = '".$where[1][$key]. "'";
            }
            $whereString = ($key != $first)?$whereString.", ".$data:$data;
        }
        return ($valueInArray)?[$whereString, $where[1]]:$whereString;
    }

    /**
     * Converte os caracteres de latim/ansi para utf-8
     * @param string $valor
     * @return string
     */
    public function utf8_ansi(string $valor='') {

        $model = array(
        "\u00c0" =>"À",
        "\u00c1" =>"Á",
        "\u00c2" =>"Â",
        "\u00c3" =>"Ã",
        "\u00c4" =>"Ä",
        "\u00c5" =>"Å",
        "\u00c6" =>"Æ",
        "\u00c7" =>"Ç",
        "\u00c8" =>"È",
        "\u00c9" =>"É",
        "\u00ca" =>"Ê",
        "\u00cb" =>"Ë",
        "\u00cc" =>"Ì",
        "\u00cd" =>"Í",
        "\u00ce" =>"Î",
        "\u00cf" =>"Ï",
        "\u00d1" =>"Ñ",
        "\u00d2" =>"Ò",
        "\u00d3" =>"Ó",
        "\u00d4" =>"Ô",
        "\u00d5" =>"Õ",
        "\u00d6" =>"Ö",
        "\u00d8" =>"Ø",
        "\u00d9" =>"Ù",
        "\u00da" =>"Ú",
        "\u00db" =>"Û",
        "\u00dc" =>"Ü",
        "\u00dd" =>"Ý",
        "\u00df" =>"ß",
        "\u00e0" =>"à",
        "\u00e1" =>"á",
        "\u00e2" =>"â",
        "\u00e3" =>"ã",
        "\u00e4" =>"ä",
        "\u00e5" =>"å",
        "\u00e6" =>"æ",
        "\u00e7" =>"ç",
        "\u00e8" =>"è",
        "\u00e9" =>"é",
        "\u00ea" =>"ê",
        "\u00eb" =>"ë",
        "\u00ec" =>"ì",
        "\u00ed" =>"í",
        "\u00ee" =>"î",
        "\u00ef" =>"ï",
        "\u00f0" =>"ð",
        "\u00f1" =>"ñ",
        "\u00f2" =>"ò",
        "\u00f3" =>"ó",
        "\u00f4" =>"ô",
        "\u00f5" =>"õ",
        "\u00f6" =>"ö",
        "\u00f8" =>"ø",
        "\u00f9" =>"ù",
        "\u00fa" =>"ú",
        "\u00fb" =>"û",
        "\u00fc" =>"ü",
        "\u00fd" =>"ý",
        "\u00ff" =>"ÿ");

        return strtr($valor, $model);
    }
}
