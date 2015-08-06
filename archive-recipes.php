<?php get_header(); ?>

    <!-- Banner -->
    <?php
        $options = get_option('general_settings');
        if ($options['show_banner'] == '1') $is_banner = get_banner();
    ?>

    <!-- Główna zawartość -->
    <div class="site-content <?php if($is_banner) echo 'sc-static'; else echo 'sc-no-banner';?>" id="siteContent_?">
        
        <!-- Linki do portali społecznościowych -->
        <?php get_template_part('social-links'); ?>

        <!-- Wrapper wpisów -->
        <div class="row" style="text-align: justify;">

            <!-- #region Nagłówek strony -->
            <h1 style="padding-left: 10px;">
                <?php 
                    $is_searching = getQuerySingleParam('search');
                    if (isset($is_searching)) echo 'Wyniki wyszukiwania:'; else echo 'Wszystkie przepisy:';
                ?>
            </h1>
            <!-- #endregion -->

            <!-- #region Sekcja wpisów -->
            <div class="large-12 column entrys">

                <!-- #region POZOSTAŁE WPISY -->
                
                    <!-- #region Ustawienia -->
                    <?php
                    
                        $excerpt_length = 170;
                        $parity = 0;    // Zmienna która sprawdza parzystość. Wymagana w celu otwarcia i zamknięcia klasy 'row' dla pozostałych postów (wymóg Foundation) .
                
                        /* 
                         * Filtrowanie danych. Proces ten zaorągla wyniki wyszukiwania.
                         * getQueryParams zwraca tablicę zawierającą wszystkie parametry wyszukiwania z linku.
                         * 
                         * Tutaj nie dodajemy więcej atrybutów do WP_Query, ponieważ jeśli jesteśmy na stronie archiwów Wordpress sam wie jakie posty wyświetlić.
                         */
                        $query_params = getQueryParams();
                        if(isset($query_params['search'])) {
						    $query_params['post_title_like'] = $query_params['search'];
						    unset($query_params['search']);
					    }
				        $loop = new WP_Query($query_params);
			        ?>
                    <!-- #endregion -->
        
                    <!-- #region Wypisywaie wpisów -->
                    <?php if($loop->have_posts()) :?>	
                        <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                            <!-- #region Ustawienia szablonowania -->
                            <?php
                            /*
                            * Sprawdzenie otwarcia/zamknięcia div.row ponieważ Foundation wymaga tego, aby w jednym wierszu suma kolumn nie przekroczyła 12.
                            * Jako, że każda miniatura wpisu zajmje 4 kolumny, sprawdzam modulo 3.
                            * */
                            
                            $open_row = false;
                                if ( $parity % 3 == 0) {$open_row = true;}
                            $close_row = false;
                                if ( $parity % 3 == 2) {$close_row = true;}
                            
                            ?>
                            <!-- #endregion -->

                            <!-- #region Wpis -->
                            <?php if ( $open_row ) echo '<div class="row">'; ?>

                                <section id="recipe-<?php the_ID(); ?>" <?php post_class('entry'); ?> >
                                    <div class="medium-4 column op-wrapper">
                                        <!-- Tytuł przepisu -->
                                        <h6 class="op-category"><?php echo printPostTypeName($post->ID); ?></h6>
                                        <a href="<?php the_permalink(); ?>"><h3 class="site-titles"><?php the_title(); ?></h3></a>
                                        <!-- Opis przepisu -->
                                        <div class="medium-12 op-desc-wrapper">
                                            <?php trc_print_thumbnail($post->ID); ?>
                                            <div class="op-desc-to-show">
                                                <div class="medium-12 columns op-desc">
                                                    <?php echo cutText(get_the_excerpt(),$excerpt_length); ?>
                                                    <a class="right" href="<?php the_permalink(); ?>">Zobacz przepis...</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Podtytuł i ocena przepisu -->
                                        <div class="medium-12 columns">
                                            <h5 class="left">Na każdą okazję</h5>
                                            <h5 class="right rating">
                                                <?php showRating($post->ID); ?>
                                            </h5>
                                        </div>
                                    </div>  
                                </section>

                            <?php if ( $close_row ) echo '</div>'; ?>
                            <!-- #endregion -->

                            <?php $parity++; ?>

                        <?php endwhile; ?>
                        <?php if (  ((($parity-1) % 3) != 2)  ) echo '</div>'; // Zamyka div.row jeśli nie było na tyle postów, żeby zamknąć go w pętli. Inaczej: jeśli ostatnim postem w rzędzie był 1 lub 2 trzeba zamknąć div.row, poieważ w pętli zamyka się tylko gdy jest 3 post w rzędzie.?>
                    <?php else: ?>
                        <h4>Nie znaleziono postów </h4>
                    <?php endif; ?>
                    <!-- #endregion -->

                <!-- #endregion -->

                <!-- #region PAGINACJA -->                
                <div class="row">
                    <div class="medium-12 column text-center">
                        <div class="pagination-centered">
                            <?php
                                generatePagination(get_query_var('paged'),$loop);                                
                            ?>                            
                        </div>
                    </div>
                </div>
                <!-- #endregion -->
                
            </div>
            <!-- #endregion -->            

        </div>

    </div>
    
<?php get_footer('archive'); ?>