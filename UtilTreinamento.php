<?php


class UtilTreinamento {

    private static $alias = ['tv', 'tvv', 'td', 'tr'];

    public static function YoutubeID($url) {
        if (strlen($url) > 11) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                return $match[1];
            } else
                return false;
        }
        return $url;
    }

    public static function array_sort_by_column($arr, $col, $dir = 1) {
            $sort_dir = $dir == 1 ? SORT_ASC : SORT_DESC;

        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $sort_dir, $arr);
        return $arr;
    }

}
