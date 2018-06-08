<?php

/**
 * Classe ImportarXLS
 * 
 * @name ImportarXLS
 * @author Renan Zanelato <renan.zanelato@gazin.com.br>
 * @version 1.0
 * @access public
 */
class ImportarXLS {

    private $excel;
    private $planilha = null;
    private $linhas = null;
    private $colunas = null;
    private $all = null;
    private $nomeColuna = null;

    public function __construct($excel = null, $nomeColuna = null) {

        $this->planilha = new SimpleXLSX($excel);
        $this->nomeColuna = $nomeColuna;

        list($this->colunas, $this->linhas) = $this->planilha->dimension();
        list($this->all) = $this->planilha->dimension();


    }

    public function filtraPlanilha() {
        $this->colunas = $this->setNomeColunas();
        $arr = [];
        foreach ($this->planilha->rows() as $r) {
            $tmpArr = [];
            foreach ($this->colunas as $key => $value) {
//                //elimina os arrays vazil que vem da planilha
                if (!empty($r[$key]) || $r[$key] === 0) {

//                    //remove toda as virgulas das strings e subistitui por pontos
                    $r[$key] = str_replace(',', '.', $r[$key]);
//                    //remove caso tenha espaço na coluna
                    $value = trim($value);
//                    //adiciona o valor que foi rodado no tmpArr
                    $tmpArr[$value] = $r[$key];
                }
            }
            if (!empty($tmpArr)) {
                $dadosGeral[] = $tmpArr;
            }
        }

        unset($dadosGeral[0]);

        return $dadosGeral;
    }
    
    public function getNomeColunas(){
        return $this->nomeColuna;
    }

    // Seta no atributo $colunas um array com o nome de cada coluna
    public function setNomeColunas() {
        $arr = [];

        foreach ($this->planilha->rows()[0] as $value) {
            if (!empty($value)) {
                switch ($this->nomeColuna) {
                    case null or '':
                        $arr[] = $value;
                        break;
                    case is_array($this->nomeColuna):
                        foreach($this->nomeColuna as $key => $nomeColuna){
                            $arr[$key] = $nomeColuna;
                        }
                        break;
                    default:
                        $arr[] = $this->nomeColuna;
                        break;
                }
            }
        }

        return $arr;
    }

}
