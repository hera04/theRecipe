<?php 
    /* Funkcje, kt�re mog� wykorzysta� w r�nych motywach */ 
    
    /*
     * #.# Wczytywanie komentarzy
     */
    function fetchRecentComments($limit){
        global $wpdb;
        
        $limit = (int)$limit; // Rzutowanie na int dla bezpiecze�stwa
        
        /* 
            * Tworzenie alias�w w MYSQL skraca zapytanie.
            * 'SELECT C.* FROM {$wpdb->comments} C' oznacza nadanie aliasu C tabeli $wpdb->comments.
            * LEFT JOIN - z��czenie tabeli lewej z cz�ci� wsp�ln� tabeli prawej
            * */
        $res = $wpdb->get_results("
            SELECT C.*, P.post_title, P.ID
            FROM {$wpdb->comments} C
            LEFT JOIN {$wpdb->posts} P 
                ON C.comment_post_ID = P.ID
            WHERE comment_approved = 1
            ORDER BY comment_date_gmt DESC
            LIMIT {$limit}
        ");
        
        return $res;
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    /* #.# Przycinanie tytu��w
     *     Tytu�y musz� mie� odpowiedni� d�ugo��, aby nie zepsu�y szablonu.
     * */
        function cutText($text, $maxLength){
        
            $maxLength++;

            $return = '';
            if (mb_strlen($text) > $maxLength) {
                $subex = mb_substr($text, 0, $maxLength - 5);
                $exwords = explode(' ', $subex);
                $excut = - ( mb_strlen($exwords[count($exwords) - 1]) );
                if ($excut < 0) {
                    $return = mb_substr($subex, 0, $excut);
                } else {
                    $return = $subex;
                }
                $return .= '(...)';
            } else {
                $return = $text;
            }
        
            return $return;
        }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */        
?>