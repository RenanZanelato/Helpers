<?php

/**
 * Classe SoapReturn
 * 
 * @name SoapReturn
 * @author Renan Zanelato <renan.zanelato@gazin.com.br>
 * @version 1.0
 * @access public
 */

/*
 *  $url = URL do WSDL
 *  $function = Nome da Funcao
 *  $args = quais tags devem ser buscadas no XML
 *  $type estilo do retorno, se estiver reotrnando XML,deve ser tratado como 2, se retornar ARRAY deve tratar como 1,não é obrigatorio
 */
class SoapReturn {

    private static $soap;
    private  $url; 
    private  $function; 
    private  $args; 
    private  $filter;
    private  $util;
    
    public function paramSoap($url,$function,$args){
        $this->url = $url;
        $this->function = $function;
        $this->args = $args;
        $this->util = new \App\Helper\Util();
       
        
        return true;
    }
    
    public function execute(){
        return $this->filter;
    }
    public function resgataXml() {

        $options = ['location' => $this->url];
        $params = [$this->function => $this->args];
        try {
            self::$soap = new \SoapClient($this->url);
            if (!self::validaFunctionSOAP($this->function)) {
                throw new \Exception('Função não localizada');
            }
            $xmlF = self::$soap->__soapCall($this->function, $params, $options);
            return $this->filter = $xmlF;
            
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 400);
        }
    }
    
    public function filtro($dados,$type = 1) {
        if(!empty($type) and is_numeric($type)){
                if($type == 1){
                    $xmlF = $this->FilterArray($dados);
                }
                if($type == 2){
                    $xmlF = $this->FilterXml($dados);
                }
            }
          return $xmlF;
    }
    
    
    private function FilterArray($dados){
        $arrTemp = json_encode($dados);
        $arr = json_decode($arrTemp,true);
        return $this->util::array_change_key_case_recursive($arr);

    }

    private function FilterXml($dados) {
        $xml = new \SimpleXMLElement($dados);

        $arrTemp = json_encode($xml);
        $arr = json_decode($arrTemp,true);
        
        return $this->util::array_change_key_case_recursive($arr);
    }

    private static function validaFunctionSOAP($values) {
        $xml = self::$soap->__getFunctions();
        $bool = false;
        foreach ($xml as $key => $val) {
            $pos = explode('Response', $val, -1);
            if (strpos(ucfirst($pos[0]), $values) !== false) {
                $bool = true;
            }
        }
        return $bool;
    }

}

