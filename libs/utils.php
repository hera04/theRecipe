<?php 
    /* Funkcje, które mogê wykorzystaæ w ró¿nych motywach */ 
    
    /*
     * #.# Wczytywanie komentarzy
     */
    function fetchRecentComments($limit){
        global $wpdb;
        
        $limit = (int)$limit; // Rzutowanie na int dla bezpieczeñstwa
        
        /* 
            * Tworzenie aliasów w MYSQL skraca zapytanie.
            * 'SELECT C.* FROM {$wpdb->comments} C' oznacza nadanie aliasu C tabeli $wpdb->comments.
            * LEFT JOIN - z³¹czenie tabeli lewej z czêœci¹ wspóln¹ tabeli prawej
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
    
    /* #.# Przycinanie tytu³ów
     *     Tytu³y musz¹ mieæ odpowiedni¹ d³ugoœæ, aby nie zepsu³y szablonu.
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