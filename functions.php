<?php
    // #.# Definiowanie stałych odpowiedzialnych za ścieżki

        if (!defined('THEME_DIR')){ 
            define('THEME_DIR', get_theme_root().'/'.get_template().'/');   // Ścieżka do katalogu na dysku
        }
    
        if (!defined('THEME_URL')){
            define('THEME_URL', WP_CONTENT_URL.'/themes/'.get_template().'/');  // Ścieżka url do katalogu
        }
        
    
        
    // #.# Ładowanie dodatków
        require_once THEME_DIR.'libs/posttypes.php';
        require_once THEME_DIR.'libs/utils.php';
        
    
        
    // #.# Ładowanie wsparcia
        add_theme_support('post-thumbnails'); // wsparcie dla ikon wpisu
        add_theme_support('post-formats', array('gallery'));
        
    #region Display Taxonomy    
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
                    echo '<a href="'.get_term_link($term->slug, $term->taxonomy).'">'.$term->name.' </a>';
                }
                // Pobieranie zmiennej $msgs. Zmienna $msgs znajduje siê w utils.php i zawiera w sobie wszystkie informacje, b³êdy itp
                // getMsgs()->addInfo('Taksonomia dodana');
            }
        }
    #endregion
        
    // #.# Pobranie banneru
        function get_banner(){
            get_template_part('banner');
            return true;
        }
    
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
          
?>

<?php

    /* #.# Rejestrowanie strony ustawień || https://codex.wordpress.org/Settings_API || http://code.tutsplus.com/series/the-complete-guide-to-the-wordpress-settings-api--cms-624
     *  1. Register Settings:
     *      1.1: Dodanie sekcji ustawień || https://codex.wordpress.org/Function_Reference/add_settings_section       
     *      1.2: Dodanie opcji do sekcji ustawień || https://codex.wordpress.org/Function_Reference/add_settings_field
     *      1.3: Rejestraca ustawień (register_settings()) || https://codex.wordpress.org/Function_Reference/register_setting
     *  2. Callbacks functions
     *  3. Tworzenie menu ustawień
     *      3.1 Dodanie Strony ustawień || https://codex.wordpress.org/Function_Reference/add_menu_page || https://codex.wordpress.org/Function_Reference/add_theme_page || https://codex.wordpress.org/Function_Reference/add_plugin_page
     *      3.2 Funkcje wyświetlające interfejs ustawień
     *          3.2.1: Pamiętać o Formie
     *          3.2.2: https://codex.wordpress.org/Function_Reference/settings_fields
     *          3.2.3: https://codex.wordpress.org/Function_Reference/do_settings_sections
     */

    #region 1. Register Settings   
    
        #region Theme General Settings Init
        //Inicjowane są tutaj ustawienia i pola dla ogólnych ustawień szablonu.
        
        
            add_action('admin_init', 'trc_general_settings_init');
            function trc_general_settings_init() {
        
                #region Checking Options
                    /*  
                    * Sprawdzam czy kolekcja opcji general_settings istnieje w bazie danych i przypisanie wartości startowych.
                    */   
                    
                    if( false == get_option( 'general_settings' ) ) {  
                        add_option( 'general_settings' );
                        $options = array("show_banner" => true, "select_content" => 'search_bar', "number_of_items" => '3');
                        update_option('general_settings', $options);
                    }
                
                #endregion
            
                #region #.1 Add Settings
                    
                    add_settings_section(                           
                        'general_settings_section',                         // ID used to identify this section and with which to register options
                        'Ogólne ustawienia szablonu theRecipe',     // Title to be displayed on the administration page
                        'trc_general_settings_callback',            // Callback used to render the description of the section
                        'general_settings'                     // Page on which to add this section of options. Będzie to w następnych krokach kolekcja ustawień sekcji.
                    );
                
                        #region #.2 Add Fields
                    
                            add_settings_field(                          
                                'show_banner',                          // ID used to identify the field throughout the theme
                                'Pokazuj banner',                       // The label to the left of the option interface element
                                'trc_show_banner_callback',             // The name of the function responsible for rendering the option interface
                                'general_settings',                     // The page on which this option will be displayed
                                'general_settings_section',             // The name of the section to which this field belongs
                                array(                                  // The array of arguments to pass to the callback. In this case, just a description.
                                    'Aktywuj to ustawienie, aby móc używać bannera.'
                                )
                            );
     
                            add_settings_field( 
                                'select_content',                     
                                'Zawartość bannera',              
                                'trc_select_content_callback',  
                                'general_settings',                          
                                'general_settings_section',         
                                array(                              
                                    'Wybierz zawartość, która będzie wyświetlana w bannerze:'
                                )
                            );
     
                            add_settings_field( 
                                'number_of_items',                      
                                'Ilość elementów w bannerze',               
                                'trc_number_of_items_callback',   
                                'general_settings',                          
                                'general_settings_section',         
                                array(                              
                                    'Wybierz ilość elemetów w bannerze:'
                                )
                            );
                            
                        #endregion 
                
                #endregion
             
                #region #.3 Register Settings
                     
                    register_setting( 'general_settings' , 'general_settings' );    // w argumentach 'strona ustawień' zadeklarowana w $page w add_settings_section
                
                #endregion
            }
            
        #endregion
    
        #region Social Options Init
        //Inicjowane są tutaj ustawienia i pola dla ustawień społecznościowych.
        
        
            add_action('admin_init', 'trc_social_settings_init');
            function trc_social_settings_init() {
        
                #region Checking Options
                
                    if( false == get_option( 'social_settings' ) ) {  
                        add_option( 'social_settings' );
                        $options = array('facebook' => '', 'twitter' => '', 'google_plus' => '', 'instagram' => '', 'pinrest' => '');
                        update_option('social_settings', $options);
                    }
                    
                #endregion
        
                #region Add Settings
                    
                    add_settings_section(                           
                        'social_settings_section',                      // ID used to identify this section and with which to register options
                        'Ustawienia Social Media',              // Title to be displayed on the administration page
                        'trc_social_settings_callback',         // Callback used to render the description of the section
                        'social_settings'                  // Page on which to add this section of options
                    );
        
                        #region Add Fields
                            
                            add_settings_field(                          
                                'facebook',                         // ID used to identify the field throughout the theme
                                'Facebook',                         // The label to the left of the option interface element
                                'trc_facebook_callback',            // The name of the function responsible for rendering the option interface
                                'social_settings',             // The page on which this option will be displayed
                                'social_settings_section',                  // The name of the section to which this field belongs
                                array(                              // The array of arguments to pass to the callback. In this case, just a description.
                                    'Wpisz adres strony na Facebooku.'
                                )
                            );
                            add_settings_field(                          
                                'twitter',
                                'Twitter',
                                'trc_twitter_callback',
                                'social_settings',
                                'social_settings_section',
                                array(
                                    'Wpisz adres profilu na Twitterze.'
                                )
                            );
                            add_settings_field(                          
                                'google_plus',
                                'Google+',
                                'trc_google_plus_callback',
                                'social_settings',
                                'social_settings_section',
                                array(
                                    'Wpisz adres strony na Google+.'
                                )
                            );
                            add_settings_field(                          
                                'instagram',
                                'Instagram',
                                'trc_instagram_callback',
                                'social_settings',
                                'social_settings_section',
                                array(
                                    'Wpisz adres profilu na Instagramie.'
                                )
                            );
                            add_settings_field(                          
                                'pinrest',
                                'Pinrest',
                                'trc_pinrest_callback',
                                'social_settings',
                                'social_settings_section',
                                array( 
                                    'Wpisz adres profilu na Pinrest.'
                                )
                            );
                            
                        #endregion
        
                #endregion
        
                #region Register Settings
                            
                    register_setting( 'social_settings' , 'social_settings' );        
                    
                #endregion
            }
            
        #endregion
    
    #endregion
    
    #region 2. Callbacks
        
        #region Form Functions
            
            function generate_checkbox_form( $option_collections, $option, $args ){
                /**
                 * Funkcja generuje formularz checkbox na podstawie podanych w argumentach danych.
                 * $option_collections  - kolekcja ustawień. W moim przypadku pole $page z add_section
                 * $option              - ID pola ustawień zdefiniowanego w add_section_field
                 * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                 */ 
                if ( isset($option_collections) ){
                    $options = get_option($option_collections);
                    
                    if ( isset($options) && isset($options[$option]) ){
                        
                        $html = '<input type="checkbox" id="'.$option.'" name="'.$option_collections.'['.$option.']" value="1" ' . checked(1, $options[$option], false) . '/>'; 
                        $html .= '<label for="'.$option.'"> '  . $args[0] . '</label>';
                        echo $html;
                    } else echo 'Błędne parametry funkcji generate_checkbox_form';
                    
                } else echo 'Błędne parametry funkcji generate_checkbox_form';
            }
        
            function generate_radio_form( $option_collections, $option, $sub_options, $default_val, $args ){
                /**
                 * Funkcja generuje formularz Radio na podstawie podanych w argumentach danych.
                 * Jeśli nie jest włączona opcja show_banner - nie ma dostępu do zmiany ustawień zawartości banneru.
                 * $option_collections  - kolekcja ustawień. W moim przypadku pole $page z add_section
                 * $option      - ID pola ustawień zdefiniowanego w add_section_field
                 * $sub-options - tablica podopcji. $sub_options = ( array( ID_podopcji , Opis podopcji ) )
                 * $default_val - wartość domyślna jaka ma być ustawiona.
                 * $args        - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                 */ 
                
                if ( is_array($sub_options) && isset($option_collections)){
                    $options = get_option( $option_collections );
                    
                    if ( isset($options) && isset($options[$option]) ){
                        // Jeśli nie podano wartości domyślnej staje się nią pierwszy element sub_options.
                        if (!isset($default_val)) $default_val = $sub_options[0];
                        
                        // Ustawienie domyślnej wartości. Gdy tego nie ma, po włączeniu i wyłączeni banneru, nie ma domyślnej wartości podopcji.
                        // Problem powstaje przez to, że wyłączamy pola (disabled) i wartości nie wysyłają się do bazy danych.
                        if (!isset($options[$option])) {
                            $options[$option] = $default_val;
                            update_option($option_collections, $options);
                        }
                        
                        echo '<p> '  . $args[0] . '</p></br >';  
                        // Pętla tworzy obiekty typu Radio
                        foreach ( $sub_options as $sub_option ){
                            $html = '<input type="radio" id="'.$sub_option[0].'" name="general_settings['.$option.']" value="'.$sub_option[0].'"' . checked( $sub_option[0], $options[$option], false ) . disabled('', $options['show_banner'], false ) . '/>';
                            $html .= '<label for="'.$sub_option[0].'">'.$sub_option[1].'</label></br >';
                            echo $html;
                        };
                    } else echo 'Błędne parametry funkcji generate_radio_form';
                    
                } else echo 'Błędne parametry funkcji generate_radio_form';
            }
            
            function generate_select_form( $option_collections, $option, $sub_options, $default_val, $args ) {
                /**
                 * Funkcja generuje formularz select na podstawie podanych w argumentach danych.
                 * $option_collections  - kolekcja ustawień. W moim przypadku pole $page z add_section
                 * $option              - ID pola ustawień z kolekcji, zdefiniowanego w add_section_field
                 * $sub-options         - tablica podopcji. $sub_options = ( array( ID_podopcji , Opis podopcji ) )
                 * $default_val         - wartość domyślna jaka ma być ustawiona.
                 * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                 */    
                
                if ( is_array($sub_options) && isset($option_collections) ){
                    $options = get_option( $option_collections );
                    
                        if ( isset($options) && isset($options[$option]) ){
                    
                            if (!isset($default_val)) $default_val = $sub_options[0];
                    
                            if (!isset($options[$option])) {
                                $options[$option] = $default_val;
                                update_option($option_collections, $options);
                            }
                    
                            echo '<p> '  . $args[0] . '</p></br >';                  
                            echo '<select id="'.$option.'" name="'.$option_collections.'['.$option.']" '. disabled('', $options['show_banner'], false ) .'>';    
                    
                            foreach ( $sub_options as $sub_option ){
                                $html = '<option value="'.$sub_option[0].'"' . selected($sub_option[0], $options[$option], false) . '>'.$sub_option[1].'</option>';
                                echo $html;
                            };           
                    
                            echo $html .= '</select>';
                        } else echo 'Błędne parametry funkcji generate_select_form';
                        
                 } else echo 'Błędne parametry funkcji generate_select_form';
            }
            
            function generate_text_form( $option_collections, $option, $args ) {
                /**
                 * Funkcja generuje formularz select na podstawie podanych w argumentach danych.
                 * $option_collections  - kolekcja ustawień. W moim przypadku pole $page z add_section
                 * $option              - ID pola ustawień z kolekcji, zdefiniowanego w add_section_field
                 * $args                - argumenty przekazane z funkcji pierwotnej (np. label dla ustawienia )
                 */  
                
                $options = get_option( $option_collections );
                    
                if ( isset($options) && isset($options[$option]) ){                    
                    $html = '<input type="text" id="'.$option.'" name="'.$option_collections.'['.$option.']" value="' . $options['.$option.'] . '" />'; 
                    $html .= '<label for="'.$option.'"> '  . $args[0] . '</label>'; 
                    
                    echo $html;
                } else echo 'Błędne parametry funkcji generate_text_form'.$options.' '.$options[$option].'';
                
            }
            
        #endregion
 
        #region Section Callbacks 
        /**
        * Funkcje wypisują krótki opis dla danej sekcji ustawień. 
        * Wywoływana z funkcji trc_theme_options_init() poprzez podanie parametru w funkcji add_settings_section.
        */
       
            function trc_general_settings_callback() {
                echo '<p>Zmień ogólne ustawienia motywu:</p>';
            }
        
            function trc_social_settings_callback() {
                echo '<p>Podaj linki do portali społecznościowych:</p>';
            }
        
        #endregion
 
        #region Field Callbacks
        
            function trc_show_banner_callback($args) {  
                
                $option = array( 'show_banner' );
                generate_checkbox_form('general_settings','show_banner', $args );
            }    
            
            
            function trc_select_content_callback($args) { 
                $default_val = 'search_bar';               
                
                $sub_options = array(   
                    array('search_bar','Wyszukiwarka'), 
                    array('posts_bar','Ostatnie posty')
                );
                generate_radio_form('general_settings','select_content', $sub_options, $default_val, $args );
            }
            
            
            function trc_number_of_items_callback($args) {
                $sub_options = array(   
                    array( 3 , '3 elementy' ), 
                    array( 4 , '4 elementy' ),
                    array( 5 , '5 elementów' )
                );
                generate_radio_form('general_settings','number_of_items', $sub_options, 3 , $args );
            }
            
        
            function trc_facebook_callback($args) {                   
                generate_text_form('social_settings','facebook',$args);
            }
            function trc_twitter_callback($args) {                   
                generate_text_form('social_settings','twitter',$args);
            }
            function trc_google_plus_callback($args) {                   
                generate_text_form('social_settings','google_plus',$args);
            }
            function trc_instagram_callback($args) {                   
                generate_text_form('social_settings','instagram',$args);
            }
            function trc_pinrest_callback($args) {                   
                generate_text_form('social_settings','pinrest',$args);
            }
        
        #endregion
        
    #endregion
        
    #region 3. Create Setting Menu
        
        #region 3.1 Creating Menu Page
            
            function trc_create_menu_page() {
                add_menu_page(                      
                    'Ustawienia ogólne theRecipe',      // The title to be displayed on the corresponding page for this menu
                    'theRecipe',                        // The text to be displayed for this actual menu item
                    'administrator',                    // Which type of users can see this menu
                    'general_settings',                 // The unique ID - that is, the slug - for this menu item
                    'general_settings_display',         // The name of the function to call when rendering the menu for this page
                    ''                                  // Default icon
                );
                add_submenu_page(
                    'general_settings',                         // Register this submenu with the menu defined above
                    'Ustawienia portali społecznościowych',     // The text to the display in the browser when this menu item is active
                    'Społeczności',                             // The text for this menu item
                    'administrator',                            // Which type of users can see this menu
                    'social_settings',                          // The unique ID - the slug - for this menu item
                    'trc_social_settings_display'               // The function used to render the menu for this page to the screen
                );            
            }
            add_action('admin_menu', 'trc_create_menu_page');
        
        #endregion
        
        function general_settings_display() { 
        ?>
            <div class="wrap">
                <?php settings_errors(); ?>
                <form method="post" action="options.php"> 
                    
                    <?php settings_fields( 'general_settings' );       // 3.2.2  ?>
                    <?php do_settings_sections( 'general_settings' );  // 3.2.3  ?>
                          
                    <?php submit_button(); ?>
                </form>
 
            </div>
        <?php
        }
        
        function trc_social_settings_display() { 
        ?>
            <div class="wrap">
 
                <?php settings_errors(); ?>
                <form method="post" action="options.php"> 

                    <?php settings_fields( 'social_settings' ); ?>
                    <?php do_settings_sections( 'social_settings' ); ?>   
                          
                    <?php submit_button(); ?>
                </form>
 
            </div>
        <?php
        }
    #endregion
?>