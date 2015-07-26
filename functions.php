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
        
    // #.# Pobranie banneru
        function get_banner(){
            get_template_part('banner');
            return true;
        }
        
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
        
        
    /* #.# Rejestrowanie strony ustawień || https://codex.wordpress.org/Settings_API
     * 1. Rejestracja ustawień strony - register_setting || https://codex.wordpress.org/Function_Reference/register_setting
     * 2. Action Hook - add_action (wywołanie strony ustawień)
     * 3. Formularz linkujący do options.php
     * 4. Rejestracja pól w formularzu ustawień - setting_fields || https://codex.wordpress.org/Function_Reference/settings_fields
     * 5. Przekazanie opcji z formularza z pomocą get_options || https://codex.wordpress.org/Function_Reference/get_option
     * 6. Powiązanie opcji ze stroną .php
     */      
    /*
        // 1:
        function trc_admin_init(){
            register_setting( 'trc_theme_options' , 'banner_status' );
        }
        // 2:
        add_action( 'admin_init', 'trc_admin_init' );
        
        function trc_settings_page(){ 
        ?>
            <div class="setting-wrapper" style="margin:auto; width:100%;">
                <?php screen_icon(); ?>
                <h1>Ustawienia szablonu theRecipe</h1>
                <form action="option.php" method="post" id="trc-options-form">
                    <?php settings_fields('trc_theme_options') // setting_fields przyjmuje jako argument nazwę grupy ustawień zadeklarowaną w rejestracji ustawień ?>

                    <!--<h3>
                        <label for="trc_banner_items">Ilość elementów w bannerze</label>
                        <input type="text" value="<?php echo esc_attr(get_option('trc_banner_setting'));?>" name="trc_banner_items" id="trc_banner_items" />
                    </h3>-->
                    <h2>Ustawienia bannera</h2>
                    <table class="form-table" style="margin-left:50px;">
                        <tbody>
                            <tr>
                                <th scope="row">Widoczność</th>
                                <td id="trc_banner_visibility">
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Widoczność</span></legend>
                                        <p>
                                           <label>
                                                <input type="checkbox" name="banner_status" id="banner_status" value="1"> Włącz banner
	                                       </label>
	                                    </p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Banner wyświetla</th>
                                <td id="trc_banner_items">
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Banner wyświetla</span></legend>
                                        <p>
                                           <label for="banner_items">Ilość wyświetlanych elementów: 
                                                <select id="banner_items" name="banner_items">
	                                                <option value="0">&mdash; Wybierz &mdash;</option>
	                                                <option value="3">3 elementy</option>
	                                                <option value="4">4 elementy</option>
                                                    <option value="3">5 elementów</option>
                                                </select>
                                            </label>
	                                    </p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Zawartość</th>
                                <td id="trc_banner_content">
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Zawartość</span></legend>
                                        <p>
                                            <label>
		                                        <input type="radio" value="search_bar" name="show_on_front" checked="checked" > Wyszukiwarka </br >
                                                <input type="radio" value="best_restaurants" name="show_on_front"> Najlepsze restauracje </br >
	                                        </label>
	                                    </p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Czas przejścia</th>
                                <td id="trc_banner_delay">
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Czas przejścia (ms)</span></legend>
                                        <p>
                                            <label>
		                                        <input type="text" name="move_delay" placeholder="(ms)">
	                                        </label>
	                                    </p>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <input type="submit" value="Zapisz" class="button" />
                </form>
            </div>
        <?php
        }
        
        function trc_settings_menu(){
            add_theme_page('theRecipe - Ustawienia','Szablon theRecipe', 'manage_options','trc_theme_options','trc_settings_page');
        }
        add_action('admin_menu','trc_settings_menu');
     */ 
?>

<?php

    #region Register Settings
    /* ------------------------------------------------------------------------ *
     * Register setting
     * ------------------------------------------------------------------------ */
    
    add_action('admin_init', 'trc_theme_options_init');
    function trc_theme_options_init() {
        
        /*  We need to make sure that our collection of options exists in the database. 
         *  To do this, we'll make a call to the get_option function. If it returns false, 
         *  then we'll add our new set of options using the add_option function.
         *  http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-4-on-theme-options--wp-24902
         */
            if( false == get_option( 'general_settings_options' ) ) {  
                add_option( 'general_settings_options' );
            }
        
        // See if the options exist, and initialize them if they don't
        $options = get_option('general_settings_options');
        if (!is_array($options)) {
            // replace "false" for "true" if you want the options to be checked by default
            $options = array("show_banner" => false, "select_content" => false, "number_of_items" => false);
            update_option('general_settings_options', $options);
        }
 
        add_settings_section(                   // Dodajemy sekcję ustawień (grupa ustawień) || https://codex.wordpress.org/Function_Reference/add_settings_section       
            'general_settings',                 // ID used to identify this section and with which to register options
            'Ustawienia szablonu theRecipe',    // Title to be displayed on the administration page
            'trc_general_settings_callback',    // Callback used to render the description of the section
            'general_settings_options'           // Page on which to add this section of options
        );
     
            add_settings_field(                     // Dodajemy pola ustawień || https://codex.wordpress.org/Function_Reference/add_settings_field
                'show_banner',                      // ID used to identify the field throughout the theme
                'Banner',                           // The label to the left of the option interface element
                'trc_show_banner_callback',         // The name of the function responsible for rendering the option interface
                'general_settings_options',         // The page on which this option will be displayed
                'general_settings',                 // The name of the section to which this field belongs
                array(                              // The array of arguments to pass to the callback. In this case, just a description.
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
     
        // Finally, we register the fields with WordPress
        //register_setting(
        //    'general_settings',
        //    'show_banner'
        //);
     
        //register_setting(
        //    'general_settings',
        //    'select_content'
        //);
     
        //register_setting(
        //    'general_settings',
        //    'number_of_items'
        //);
            
        register_setting(
            'general_settings_options',
            'general_settings_options'
        );
     
    }
    
    #endregion
    
    #region Callbacks
 
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
        
    #region Create Menu
    /* ------------------------------------------------------------------------ *
    * Section Create Menu - tworzymy tutaj menu strony ustawień
    * ------------------------------------------------------------------------ */
        
        function trc_create_menu_page() {
            add_menu_page(                      // https://codex.wordpress.org/Function_Reference/add_menu_page
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
        
        function trc_settings_page_display() { 
        ?>
            <!-- Create a header in the default WordPress 'wrap' container -->
            <div class="wrap">
 
                <!-- Add the icon to the page -->
                <div id="icon-themes" class="icon32"></div>
                <h2>Ustawienia motywu theRecipe</h2>
 
                <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
                <?php settings_errors(); ?>
 
                <!-- Create the form that will be used to render our options -->
                <form method="post" action="options.php"> 
                    <?php settings_fields( 'general_settings_options' );       // https://codex.wordpress.org/Function_Reference/settings_fields?>
                    <?php do_settings_sections( 'general_settings_options' );  // https://codex.wordpress.org/Function_Reference/do_settings_sections ?>         
                    <?php submit_button(); ?>
                    <!--<input type="submit" value="Zapisz" class="button" />-->
                </form>
 
            </div><!-- /.wrap -->
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

