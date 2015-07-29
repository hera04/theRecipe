<?php get_header(); ?>

    <!-- BANNER -->
    <?php
        $options = get_option('general_settings');
        if ($options['show_banner'] == '1') $is_banner = get_banner();   
        //if ( get_option('show_banner') == '1') $is_banner = get_banner();
    ?>

    <!-- MAIN CONTENT ----------------------------------------------------------------->
    <div class="site-content <?php if($is_banner) echo 'sc-static'; else echo 'sc-no-banner';?>" id="siteContent_?">
        
        <!-- Linki do portali społecznościowych -->
        <div class="social-media hide-for-small-only">
            <ul class="inline-list">
                <li><a href="http://www.facebook.pl"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
            </ul>
        </div>
        <!------------------------------------------------------------------->
        <!-- Sekcja wpisów -------------------------------------------------->
        <div class="row" style="text-align: justify;">

            <!-- Nagłówek strony -->
            <h1 style="padding-left: 10px;">
                <?php 
                    $is_searching = getQuerySingleParam('search');
                    if (isset($is_searching)) echo 'Wyniki wyszukiwania:'; else echo 'Zrecenzowane restauracje';
                ?>
            </h1>

            <!-- WPISY ------------------------------------------------------>
            <div class="large-8 column entrys">

                <!-- #region POZOSTAŁE WPISY -->
                
                <?php
                    /* 
                     * Filtrowanie danych. Proces ten zaorągla wyniki wyszukiwania.
                     * getQueryParams zwraca tablicę zawierającą wszystkie parametry wyszukiwania z linku.
                     */
                    $query_params = getQueryParams();
                    if(isset($query_params['search'])) {
						$query_params['post_title_like'] = $query_params['search'];
						unset($query_params['search']);
					}
				    $loop = new WP_Query($query_params);
			    ?>
        
                <!-- Wypisywaie wpisów -->
                <?php if($loop->have_posts()) :?>					
					<?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <section id="restaurant-<?php the_ID(); ?>" <?php post_class('entry'); ?> >
                            <div class="row">
                                <div class="medium-12 column op-wrapper">
                                    <!-- Nazwa restauracji -->
                                    <a href="#" class="left"><h3 class="site-titles"><?php the_title(); ?></h3></a>
                                    <h6 class="op-category right"><?php echo printRestaurantCategories($post->ID);?></h6>                                    
                                    <!-- Opis restauracji -->                                    
                                    <div class="medium-12 columns op-desc-wrapper" style="cursor: default">
                                        <div class="row">
                                            <?php $has_thumb = has_post_thumbnail($post->ID); ?>
                                            <?php 
                                                // Jeśli wpis ma miniaturkę, wyświetli ją zajmując połowę wrappera dla opisu, a jeśli nie ma miniaturki opis zajmuje całą szerokość.
                                                if($has_thumb) {
                                                    $wrapper_class = 'medium-6';
                                                    $excerpt_length = 170;
                                                    
                                                    // Wyświetlam miniaturkę
                                                    echo '<div class="medium-6 column">';
                                                    the_post_thumbnail('post-thumbnail', array( 'class'	=> 'op-desc-trigger'));
                                                    echo '</div>';
                                                } else {
                                                    $wrapper_class = 'medium-12';
                                                    $excerpt_length = 500;
                                                }
                                            ?>
                                            
                                            <!-- Opis posta -->
                                            <div class="<?php echo $wrapper_class; ?> column" style="cursor: default">
                                                <!-- Wypis -->
                                                <div class="row">
                                                    <div class="medium-12 column">
                                                        <h5>Na każdą okazję</h5>
                                                        <p><?php echo cutText(get_the_excerpt(),$excerpt_length); ?></p>
                                                    </div>
                                                </div>
                                                <!-- Odnośnik do posta i rating -->
                                                <div class="row">
                                                    <div class="medium-12 column right op-footer">
                                                        <div class="left">
                                                            <a href="<?php the_permalink(); ?>">Czytaj dalej...</a>
                                                        </div>
                                                        <div class="right op-rating">
                                                            <?php showRating($post->ID,'ranking',5); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </section>
                    <?php endwhile; ?>
                <?php else: ?>
                    <h4>Nie znaleziono postów </h4>
                <?php endif; ?>
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
            <!--------------------------------------------------------------->

            <!-- SIDEBAR - szukajka - komentarze - tagi --------------------->
            <?php get_sidebar('restaurants-archive'); ?>
            <!--------------------------------------------------------------->

        </div>
        <!------------------------------------------------------------------->
    </div>
    <!--------------------------------------------------------------------------------->
    <!-- MODALE I INFORACJE ----------------------------------------------------------->
        <!--<?php showInfo(); ?>-->
    <!--------------------------------------------------------------------------------->
    
<?php get_footer('archive'); ?>