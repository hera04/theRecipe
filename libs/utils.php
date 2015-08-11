<?php 
    /* Funkcje, które mogê wykorzystaæ w ró¿nych motywach */     
    
    #region #.# Rating
    /*
     * Funkcja wypisuje w postaci listy rating danego wpisu.
     * Jeœli $exten jest ustawiony na true, funkcja wypisuje rating w wersji rozszerzronej ( 10 gwiazdek )
     */
        function showRating($postID, $extend = false){
            $max_point = 5;
            $rate = (int)get_post_meta($postID,'ranking',true);   // get_post_meta: https://developer.wordpress.org/reference/functions/get_post_meta/
            if ($rate){
                if ($extend){
                    $rate *= 2;
                    $max_point = 10;
                };
                echo '<ul class="inline-list">';
                for($i=1; $i<=$max_point; $i++){
                    echo '<li class="';
                    if( $i <= $rate ){ echo 'active'; }
                    if( $extend ){ echo ' extend'; }
                echo '"></li>';
                };
                echo '</ul>';
            } else echo '<ul class="inline-list">Brak oceny</ul>';
        }
        
    #endregion
    
    #region #.# Wczytywanie komentarzy
    /*
     * Funkcja wczytuje ostatnie komentarze ze strony
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
    #endregion
    
    #region #.# Przycinanie wypisów
    /* 
     * Przycinanie wypisów - musz¹ mieæ odpowiedni¹ d³ugoœæ, aby nie zepsu³y szablonu.
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
    #endregion    
    
    #region #.# Operacje na adresach www i parametrach
    /*
     * Funkcje operuj¹ce na adresach www i parametrach
     */
        function current_page_url() {
            // Funkcja generuje adres aktualnie odwiedzanej strony.
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
            // Funkcja pobiera wszystkiw parametry z adresu www
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
            //Funkcjapobiera pojedyñczy parametr z adresu www
            $qparams = getQueryParams();
            
            if(isset($qparams[$name])){
                return $qparams[$name];
            }
            
            return NULL;
        }
     #endregion   
     
    #region #.# Zapytania do bazy
        
        add_filter('posts_where', 'title_like_posts_where', 10, 2);
        function title_like_posts_where( $where, &$wp_query ) {
            /*
             * Zaokr¹glanie zapytañ do bazy WP
             * Pomocne w prostym wyszukiwaniu, gdzie mo¿emy 'zapodziaæ' jedn¹ literkê itp
             */       
            global $wpdb;
            
            if ($post_title_like = $wp_query->get('post_title_like')){
                $where .= ' AND '.$wpdb->posts.'.post_title LIKE \'%'.esc_sql(like_escape($post_title_like)).'%\'';
            }
            
            return $where;
        }
        
    #endregion
    
    #region #.# Paginacja
        /*
         * Tworzenie uniwersalnej paginacji
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
    #endregion
        
    #region #.# Generowanie formularzy ustawieñ
        
        function generate_checkbox_form( $option_collections, $option, $args ){
            /**
                * Funkcja generuje formularz checkbox na podstawie podanych w argumentach danych.
                * $option_collections  - kolekcja ustawieñ. W moim przypadku pole $page z add_section
                * $option              - ID pola ustawieñ zdefiniowanego w add_section_field
                * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                */ 
            if ( isset($option_collections) ){
                $options = get_option($option_collections);
                
                if ( isset($options) ){
                    $html = '<input type="checkbox" id="'.$option.'" name="'.$option_collections.'['.$option.']" value="1" ' . checked(1, $options[$option], false) . '/>'; 
                    $html .= '<label for="'.$option.'"> '  . $args[0] . '</label>';
                    echo $html;
                } else echo 'B³êdne parametry funkcji generate_checkbox_form. Brak kolekcji opcji lub opcji w bazie danych.';
                
            } else echo 'B³êdne parametry funkcji generate_checkbox_form. NIe podano nazwy kolekcji opcji.';
        }
        
        function generate_radio_form( $option_collections, $option, $sub_options,  $args ){
            /**
                * Funkcja generuje formularz Radio na podstawie podanych w argumentach danych.
                * Jeœli nie jest w³¹czona opcja show_banner - nie ma dostêpu do zmiany ustawieñ zawartoœci banneru.
                * $option_collections  - kolekcja ustawieñ. W moim przypadku pole $page z add_section
                * $option      - ID pola ustawieñ zdefiniowanego w add_section_field
                * $sub-options - tablica podopcji. $sub_options = ( array( ID_podopcji , Opis podopcji ) )
                * $default_val - wartoœæ domyœlna jaka ma byæ ustawiona.
                * $args        - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                */ 
            
            if ( is_array($sub_options) && isset($option_collections)){
                $options = get_option( $option_collections );
                
                if ( isset($options) && isset($options[$option]) ){
                    // Jeœli nie podano wartoœci domyœlnej staje siê ni¹ pierwszy element sub_options.
                    if (!isset($default_val)) $default_val = $sub_options[0];
                    
                    // EDIT : Usun¹³em wy³¹czanie pola
                    // Ustawienie domyœlnej wartoœci. Gdy tego nie ma, po w³¹czeniu i wy³¹czeni banneru, nie ma domyœlnej wartoœci podopcji.
                    // Problem powstaje przez to, ¿e wy³¹czamy pola (disabled) i wartoœci nie wysy³aj¹ siê do bazy danych.
                    //if (!isset($options[$option])) {
                    //    $options[$option] = $default_val;
                    //    update_option($option_collections, $options);
                    //}
                    
                    echo '<p> '  . $args[0] . '</p></br >';  
                    // Pêtla tworzy obiekty typu Radio
                    foreach ( $sub_options as $sub_option ){
                        $html = '<input type="radio" id="'.$sub_option[0].'" name="general_settings['.$option.']" value="'.$sub_option[0].'"' . checked( $sub_option[0], $options[$option], false ) . ' />';
                        $html .= '<label for="'.$sub_option[0].'">'.$sub_option[1].'</label></br >';
                        echo $html;
                    };
                } else echo 'B³êdne parametry funkcji generate_radio_form.  Brak kolekcji opcji lub opcji w bazie danych.';
                
            } else echo 'B³êdne parametry funkcji generate_radio_form. $sub_options nie jest tablic¹, lub nie podano nazwy kolekcji opcji.';
        }
        
        function generate_select_form( $option_collections, $option, $sub_options, $args ) {
            /**
                * Funkcja generuje formularz select na podstawie podanych w argumentach danych.
                * $option_collections  - kolekcja ustawieñ. W moim przypadku pole $page z add_section
                * $option              - ID pola ustawieñ z kolekcji, zdefiniowanego w add_section_field
                * $sub-options         - tablica podopcji. $sub_options = ( array( ID_podopcji , Opis podopcji ) )
                * $default_val         - wartoœæ domyœlna jaka ma byæ ustawiona.
                * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                */    
            
            if ( is_array($sub_options) && isset($option_collections) ){
                $options = get_option( $option_collections );
                
                if ( isset($options) && isset($options[$option]) ){
                    
                    //if (!isset($default_val)) $default_val = $sub_options[0];
                    //if (!isset($options[$option])) {
                    //    $options[$option] = $default_val;
                    //    update_option($option_collections, $options);
                    //}
                    
                    echo '<p> '  . $args[0] . '</p></br >';                  
                    echo '<select id="'.$option.'" name="'.$option_collections.'['.$option.']" />';    
                    
                    foreach ( $sub_options as $sub_option ){
                        $html = '<option value="'.$sub_option[0].'"' . selected($sub_option[0], $options[$option], false) . '>'.$sub_option[1].'</option>';
                        echo $html;
                    };           
                    
                    echo $html .= '</select>';
                } else echo 'B³êdne parametry funkcji generate_select_form.  Brak kolekcji opcji lub opcji w bazie danych.';
                
            } else echo 'B³êdne parametry funkcji generate_select_form. $sub_options nie jest tablic¹, lub nie podano nazwy kolekcji opcji.';
        }
        
        function generate_text_form( $option_collections, $option, $args ) {
            /**
                * Funkcja generuje formularz select na podstawie podanych w argumentach danych.
                * $option_collections  - kolekcja ustawieñ. W moim przypadku pole $page z add_section
                * $option              - ID pola ustawieñ z kolekcji, zdefiniowanego w add_section_field
                * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                */  
            if ( isset($option_collections) ){
                $options = get_option( $option_collections );
                
                if ( isset($options) && isset($options[$option]) ){                    
                    $html = '<input type="text" id="'.$option.'" name="'.$option_collections.'['.$option.']" value="' . $options[$option] . '" />'; 
                    $html .= '<label for="'.$option.'"> '  . $args[0] . '</label>'; 
                    
                    echo $html;
                } else echo 'B³êdne parametry funkcji generate_text_form.  Brak kolekcji opcji lub opcji w bazie danych.';
            } else echo 'B³êdne parametry funkcji generate_text_form. $sub_options nie jest tablic¹, lub nie podano nazwy kolekcji opcji.';    
        }
        
    #endregion
        
    #region #.# Walidacja danych
        
        function do_input_sanitize($input){
            /**
             * This function is called just before the data is written to the database. It allows you to process all the arguments just before saving them.  
             * Notice above that the callback accepts a single argument that we've named $input. This argument is the collection of options that exist for the social option sections. 
             */ 
            $output = array();
            
            foreach( $input as $key => $val ) {                
                if( isset ( $input[$key] ) ) {
                    $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
                }                
            }
            
            // Return the new collection
            return apply_filters( 'do_input_sanitize', $output, $input );             
        }
        
    #endregion
        
    #region #.# Domyœlna miniaturka
        function trc_print_thumbnail($post_id){
            if ( has_post_thumbnail($post_id) ){
                the_post_thumbnail('post-thumbnail', array( 'class' => 'op-desc-trigger', 'alt' => 'Miniaturka wpisu' )); 
            } else echo '<img class="op-desc-trigger" src="'.THEME_URL.'images/default.jpg" alt="Miniaturka wpisu" />';
        }
        
        function trc_get_thumbnail($post_id){
            if ( has_post_thumbnail($post_id) ){
                return get_the_post_thumbnail();
            } else return THEME_URL.'images/default.jpg';
        }
    #endregion
?>