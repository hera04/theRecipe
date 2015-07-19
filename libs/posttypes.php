<?php 
    /* Zbiór funkcji, które wykorzystam tylko w tym motywie.
     * Zawiera deklaracje customowych typów postów oraz taksonomii.
     * */
    
    /* #.# Rejestracja typow postów 
     * https://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    
        add_action('init','therecipe_init_posttypes');  /* action hook, który wywoła init */
        function therecipe_init_posttypes(){
        
                /* Rejestrujemy typ postu przepisy https://codex.wordpress.org/Function_Reference/register_post_type*/
                $recipes_args = array(
                    'labels' => array(
                        /* Tytuły w menu administracyjnym */
                        'name'               => 'Przepisy',
		                'singular_name'      => 'Przepisy',
		                'add_new'            => 'Dodaj nowy przepis',
		                'add_new_item'       => 'Dodaj nowy przepis',
		                'new_item'           => 'Nowy przepis',
		                'edit_item'          => 'Edytuj przepis',
		                'view_item'          => 'Zobacz przepis',
		                'all_items'          => 'Wszystkie przepisy',
		                'search_items'       => 'Szukaj w przepisach',
		                'parent_item_colon'  => '',
		                'not_found'          => 'Nie znaleziono żadnych przepisów',
		                'not_found_in_trash' => 'Nic nie ma w koszu'
                    ),
                    'public'=>true,                 // Typ posta będzie dostępny publicznie
                    'public_queryable'=> true,      // Czy można do niego wysyłać zapytanie
                    'show_ui'=> true,               // Pokazuj UI (przyciski/panele)
                    'query_var'=> true,             //  The query_var is used for direct queries through WP_Query like new WP_Query(array('people'=>$person_name)) and URL queries like /?people=$person_name. Setting query_var to false will disable these methods.
                    'rewrite'=> true,               // Automatyczne nadpisywanie adresów
                    'menu_icon' => 'dashicons-welcome-add-page',    // dodanie ikonki https://developer.wordpress.org/resource/dashicons/
                    'capability_type'=> 'post',
                    'hierarchical' => false,        // False, poniewaą posty nie są hierarchiczne jak np. strony
                    'menu_position' => 5,
                    'supports'=>array(
                        /**
                         * Jakie funkcjonalnoœci wspiera dany typ posta 
                         * Jeœli wejdziemy do panelu administracyjnego i włączymy 'opcje ekranu' zobaczymy wszystkie funkcjonalności danego typu postu.
                         * */
                        'title','editor','author','thumbnail','excerpt','comments','custom-fields','post-formats'
                    ),
                    'has_archive'=>true            // Czy ten typ postu będzie mial swoje własne archiwum
                );
            
                /* Rejestracja customowego typu postu */
                register_post_type('recipes', $recipes_args);
            
                /* Rejestrujemy typ postu food_fight */
                $food_fight_args = array(
                    'labels' => array(
                        /* Tytu³y w menu administracyjnym */
                        'name'               => 'Food Fight',
		                'singular_name'      => 'Food Fight',
		                'add_new'            => 'Dodaj nowy pojedynek',
		                'add_new_item'       => 'Dodaj nowy pojedynek',
		                'new_item'           => 'Nowy pojedynek',
		                'edit_item'          => 'Edytuj pojedynek',
		                'view_item'          => 'Zobacz pojedynek',
		                'all_items'          => 'Wszystkie pojedynki',
		                'search_items'       => 'Szukaj w pojedynkach',
		                'parent_item_colon'  => '',
		                'not_found'          => 'Nie znaleziono pojedynków',
		                'not_found_in_trash' => 'Nic nie ma w koszu'
                    ),
                    'public'=>true,
                    'public_queryable'=> true,
                    'show_ui'=> true,
                    'query_var'=> true,
                    'rewrite'=> true,
                    'menu_icon' => 'dashicons-image-flip-horizontal',
                    'capability_type'=> 'post',
                    'hierarchical' => false,
                    'menu_position' => 5,
                    'supports'=>array(
                        'title','editor','thumbnail','excerpt','custom-fields'
                    ),
                    'has_archive'=>true
                );
            
                /* Rejestracja customowego typu postu restaurants */
                register_post_type('food_fight', $food_fight_args);
                
                /* Rejestrujemy typ postu food_fight */
                $restaurants_args = array(
                    'labels' => array(
                        /* Tytuły w menu administracyjnym */
                        'name'               => 'Restauracje',
		                'singular_name'      => 'Restauracje',
		                'add_new'            => 'Dodaj nową restaurację',
		                'add_new_item'       => 'Dodaj nową restaurację',
		                'new_item'           => 'Nowa restauracja',
		                'edit_item'          => 'Edytuj restaurację',
		                'view_item'          => 'Zobacz restauracje',
		                'all_items'          => 'Wszystkie restauracje',
		                'search_items'       => 'Szukaj w restauracjach',
		                'parent_item_colon'  => '',
		                'not_found'          => 'Nie znaleziono restauracji',
		                'not_found_in_trash' => 'Nic nie ma w koszu'
                    ),
                    'public'=>true,
                    'public_queryable'=> true,
                    'show_ui'=> true,
                    'query_var'=> true,
                    'rewrite'=> true,
                    'menu_icon' => 'dashicons-store',
                    'capability_type'=> 'post',
                    'hierarchical' => true,
                    'menu_position' => 5,
                    'supports'=>array('title','editor','author','thumbnail','excerpt','comments','custom-fields','post-formats'),
                    'has_archive'=>true
                );
                
                /* Rejestracja customowego typu postu food_fight */
                register_post_type('restaurants', $restaurants_args);
        }
    
    /* #.# Rejestracja taksonomii 
     * https://codex.wordpress.org/Function_Reference/register_taxonomy
     * */
    
        add_action('init','therecipe_init_taxonomies');
        function therecipe_init_taxonomies(){
            register_taxonomy(
                'dessert_type',
                array('recipes'),
                array(
                    'hierarchical' => false,
                    'labels'=>array(
		                'name'                       => 'Rodzaj deseru',
		                'singular_name'              => 'Rodzaj deseru',
		                'search_items'               => 'Wyszukaj rodzaj deseru',
		                'popular_items'              => 'Popularne rodzaje deserów',
		                'all_items'                  => 'Wszystkie rodzaje deserów',
		                'parent_item'                => null,
		                'parent_item_colon'          => null,
		                'edit_item'                  => 'Edytuj rodzaj deseru',
		                'update_item'                => 'Aktualizuj rodzaj deseru',
		                'add_new_item'               => 'Dodaj nowy rodzaj deseru',
		                'new_item_name'              => 'Nazwa nowego rodzaju deseru',
		                'separate_items_with_commas' => 'Oddziel rodzaje deserów przecinkiem',
		                'add_or_remove_items'        => 'Dodaj lub usuń rodzaje wyrobów',
		                'choose_from_most_used'      => 'Wybierz z najczęsiej używanych rodzajów deserów',
		                'not_found'                  => 'Nie znaleziono żadnych rodzajów deserów',
		                'menu_name'                  => 'Rodzaj deseru'
                    ),
                    'show_ui'               => true,
		            'show_admin_column'     => true,
		            'update_count_callback' => '_update_post_term_count',   // Automatyczny callback (wywołanie zwrotne) - automatycznie po zapisaniu zostanie uruchomiona funkcja, któr¹ podamy w argumencie.
		            'query_var'             => true,
		            'rewrite'               => array( 'slug' => 'dessert_type' )    // Przypisywanie linków. Jeœli jest false to nie korzystamy z permalinków. Jeœli ustawimy slug to korzystamy z pretty urls za pomc¹ nazwy taksonomii np ..../product_type/...
                )
            );
        
            register_taxonomy(
                'ocassion',
                array('recipes'),
                array(
                    'hierarchical' => false,
                    'labels'=>array(
		                'name'                       => 'Okazja',
		                'singular_name'              => 'Okazja',
		                'search_items'               => 'Wyszukaj okazje',
		                'popular_items'              => 'Popularne okazje',
		                'all_items'                  => 'Wszystkie okazje',
		                'parent_item'                => null,
		                'parent_item_colon'          => null,
		                'edit_item'                  => 'Edytuj okazję',
		                'update_item'                => 'Aktualizuj okazję',
		                'add_new_item'               => 'Dodaj nową okazję',
		                'new_item_name'              => 'Nazwa nowej okazji',
		                'separate_items_with_commas' => 'Oddziel okazje przecinkiem',
		                'add_or_remove_items'        => 'Dodaj lub usuń okazje',
		                'choose_from_most_used'      => 'Wybierz z najczęściej używanych okazji',
		                'not_found'                  => 'Nie znaleziono okazji',
		                'menu_name'                  => 'Okazje'
                    ),
                    'show_ui'               => true,
		            'show_admin_column'     => true,
		            'update_count_callback' => '_update_post_term_count',   // Automatyczny callback (wywo³anie zwrotne) - automatycznie po zapisaniu zostanie uruchomiona funkcja, któr¹ podamy w argumencie.
		            'query_var'             => true,
		            'rewrite'               => array( 'slug' => 'ocassion' )    // Przypisywanie linków. Jeœli jest false to nie korzystamy z permalinków. Jeœli ustawimy slug to korzystamy z pretty urls za pomc¹ nazwy taksonomii np ..../product_type/...
                )
            );
            
            register_taxonomy(
                'ingredients',
                array('recipes'),
                array(
                    'hierarchical' => false,
                    'labels'=>array(
		                'name'                       => 'Składniki',
		                'singular_name'              => 'Składniki',
		                'search_items'               => 'Wyszukaj składniki',
		                'popular_items'              => 'Popularne składniki',
		                'all_items'                  => 'Wszystkie składniki',
		                'parent_item'                => null,
		                'parent_item_colon'          => null,
		                'edit_item'                  => 'Edytuj składnik',
		                'update_item'                => 'Aktualizuj składnik',
		                'add_new_item'               => 'Dodaj nową składnik',
		                'new_item_name'              => 'Nazwa nowego składnika',
		                'separate_items_with_commas' => 'Oddziel składniki przecinkiem',
		                'add_or_remove_items'        => 'Dodaj lub usuń składniki',
		                'choose_from_most_used'      => 'Wybierz z najczęściej używanych składników',
		                'not_found'                  => 'Nie znaleziono składników',
		                'menu_name'                  => 'Składniki'
                    ),
                    'show_ui'               => true,
		            'show_admin_column'     => true,
		            'update_count_callback' => '_update_post_term_count',   // Automatyczny callback (wywo³anie zwrotne) - automatycznie po zapisaniu zostanie uruchomiona funkcja, któr¹ podamy w argumencie.
		            'query_var'             => true,
		            'rewrite'               => array( 'slug' => 'ingredients' )    // Przypisywanie linków. Jeœli jest false to nie korzystamy z permalinków. Jeœli ustawimy slug to korzystamy z pretty urls za pomc¹ nazwy taksonomii np ..../product_type/...
                )
            );
            
            register_taxonomy(
                'location',
                array('restaurants'),
                array(
                    'hierarchical' => true,
                    'labels'=>array(
		                'name'                       => 'Położenie',
		                'singular_name'              => 'Położenie',
		                'search_items'               => 'Wyszukaj położenia',
		                'popular_items'              => 'Popularne położenia',
		                'all_items'                  => 'Wszystkie położenia',
		                'parent_item'                => null,
		                'parent_item_colon'          => null,
		                'edit_item'                  => 'Edytuj położenie',
		                'update_item'                => 'Aktualizuj położenie',
		                'add_new_item'               => 'Dodaj nowe położenie',
		                'new_item_name'              => 'Nazwa nowego położenia',
		                'separate_items_with_commas' => 'Oddziel położenia przecinkiem',
		                'add_or_remove_items'        => 'Dodaj lub usuń położenia',
		                'choose_from_most_used'      => 'Wybierz z najczęściej używanych położeń',
		                'not_found'                  => 'Nie znaleziono położeń'
                    ),
                    'show_ui'               => true,
		            'show_admin_column'     => true,
		            'update_count_callback' => '_update_post_term_count',   // Automatyczny callback (wywo³anie zwrotne) - automatycznie po zapisaniu zostanie uruchomiona funkcja, któr¹ podamy w argumencie.
		            'query_var'             => true,
		            'rewrite'               => array( 'slug' => 'locations' )    // Przypisywanie linków. Jeœli jest false to nie korzystamy z permalinków. Jeœli ustawimy slug to korzystamy z pretty urls za pomc¹ nazwy taksonomii np ..../product_type/...
                )
            );
        
        
        }
    /* ---------------------------------------------------------------- */
    
        
    
?>