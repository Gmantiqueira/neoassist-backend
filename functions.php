<?php    
    function formatarTexto($string){
        return preg_replace("[^a-zA-Z0-9_]", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
    }

    function returnJson($json){
        echo json_encode($json, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    function sortByDateCreate($a, $b){
        return strtotime($a["DateCreate"]) - strtotime($b["DateCreate"]);
    };

    function sortByDateCreate_reverse($a, $b){
        return strtotime($b["DateCreate"]) - strtotime($a["DateCreate"]);
    };

    function sortByDateUpdate($a, $b){
        return strtotime($a["DateUpdate"]) - strtotime($b["DateUpdate"]);
    };

    function sortByDateUpdate_reverse($a, $b){
        return strtotime($b["DateUpdate"]) - strtotime($a["DateUpdate"]);
    };

    function sortByScore($a, $b){
        return $b["Score"] < $a["Score"];
    };

    function sortByScore_reverse($a, $b){
        return $b["Score"] > $a["Score"];
    };
?>