<?php
    // #.# Definiowanie sta�ych odpowiedzialnych za �cie�ki

        if (!defined('THEME_DIR')){ 
            define('THEME_DIR', get_theme_root().'/'.get_template().'/');   // �cie�ka do katalogu na dysku
        }
    
        if (!defined('THEME_URL')){
            define('THEME_URL', WP_CONTENT_URL.'/themes/'.get_template().'/');  // �cie�ka url do katalogu
        }
        
    
        
    // #.# �adowanie dodatk�w
        require_once THEME_DIR.'libs/posttypes.php';
        require_once THEME_DIR.'libs/utils.php';
        
    
        
    // #.# �adowanie wsparcia
        add_theme_support('post-thumbnails'); // wsparcie dla ikon wpisu
        add_theme_support('post-formats', array('gallery'));
        
        
        
    // #.# Funkcje wy�wietlania taksonomii
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
                    echo '<a href="'.get_term_link($term->slug, $term->taxonomy).'">'.$term->name.' </a>';
                }
                // Pobieranie zmiennej $msgs. Zmienna $msgs znajduje si� w utils.php i zawiera w sobie wszystkie informacje, b��dy itp
                // getMsgs()->addInfo('Taksonomia dodana');
            }
        }
        
    // #.#
    
?>