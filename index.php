<?php 

    include('config.php');
    include('functions.php');
    include('data/formatJson.php');

    /* API */

    $body = file_get_contents('php://input');

    $method = $_SERVER['REQUEST_METHOD'];

    header('Content-type: application/json; charset=UTF-8;');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    $query = array();
    parse_str($_SERVER['QUERY_STRING'], $query);
    
    if($method === 'GET'){

        /* Ordenação */
        if(isset($_GET['orderby'])){
            if(function_exists("sortBy".$query['orderby'])){
                usort($newJson, 'sortBy'.$query['orderby']);
            }
        }

        /* Filtro */

        /* Desde XX-XX-XXXX */
        if(isset($_GET['since']) && !isset($_GET['until'])){
            $json = $newJson;
            $newJson = array();
            $since = $query["since"];

            foreach($json as $ticket){
                if(strtotime($ticket["DateCreate"]) >= strtotime($since)){
                    array_push($newJson, $ticket);
                };
            };
        };

        /* Até XX-XX-XXXX */
        if(!isset($_GET['since']) && isset($_GET['until'])){
            $json = $newJson;
            $newJson = array();
            $until = $query["until"];

            foreach($json as $ticket){
                if(strtotime($ticket["DateCreate"]) <= strtotime($until)){
                    array_push($newJson, $ticket);
                };
            };
        };

        /* Desde XX-XX-XXXX Até XX-XX-XXXX */
        if(isset($_GET['since']) && isset($_GET['until'])){
            $json = $newJson;
            $newJson = array();
            $since = $query["since"];
            $until = $query["until"];

            foreach($json as $ticket){
                if(strtotime($ticket["DateCreate"]) >= strtotime($since) && strtotime($ticket["DateCreate"]) <= strtotime($until)){
                    array_push($newJson, $ticket);
                };
            };
        };

        /* Prioridade alta (true) ou normal (false)? */
        if(isset($_GET['highpriority'])){
            $json = $newJson;
            $newJson = array();
            $highPriority = filter_var($query["highpriority"], FILTER_VALIDATE_BOOLEAN);
            foreach($json as $ticket){
                if($ticket["highPriority"] == $highPriority){
                    array_push($newJson, $ticket);
                };
            };
        };

        $json = $newJson;

        /* Paginação */
        if(isset($query['page'])){
            $pageNumber = round(sizeof($json) / $ticketsByPage);
            $lastPage = $query['page'] * $ticketsByPage;
            $newJson = [];
            for($c = 1; $c <= sizeof($json); $c++){
                if($c <= $lastPage && $c > $lastPage - 5){
                    array_push($newJson, $json[$c - 1]);
                };
            };
            $json = $newJson;
            returnJson($json);
        } else{
            returnJson($json);
        };
    }

?>