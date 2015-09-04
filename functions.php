<?php

    #region Definiowanie stałych

        if (!defined('THEME_DIR')){ 
            define('THEME_DIR', get_theme_root().'/'.get_template().'/');   // Ścieżka do katalogu na dysku
        }
    
        if (!defined('THEME_URL')){
            define('THEME_URL', WP_CONTENT_URL.'/themes/'.get_template().'/');  // Ścieżka url do katalogu
        }
        
     #endregion      
        
    #region Ładowanie dodatków
        
        require_once THEME_DIR.'libs/posttypes.php';
        require_once THEME_DIR.'libs/utils.php';    
        require_once THEME_DIR.'libs/settings.php'; // Strona generująca ustawienia
        
    #endregion    
    
    #region Ładowanie wsparcia
        
        add_theme_support('post-thumbnails'); // wsparcie dla ikon wpisu
        add_theme_support('post-formats', array('gallery'));
        
    #endregion          
        
    #region Ustawienia filtrów
    
        // https://codex.wordpress.org/Function_Reference/wpautop
        add_filter ('the_content', 'wpautop');

        ////disable wptexturize
        //remove_filter('the_content', 'wptexturize');
        
    #endregion
        
    #region Raportowanie błędów / informacji / przypomnień
        // https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices

        function my_admin_error_notice() {
            $class = 'error';
            $message = 'Error in saving';
            echo '<div class="'.$class.'" ><p>'.$message.'</p></div';
        }
        // add_action( 'admin_notices', 'my_admin_error_notice' ); 
        
    #endregion
    
    #region Wyświetlanie taksonomii  
        // #.# Funkcje wyświetlania taksonomii
        
        function printRestaurantCategories($post_id) {
            printPostCategories($post_id, array('locations'));
        }
        
        function printPostCategories($post_id, array $categories = array(), $list = false){
            /*
             * Funkcja wypisuje na ekranie nazwy wszystkich taksonomii przynależących do danego wpisu.
             * $list - domyślnie wypisuje nazwy tylko jako linki, jeśli $list == true wypisuje linki jako elementy <li>
             */
            $terms_list = array();
            foreach($categories as $cname){
                $tmp = get_the_terms($post_id, $cname);
                if(is_array($tmp)){
                    $terms_list = array_merge($terms_list, $tmp);
                }
            }
            if($terms_list){
                $terms_list = array_reverse($terms_list, true);
                foreach($terms_list as $term){
                    if ($list) echo '<li>';
                        echo ' <a href="'.get_term_link($term->slug, $term->taxonomy).'">'.$term->name.' </a> ';
                    if ($list) echo '</li>';
                }
            }
        }
        
        function printPostTypeName($post_id, $list = false){
            /*
             * Funkcja wypisuje na ekranie nazwę typu postu.
             * $list - domyślnie wypisuje nazwy tylko jako linki, jeśli $list == true wypisuje linki jako elementy <li>
             */
            $post_type = get_post_type($post_id);
            $post_type_name = get_post_type_object( $post_type )->labels->singular_name;
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            
            if ($list) echo '<li>';
                echo '<a href="'.$post_type_archive_link.'">'.$post_type_name.'</a>';
            if ($list) echo '</li>';
        }
        
    #endregion
        
    #region Breadcrumbs
        
        function show_breadcrumbs($taxonomy){
            global $post; // Dostęp do aktualnie wyświetlanego posta
            
            $current_page = current_page_url();
            
            echo '<ul class="breadcrumbs brc-list">';
            echo '<li><a href="'.home_url().'">Strona Główna</a></li>';
            printPostTypeName($post, true);
            printPostCategories($post, array($taxonomy), true);
            echo '<li class="current"><a>'.get_the_title().'</a></li>';
            echo '</ul>';
        }
        
    #endregion
        
    #region Register Sidebar
        // #.# Rejestrowanie sidebarów - https://codex.wordpress.org/Function_Reference/register_sidebar
        
        if(function_exists(register_sidebar)) {
            // Rejestrowanie sidebarów dla różnych stron. Funkcja skleja wartości zmienne ($sidebar_list) z wartościami wspólnymi ($sidebar_opts) dla wszystkich.            
            $sidebar_list = array(
                // Rejestracja sidebaru w archiwum restauracji
                array(
                    'name' => 'Restauracje (listing)',
                    'id' => 'restaurants-archive-widget',
                    'description' => 'Widgety w sidebarze w archiwum restauracji'
                ),
                // Rejestracja sidebaru w pojedynczym wpisie retauracji
                array(
                    'name' => 'Restauracja (wpis)',
                    'id' => 'restaurants-widget',
                    'description' => 'Widgety w sidebarze wpisu Restauracji.'
                )
            );
            
            $sidebar_opts = array(
                'before_widget' => '<div id="%1$s" class="row widget %2$s"><div class="small-12 medium-8 medium-centered large-12 column">',
                'after_widget' => '</div></div>',
                'before_title' => '<h3 class="site-titles">',
                'after_title' => '</h3>'
            );
            
            foreach($sidebar_list as $sidebar) {
                register_sidebar(array_merge($sidebar, $sidebar_opts));
            }
        };
    #endregion   
        
    #region Ingridients
        
        function getIngredients($post_id){
            
            $ingredients_table = array();
            $ingredients_list = (string)get_post_meta($post_id,'ingredients',true);
            
            if ( isset($ingredients_list) && !empty($ingredients_list) ){
                $ingredients = explode("\n",trim($ingredients_list));
                foreach ($ingredients as $ingredient){
                    $ingredients_table[] = $ingredient;            
                }
            } else return 0;
            
            return $ingredients_table;
        }
        
        function printIngredients($post_id){
            echo '<div class="panel">';
                echo '<ul>';
            
                $ingredients = getIngredients($post_id);
                if ( $ingredients ){
                    foreach ($ingredients as $ingredient){
                        echo '<li>'.$ingredient.'</li>';
                    }
                } else echo '<li>Brak składników!</li>';
            
                echo '</ul>';
            echo '</div>';
            
        }
        
    #endregion
        
    #region Print Comments
        
        function trc_comment_theme($comment, $args, $depth){
            /*
             * $comment - tablica komentarzy
             * $args - argumenty komentarzy
             * $depth - sposób zagnieżdżenia komentarzy
             * 
             * https://codex.wordpress.org/Function_Reference/comment_class
             * */
            
            $GLOBALS['comment'] = $comment;                 // Globalny obiekt kometarza
            $tag = $args['style'];
            
            $is_parent = false;
            //if ( !empty($args['has_children']) ) $is_parent = true;
            if ( $depth == 1 ) $is_parent = true;
            
            global $comment_number;
            if ($is_parent) $comment_number++;
            
        ?>

            <<?php echo $tag ?> class="comment <?php if ( $is_parent ) echo 'comment-parent' ?>">
                <div class="cm-author">
                    <?php 
                        if ( $is_parent ) echo '#'.$comment_number.' '; 
                        echo '~'.get_comment_author();
                    ?>
                </div>
                <div class="inner">
                    <p class="cm-text">
                        <?php  
                            //echo '<p>'.var_dump($args).'</p>';
                            //echo '<p>'.var_dump($comment).'</p>';
                            //echo '<p>'.$depth.'</p>';
                            //echo '<p>'.$comment_number.'</p>';
                                  
                            echo get_comment_text();
                            if ( $comment->comment_approved == '0' )
                                echo '
                                <div data-alert class="alert-box info">
                                    Twój komentarz oczekuje na moderację.
                                    <a href="#" class="close">&times;</a>
                                </div>';
                        ?>
                    </p>
                    <div class="cm-footer">
                        <p class="left"><?php echo get_comment_date().','.get_comment_time() ?></p>
                        <p class="right"><?php comment_reply_link( array_merge($args, array('depth'=>$depth, 'max_depth'=>$args['max_depth']) ) ); ?></p>
                    </div>
                </div>
            <?php // </div> Pamiętać o nie zamykaniu ostatniego div'a ponieważ WP zrobi to automatycnie. ?>

        <?php
        }
        
    #endregion
        
    // #.# Pobranie banneru
        function get_banner(){
            get_template_part('banner');
            return true;
        }
    
          
?>