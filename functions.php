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
        
    #region Ustawieni filtrów
    
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
        
        function printPostCategories($post_id, array $categories = array()){
            $terms_list = array();
            foreach($categories as $cname){
                $tmp = get_the_terms($post_id, $cname);
                if(is_array($tmp)){
                    $terms_list = array_merge($terms_list, $tmp);
                }
            }
            if($terms_list){
                foreach($terms_list as $term){
                    echo ' <a href="'.get_term_link($term->slug, $term->taxonomy).'">'.$term->name.' </a> ';
                }
            }
        }
        
        function printPostTypeName($post_id){
            $post_type = get_post_type($post_id);
            $post_type_name = get_post_type_object( $post_type )->labels->singular_name;
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            
            echo ' <a href="'.$post_type_archive_link.'">'.$post_type_name.' </a> ';
        }
        
    #endregion
        
    #region Register Sidebar
        // #.# Rejestrowanie sidebarów - https://codex.wordpress.org/Function_Reference/register_sidebar
        
        if(function_exists(register_sidebar)) {
            // Rejestrowanie sidebarów dla ró¿nych stron. Funkcja skleja wartoœci zmienne ($sidebar_list) z wartoœciami wspólnymi ($sidebar_opts) dla wszystkich.            
            $sidebar_list = array(
                array(
                    'name' => 'Restauracje (listing)',
                    'id' => 'restaurants-archive-widget',
                    'description' => 'Widgety w sidebarze w archiwum restauracji'
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
        
    // #.# Pobranie banneru
        function get_banner(){
            get_template_part('banner');
            return true;
        }
    
          
?>