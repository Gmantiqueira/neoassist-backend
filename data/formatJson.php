<?php 

    $contents = file_get_contents('data/tickets.json');

    $json = json_decode($contents, true);

    $newJson = array();
    
    foreach($json as $ticket){
        /* Calculando atraso do ticket */
        $dataResposta = $ticket["Interactions"][1]["DateCreate"];
        $dataCriacao = $ticket["DateCreate"];
        $atraso = abs(strtotime($dataResposta) - strtotime($dataCriacao));
        $atraso = floor($atraso / (60 * 60 * 24));
        $ticket["DaysDelay"] = strval($atraso);
        /* ---------------------------------- */

        /* Procurando insatisfação do cliente */
        
        $search;
        $wordScore = 0;
        $greatWords = 0;
        $goodWords = 0;
        $attentionWords = 0;
        $criticalWords = 0;

        foreach($ticket["Interactions"] as $email){
            if($email["Sender"] !== "Expert"){
                /* Palavra-chave definitiva de reclamação (Certeza de insatisfação) */
                
                $search = join("|",$criticalKeyWords);
                $search = preg_match("/{$search}/i", formatarTexto($email["Message"])) + preg_match("/{$search}/i", formatarTexto($email["Subject"]));
                $criticalWords += $search * 2;

                $search = join("|",$attentionKeyWords);
                $search = preg_match("/{$search}/i", formatarTexto($email["Message"])) + preg_match("/{$search}/i", formatarTexto($email["Subject"]));
                $attentionWords += $search;

                $search = join("|",$goodKeyWords);
                $search = preg_match("/{$search}/i", formatarTexto($email["Message"])) + preg_match("/{$search}/i", formatarTexto($email["Subject"]));
                $goodWords -= $search;

                $search = join("|",$greatKeyWords);
                $search = preg_match("/{$search}/i", formatarTexto($email["Message"])) + preg_match("/{$search}/i", formatarTexto($email["Subject"]));
                $greatWords -= $search * 2;
                /* ---------------------------------- */
            }
        }

        $wordScore = $greatWords + $goodWords + $attentionWords + $criticalWords;

        /* ---------------------------------- */

        /* Pontuação do ticket */
        if($wordScore != 0){
            $score = $wordScore * (2 * floatval($ticket["DaysDelay"]));
        } else {
            $score = (2 * floatval($ticket["DaysDelay"]));
        }
        $score = number_format($score, 2);
        $ticket["Score"] = floatval($score);
        /* ---------------------------------- */

        /* Prioridade alta */
        $isPriority = $score >= 100 ? true : false;
        $ticket["highPriority"] = $isPriority;
        /* ---------------------------------- */

        array_push($newJson, $ticket);
    }

    $json = $newJson;
?>