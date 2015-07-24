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
        
    
        
    // #.# £adowanie wsparcia
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
        }
        
        
    /* #.# Rejestrowanie strony ustawień || https://codex.wordpress.org/Settings_API
     * 1. Rejestracja ustawień strony - register_setting || https://codex.wordpress.org/Function_Reference/register_setting
     * 2. Action Hook - add_action (wywołanie strony ustawień)
     * 3. Formularz linkujący do options.php
     * 4. Rejestracja pól w formularzu ustawień - setting_fields || https://codex.wordpress.org/Function_Reference/settings_fields
     * 5. Przekazanie opcji z formularza z pomocą get_options || https://codex.wordpress.org/Function_Reference/get_option
     * 6. Powiązanie opcji ze stroną .php
     */ 
        // 1:
        function trc_admin_init(){
            register_setting( 'trc_theme_options' , array('banner_status',) );
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
?>