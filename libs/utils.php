<?php 
    /* Funkcje, które mogê wykorzystaæ w ró¿nych motywach */ 
    
    /*
     * #.# Wypisywanie informacji
     */
        require_once THEME_DIR.'libs/messages.class.php';
        $msgs = messages::getInstance();
        
        function getMsgs(){
            global $msgs;
            return $msgs;
        }
        
        function showInfo(){
            if(getMsgs()){
                echo '<div data-alert class="alert-box warning radius info-bar">';
                if (getMsgs()->isInfo()){ 
                    echo '<ol>';
                    foreach (getMsgs()->getInfos() as $inf){
                        echo '<li>'.$inf.'</li>';
                    }
                    echo '</ol>';
                };  
                echo '<a href="#" class="close">&times;</a></div>';
            }
        }
        
        
    /*
     * #.# Rating
     * Funkcja wypisuje w postaci listy rating danego wpisu.
     */
        function showRating($postID,$field_name,$max_point){
            $rate = (int)get_post_meta($postID,$field_name,true);   // get_post_meta: https://developer.wordpress.org/reference/functions/get_post_meta/
            if ($rate){  
                echo '<ul class="inline-list">';
                for($i=1; $i<=$max_point; $i++){
                    echo '<li class="';
                    if( $i <= $rate){
                        echo 'active';
                    }
                    echo '"></li>';
                };
                echo '</ul>';
            } else echo 'Brak oceny';
        }
    
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
    
    /* #.# Przycinanie stringów
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
        
        
    /*
     * #.# Operacje na adresach www i parametrach
     */
        function current_page_url() {
            $pageURL = 'http';
            if( isset($_SERVER["HTTPS"]) ) {
                if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            }
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            return $pageURL;
        }
        
        function getQueryParams(){
            global $query_string;
            $parts = explode('&', $query_string);
            
            $return = array();
            foreach($parts as $part){
                $tmp = explode('=', $part);
                $return[$tmp[0]] = trim(urldecode($tmp[1]));
            }
            
            return $return;
        }  
        
        function getQuerySingleParam($name){
            $qparams = getQueryParams();
            
            if(isset($qparams[$name])){
                return $qparams[$name];
            }
            
            return NULL;
        }
        
        
    /*
     * #.# Zaokr¹glanie zapytañ do bazy WP
     * Pomocne w prostym wyszukiwaniu, gdzie mo¿emy 'zapodziaæ' jedn¹ literkê itp
     */    
        add_filter('posts_where', 'title_like_posts_where', 10, 2);
        function title_like_posts_where( $where, &$wp_query ) {
            global $wpdb;
            
            if ($post_title_like = $wp_query->get('post_title_like')){
                $where .= ' AND '.$wpdb->posts.'.post_title LIKE \'%'.esc_sql(like_escape($post_title_like)).'%\'';
            }
            
            return $where;
        }
        
    /*
     * #.# Tworzenie uniwersalnej paginacji
     * $loop jest to obiekt WP_Query dla tego motywu. Nie u¿ywam wp_query, poniewa¿ $loop bierze udzia³ w filtrowaniu wyników wyszukiwania.
     */
        function generatePagination($paged,$loop){
            $big = 999999999; // need an unlikely integer

            $page_links = paginate_links( array(
                'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'             => '?page=%#%',
                'total'              => $loop->max_num_pages,
                'current'            => max(1, $paged ),
                'show_all'           => False,
                'end_size'           => 1,
                'mid_size'           => 2,
                'prev_next'          => True,
                'prev_text'          => __('&#171;'),   // «
                'next_text'          => __('&#187;'),   // » 
                'type'               => 'array'
            ) );
            if( is_array( $page_links ) ) {
                $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
                echo '<ul class="pagination">';
                foreach ( $page_links as $page ) {
                    echo '<li>'.$page.'</li>';
                }
                echo '</ul>';
            }
        }
?>