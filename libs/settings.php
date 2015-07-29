<?php
    /* #.# Rejestrowanie strony ustawień || https://codex.wordpress.org/Settings_API || http://code.tutsplus.com/series/the-complete-guide-to-the-wordpress-settings-api--cms-624
     *  1. Rejestrowanie ustawień:
     *      1.1: Dodanie sekcji ustawień || https://codex.wordpress.org/Function_Reference/add_settings_section       
     *      1.2: Dodanie opcji do sekcji ustawień || https://codex.wordpress.org/Function_Reference/add_settings_field
     *      1.3: Sprawdzenie dostępności opcji oraz zainicjowanie wartości domyślnych
     *      1.3: Rejestraca ustawień (register_settings()) || https://codex.wordpress.org/Function_Reference/register_setting
     *  2. Callbacks functions
     *      2.1: Section callbacks
     *      2.2: Fields callback
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
        
                #region 1.1 Add Settings
                    
                    add_settings_section(                           
                        'general_settings_section',                         // ID used to identify this section and with which to register options
                        'Ogólne ustawienia szablonu theRecipe',     // Title to be displayed on the administration page
                        'trc_general_settings_callback',            // Callback used to render the description of the section
                        'general_settings'                     // Page on which to add this section of options. Będzie to w następnych krokach kolekcja ustawień sekcji.
                    );
                
                        #region 1.2 Add Fields
                    
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
             
                #region 1.3 Checking Options || Default Value
                /*  
                * Sprawdzam czy kolekcja opcji general_settings istnieje w bazie danych i przypisanie wartości startowych.
                * Ustawiam również tutaj wartości domyślne.
                */   
                            
                if( false == get_option( 'general_settings' ) ) {  
                    add_option( 'general_settings' );
                    $options = array("show_banner" => true, "select_content" => 'search_bar', "number_of_items" => '3');
                    update_option('general_settings', $options);
                }
                            
                #endregion
                            
                #region 1.4 Register Settings
                     
                    register_setting( 'general_settings' , 'general_settings' );    // w argumentach 'strona ustawień' zadeklarowana w $page w add_settings_section
                
                #endregion
            }
            
        #endregion
    
        #region Social Options Init
        //Inicjowane są tutaj ustawienia i pola dla ustawień społecznościowych.        
        
            add_action('admin_init', 'trc_social_settings_init');
            function trc_social_settings_init() {
        
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
                            
                #region Checking Options
                            
                if( false == get_option( 'social_settings' ) ) {  
                    add_option( 'social_settings' );
                    $options = array('facebook' => '', 'twitter' => '', 'google_plus' => '', 'instagram' => '', 'pinrest' => '');
                    update_option('social_settings', $options);
                }
                            
                #endregion
        
                #region Register Settings
                            
                register_setting( 'social_settings' , 'social_settings' );
                    
                #endregion
            }
            
        #endregion
    
    #endregion
    
    #region 2. Callbacks
            
        #region 2.1 Section Callbacks 
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
 
        #region 2.2 Field Callbacks
        
            function trc_show_banner_callback($args) {  
                
                $option = array( 'show_banner' );
                generate_checkbox_form('general_settings','show_banner', $args );
            }    
            
            
            function trc_select_content_callback($args) { 
                $sub_options = array(   
                    array('search_bar','Wyszukiwarka'), 
                    array('posts_bar','Ostatnie posty')
                );
                generate_radio_form('general_settings','select_content', $sub_options, $args );
            }
            
            
            function trc_number_of_items_callback($args) {
                $sub_options = array(   
                    array( 3 , '3 elementy' ), 
                    array( 4 , '4 elementy' ),
                    array( 5 , '5 elementów' )
                );
                generate_radio_form('general_settings','number_of_items', $sub_options, $args );
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