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
    // #.# Funkcje wyœwietlania taksonomii
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

    #region 1.Register Settings
    /* ------------------------------------------------------------------------ *
     * Register setting
     * ------------------------------------------------------------------------ */
    
    add_action('admin_init', 'trc_theme_options_init');
    function trc_theme_options_init() {
        
            /*  Sprawdzam czy kolekcja opcji general_settings_options istnieje w bazie danych.
            *   [ANG]
            *   We need to make sure that our collection of options exists in the database. 
            *   To do this, we'll make a call to the get_option function. If it returns false, 
            *   then we'll add our new set of options using the add_option function.
            *   http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-4-on-theme-options--wp-24902
            */
            if( false == get_option( 'general_settings_options' ) ) {  
                add_option( 'general_settings_options' );
            }
            
            /*
            * Funkcja zapobiega wyświetlaniu Warning: Illegal string offset 'type'.
            *  [ANG] See if the options exist, and initialize them if they don't
            */ 
            $options = get_option('general_settings_options');
            if (!is_array($options)) {
                // replace "false" for "true" if you want the options to be checked by default
                $options = array("show_banner" => true, "select_content" => false, "number_of_items" => false);
                update_option('general_settings_options', $options);
            }
 
        
            // #.1
            add_settings_section(                           
                'general_settings',                         // ID used to identify this section and with which to register options
                'Ustawienia szablonu theRecipe',            // Title to be displayed on the administration page
                'trc_general_settings_callback',            // Callback used to render the description of the section
                'general_settings_options'                  // Page on which to add this section of options
            );
     
            // #.2
                add_settings_field(                          
                    'show_banner',                          // ID used to identify the field throughout the theme
                    'Banner',                               // The label to the left of the option interface element
                    'trc_show_banner_callback',             // The name of the function responsible for rendering the option interface
                    'general_settings_options',             // The page on which this option will be displayed
                    'general_settings',                     // The name of the section to which this field belongs
                    array(                                  // The array of arguments to pass to the callback. In this case, just a description.
                        'Aktuwuj to ustawienie, aby móc używać bannera.'
                    )
                );
     
                add_settings_field( 
                    'select_content',                     
                    'Content',              
                    'trc_select_content_callback',  
                    'general_settings_options',                          
                    'general_settings',         
                    array(                              
                        'Wybierz zawartość, która będzie wyświetlana w bannerze:'
                    )
                );
     
                add_settings_field( 
                    'number_of_items',                      
                    'Numbef of items',               
                    'trc_number_of_items_callback',   
                    'general_settings_options',                          
                    'general_settings',         
                    array(                              
                        'Wybierz ilość elemetów w bannerze:'
                    )
                );
     
            // #.3
            register_setting( 'general_settings_options' , 'general_settings_options' );
     
    }
    
    #endregion
    
    #region 2. Callbacks
 
    #region Section Callbacks    
    /* ------------------------------------------------------------------------ *
     * Section Callbacks
     * ------------------------------------------------------------------------ */
 
        /**
         * Funkcja wypisuje krótki opis sekcji ustawień.     * 
         * Wywoływana z funkcji trc_theme_options_init() poprzez podanie parametru w funkcji add_settings_section.
         */
        function trc_general_settings_callback() {
            echo '<p>Wybierz ustawienia, które Cię interesują:</p>';
        }
        
    #endregion
 
    #region Field Callbacks        
    /* ------------------------------------------------------------------------ *
     * Field Callbacks
     * ------------------------------------------------------------------------ */
        
        /**
         * Funkcja renderuje checkbox dla opcji show_banner.
         * 
         * W get_option() jako argument podajemy id pola ustawień.
         * Na koniec dodaje label dla checkboxa, który znajduje się w tablicy z agrumentami w add_setting_field dla show_banner
         */ 
        function trc_show_banner_callback($args) {   
            
            //if (empty(get_option('show_banner'))) update_option( 'show_banner', 1);
            
            $options = get_option('general_settings_options');  
    
            // 2. We also access the show_header element of the options collection in the call to the checked() helper function        
            // 3. Next, we update the name attribute to access this element's ID in the context of the display options array
            $html = '<input type="checkbox" id="show_banner" name="general_settings_options[show_banner]" value="1" ' . checked(1, $options['show_banner'], false) . '/>'; 
            
            // Here, we'll take the first argument of the array and add it to a label next to the checkbox
            $html .= '<label for="show_banner"> '  . $args[0] . '</label>'; 
            
            echo $html;
     
        }    
        
        /**
         * Funkcja renderuje pola radio dla opcji select_content.
         */ 
        function trc_select_content_callback($args) {
            
            //if (empty(get_option('show_banner'))) update_option( 'show_banner', 1);
            
            $options = get_option('general_settings_options');  
            
            $html = '<input type="checkbox" id="select_content" name="general_settings_options[select_content]" value="1" ' . checked(1, $options['select_content'], false) . '/>'; 
            $html .= '<label for="select_content"> '  . $args[0] . '</label>'; 
            
            echo $html;
        }
        
        
        /**
         * Funkcja renderuje select dla opcji number_of_items.
         */ 
        function trc_number_of_items_callback($args) {
            
            //if (empty(get_option('show_banner'))) update_option( 'show_banner', 1);
            
            $options = get_option('general_settings_options');  
            
            $html = '<input type="checkbox" id="number_of_items" name="general_settings_options[number_of_items]" value="1" ' . checked(1, $options['number_of_items'], false) . '/>'; 
            $html .= '<label for="number_of_items"> '  . $args[0] . '</label>'; 
            
            echo $html;
        }
        
    #endregion
        
    #endregion
        
    #region 3. Create Menu
    /* ------------------------------------------------------------------------ *
    * Section Create Menu - tworzymy tutaj menu strony ustawień
    * ------------------------------------------------------------------------ */
        
        // 3.1
        function trc_create_menu_page() {
            add_menu_page(                      
                'Ustawienia theRecipe',         // The title to be displayed on the corresponding page for this menu
                'theRecipe',                    // The text to be displayed for this actual menu item
                'administrator',                // Which type of users can see this menu
                'trc_settings_page',            // The unique ID - that is, the slug - for this menu item
                'trc_settings_page_display',    // The name of the function to call when rendering the menu for this page
                ''                              // Default icon
                //'58'                          // The position in the menu order this menu should appear.
            );
            //add_submenu_page(
            //    'trc_settings_page',                // Register this submenu with the menu defined above
            //    'Opcje theRecipe',                  // The text to the display in the browser when this menu item is active
            //    'Opcje',                            // The text for this menu item
            //    'administrator',                    // Which type of users can see this menu
            //    'trc_options_page',                 // The unique ID - the slug - for this menu item
            //    'trc_options_submenu_page_display'  // The function used to render the menu for this page to the screen
            //);
        }
        add_action('admin_menu', 'trc_create_menu_page');
        
        // 3.2
        function trc_settings_page_display() { 
        ?>
            <div class="wrap">
 
                <h2>Ustawienia motywu theRecipe</h2>
 
                <<?php settings_errors(); ?>
 
                <form method="post" action="options.php"> 
                    <?php settings_fields( 'general_settings_options' );       // 3.2.2  ?>
                    <?php do_settings_sections( 'general_settings_options' );  // 3.2.3  ?>         
                    <?php submit_button(); ?>
                </form>
 
            </div>
        <?php
        }
        
        //function trc_options_submenu_page_display() { 
        //    // Create a header in the default WordPress 'wrap' container
        //    $html = '<div class="wrap">';
        //    $html .= '<h2>Opcje szablonu theRecipe</h2>';
        //    $html .= '</div>';
            
        //    // Send the markup to the browser
        //    echo $html; 
        //}
        
    #endregion
?>

