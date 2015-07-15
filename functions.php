<?php
    // #.# Definiowanie sta³ych odpowiedzialnych za œcie¿ki

        if (!defined('THEME_DIR')){ 
            define('THEME_DIR', get_theme_root().'/'.get_template().'/');   // Œcie¿ka do katalogu na dysku
        }
    
        if (!defined('THEME_URL')){
            define('THEME_URL', WP_CONTENT_URL.'/themes/'.get_template().'/');  // Œcie¿ka url do katalogu
        }
        
    // #.# £adowanie dodatków
        require_once THEME_DIR.'libs/posttypes.php';
        require_once THEME_DIR.'libs/utils.php';
    
?>