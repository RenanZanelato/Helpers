<?php

/**
 * Classe GerarXLSX
 * 
 * @name GerarXLSX
 * @author Renan Zanelato <renan.zanelato@gazin.com.br>
 * @version 1.0
 * @access public
 */
class GerarXLSX {

    private $nomeArquivo;
    private $excel;

    public function __construct($dados = null, $excel = false, $nomeArquivo = 'arquivoxlsx', $ext = 'xlsx') {
        $this->nomeArquivo = $nomeArquivo . '.' . $ext;
        $this->excel = $excel;
        if ($this->excel) {
            return $this->gerarExcel($dados);
        }
    }

    private function gerarExcel($dados) {

        $html = $this->gerarTable($dados);
        // Configurações header para forçar o download
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$this->nomeArquivo}\"");
        echo $html;

        return true;
    }

    public function gerarTable($dados) {
        $html = '';
        $html .= "<style>
        table, th, td {
           border: 1px solid black;
           font-family:'Times New Roman', Georgia, Serif;
        }
        thead {
            background:#0000CD;
            color:white;
        }
        </style>
        ";
        $html .= '<table>';
        $html .= "<thead>";
        $html .= "<tr>";
        // O Valor 0 do array sera o nome das colunas
        foreach ($dados[0] as $key => $value) {
            $html .= "<td> <b>" . strtoupper($key) . "</b></td>";
        }
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($dados as $value) {
            $html .= '<tr>';
            foreach ($value as $key => $val) {
                $html .= "<td>$val</td>";
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

}
