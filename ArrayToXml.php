<?php

/**
 * Classe ArrayToXml
 * 
 * @name ArrayToXml
 * @author Renan Zanelato <renan.zanelato@gazin.com.br>
 * @version 1.0
 * @access public
 */
/*
 *  $name = nome do Arquivo que vai ser gerado
 *  $data = Array enviado
 *  $firstTag = nome da primeira tag que vai ser aberta
 *  $arrTemp nome da tag que estara separando cada array
 */
class ArrayToXml {

    public static function download($data, $firstTag = 'data', $arrTemp = '', $name = '') {

        header("Content-type: text/xml;charset=ISO-8859-7");
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . $name . '.xml');
        echo self::createXML($data, $firstTag, $arrTemp);
    }

    public static function getXml($data, $firstTag = 'data', $arrTemp = '', $name = '') {
        return self::createXML($data, $firstTag, $arrTemp);
    }

    private static function createXML($data, $firstTag, $arrTemp) {

        $xmlTemp = '<?xml version="1.0" encoding="ISO-8859-1"?>';
        $xmlTemp .= "<" . $firstTag . ">";
        $i = 1;
        foreach ($data as $arr) {
            $xmlTemp .= '<' . $arrTemp . ' id="' . $i . '">';
            foreach ($arr as $key => $val) {
                if (is_array($val)) {
                    $xmlTemp .= "<$key>".self::arrayRecursive($val, $key,$key)."</$key>";
                } else {
                    $xmlTemp .= "<$key>" . $val . "</$key>";
                    
                }
            }
            $i = $i + 1;
            $xmlTemp .= "</$arrTemp>";
        }
        $xmlTemp .= "</$firstTag>";
        
        return $xmlTemp;
    }

    private static function arrayRecursive($item, $key,$temp) {
        $xml = '';
        foreach ($item as $k => $v) {
            if(is_numeric($k)){
                $k = $temp;
            }
            if (is_array($v)) {
                $xml .="<$k>".self::arrayRecursive($v, $k,$temp)."</$k>";
            } else {
                $xml .= "<$k>" . $v . "</$k>";
            }
            
        }
        return $xml;
    }

}
