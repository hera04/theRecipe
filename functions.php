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
    
?>