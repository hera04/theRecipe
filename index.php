<?php get_header(); ?>

    <!-- #region big-banner -->
    <section class="cd-hero">

        <?php                   
            #region Settings
                $widget_options = get_option('general_settings');
                
                $post_limit = $widget_options['number_of_items'];
                
                $i = 0;
                
                $widget_query = new WP_Query( array(
                    'posts_per_page'    => $widget_options['number_of_items'],                                        
                    'orderby'           => 'post_date',                                 
                    'order'             => 'DESC',                                      
                    'post_type'         => array( 'restaurants', 'post', 'recipes' ),
                    'post_status'       => 'publish'
                ));
                    
            #endregion                    
        ?>

        <ul class="cd-hero-slider autoplay slider full-height">

            <?php
            
                if ( $widget_query -> have_posts() ) :
                    while ($widget_query -> have_posts() ) : $widget_query -> the_post(); ?>

                        <?php  $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );  // https://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src ?>

                        <li style="background-image: url(<?php echo $image_url[0] ?>);" class=" <?php if (i==0) echo 'selected'; ?> sl-item">
                            <div class="large-6 column" style="margin-top: 20%;">
                                <a href="<?php the_permalink(); ?>">                            
                                    <div class="sl-desc-wrapper">
                                        <h2 class="sl-desc-title"><?php the_title();?></h2>
                                        <p>
                                            <?php echo get_the_excerpt(); ?>
                                        </p>
                                    </div>                                    
                                </a>
                            </div>
                            <div class="mask"></div>
                        </li>

                        <?php
                        $i++;
                    endwhile;
                endif;
                wp_reset_query();        
            ?>

        </ul>

        <div class="search-bar search-bar-bottom">
            <form>
                <div class="row">
                    <div class="medium-10 columns">
                        <input type="text" placeholder="Na co masz ochotę?" class="radius search-form" />
                    </div>
                    <div class="medium-2 column">
                        <a href="#" class="button hide-for-large-up radius"><i class="fa fa-search"></i></a>
                        <a href="#" class="button show-for-large-up radius">Wyszukaj</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="cd-slider-nav sl-nav">
            <nav>
                <ul>
                    <?php for ( $i=0 ; $i< $post_limit ; $i++ ) :?>
                        <li class="<?php if ($i==0) echo 'selected'; ?>"><p><i class="fa fa-circle-thin"></i></p></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>

        
    </section>
    <!-- #endregion -->
 
    <!-- #region Main content -->
    <div class="site-content" id="siteContent">

        <?php get_template_part('social-links'); ?>

        <div class="row" style="text-align: justify;">
            <h1 style="padding-left:10px;">Najnowsze wpisy</h1>

            <!-- #region Posts -->
            <div class="large-8 column">
            <?php                   
                #region Settings
                    
                    $excerpt_length = 150;
                    
                    $parity = 0;                                                        // Zmienna która sprawdza parzystość. Wymagana w celu otwarcia i zamknięcia klasy 'row' dla pozostałych postów (wymóg Foundation) .
                    
                    $index_query = new WP_Query( array(
                        'posts_per_page'   => 7,                                        
                        'orderby'       => 'post_date',                                 
                        'order'         => 'DESC',                                      
                        'post_type'     => array( 'restaurants', 'post', 'recipes' ),
                        'post_status'   => 'publish',
                        'paged'         => $paged                                       // Przypisanie 'paged' zmiennej $paged, ponieważ domyślnie jest ustawiona tylko w stronach archiwum
                    ));
                    
                #endregion                    
            ?>
                <!-- #region Loop -->
                <?php
                    if ( $index_query -> have_posts() ) :
                        while ($index_query -> have_posts() ) : $index_query -> the_post();
                            ?>
                            <?php if ( ( ($paged == 0) || ($paged == 1) ) && ($parity == 0) ) : ?>
                                <!-- #region Main post-->
                                
                                 <div class="row">
                                    <div class="medium-12 column op-wrapper">

                                        <!-- Tytuł posta -->
                                        <div class="row" style="padding:0;">
                                            <div class="medium-12 column">
                                                <a href="<?php the_permalink();?>" class="left"><h3 class="site-titles"><?php the_title();?></h3></a>
                                                <h6 class="op-category right"><?php echo printPostTypeName($post->ID)?> <span class="label">Popularny!</span></h6>  
                                            </div>
                                        </div>

                                        <!-- Opis posta -->
                                        <div class="row">
                                            <!-- #region Miniaturka posta -->
                                            <?php 
                                                $has_thumb = has_post_thumbnail($post->ID);
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
                                            <!-- #endregion -->

                                            <!-- #region Opis posta -->
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
                                                            <div class="right rating">
                                                                <?php showRating($post->ID); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <!-- #endregion -->
                                        </div>  
                                        
                                        <!-- Statystyki i data -->
                                        <div class="row">
                                            <div class="medium-12 column">
                                                <div class="left"><i class="fa fa-comments-o"></i> <?php comments_number( '0 komentarzy', '1 komentarz', '% komentarzy' ); ?>  </div>
                                                <div class="right"><?php echo the_time('l').', '; echo the_date('j F'); ?></div>
                                            </div>                                           
                                        </div>                                                                        
                                                                            
                                    </div>
                                </div>

                                <!-- #endregion -->                
                            <?php else: ?>
                                <!-- #region Other Posts -->
                                    <?php
                                        /*
                                         * Sprawdzam tutaj kiedy otworzyć i zamknąć div z klasą 'row'. Foundation wymaga tego, aby kolumny w wierszu nie przekraczały ilości 12.
                                         * Ze względu na to, że jeden wpis zajmuje 6 kolumn, w jednym wieszu mogą być tylko 2 wpisy. Warunki poniżej sprawdzają:
                                         * a) Czy jesteśmy na stronie 0 lub 1. Jeśli tak - otwarcie div.row rozpoczynamy od 2 wpisu (dlatego $parity%2 == 1), ponieważ tylko na tej stronie mamy /GŁÓWNY POST/ i z nim muszą inaczej być otwierane/zamykane kalsy 'row'.
                                         * b) Czy jesteśmy na stronie !0 lub !1. Jeśli tak - wykonaj inne otwarcie/zamknięcie 'row'.
                                         */
                                        if (($paged == 0)||($paged == 1)) $first_page = true;
                                        
                                        $open_row = false;
                                            if ( ( $first_page && ($parity % 2 == 1)) || ( !$first_page && ($parity % 2 == 0)) ) $open_row = true;
                                        $close_row = false;
                                            if ( ( $first_page && ($parity % 2 == 0)) || ( !$first_page && ($parity % 2 == 1)) ) $close_row = true;
                                    ?>
                                    <?php if ( $open_row ) echo '<div class="row">'    // Otwarcie klasy 'row' co 2 wpisy. Wymóg Foundation, aby suma kolumn nie przekraczała 12. ?>
                                        <div class="medium-6 column op-wrapper">
                                            <!-- Tytuł przepisu -->
                                            <h6 class="op-category"><?php echo printPostTypeName($post->ID)?> <span class="label right">Popularny!</span></h6>
                                            <a href="<?php the_permalink(); ?>"><h3 class="site-titles"><?php the_title();?></h3></a>
                                            <!-- Opis przepisu -->
                                            <div class="medium-12 op-desc-wrapper">
                                                <?php 
                                                    trc_print_thumbnail($post->ID)
                                                ?>
                                                <div class="op-desc-to-show">
                                                    <div class="medium-12 columns op-desc">
                                                        <?php echo cutText(get_the_excerpt(),$excerpt_length); ?>
                                                        <a class="right" href="<?php the_permalink(); ?>">Zobacz przepis...</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Podtytuł i ocena przepisu -->
                                            <div class="medium-12 columns">
                                                <h5 class="left"><i class="fa fa-comments-o"></i> <?php comments_number( '0 komentarzy', '1 komentarz', '% komentarzy' ); ?></h5>
                                                <h5 class="right rating">
                                                    <?php showRating($post->ID); ?>
                                                </h5>
                                            </div>
                                        </div>  
                                    <?php if ( $close_row ) echo '</div>';              // Zamknięcie kalsy 'row'   ?> 
                                <!-- #endregion -->
                            <?php endif; ?>

                            <?php
                            $parity++;
                        endwhile;
                        if ( ( $first_page && (($parity-1) % 2 != 0)) || ( !$first_page && (($parity-1) % 2 != 1)) ) echo '</div>'; // Zabezpieczenie przed brakiem zamknięcia div.row gdy nie mamy 2 wpisów w jednym wierszu.
                    endif;
                    wp_reset_query();
                ?>
                <!-- #endregion -->

                <!-- #region Pagination -->                
                <div class="row">
                    <div class="medium-12 column text-center">
                        <div class="pagination-centered">
                            <?php
                                generatePagination(get_query_var('paged'),$recipes_query);                                
                            ?>                            
                        </div>
                    </div>
                </div>
                <!-- #endregion -->

            </div>
            <!-- #endregion -->

            <!-- #region Sidebar-->
            <?php get_sidebar( 'index' ); ?>
            <!-- #endregion -->

        </div>

    </div>
    <!-- #endregion -->

    <!-- #region Food Battle -->
    <div class="show-for-large-up battle-wrapper">
        <!-- Statystyki i opis wypieków -->
        <div class="medium-4 column medium-offset-4 bt-desc">
            <h1>MUFFINS BATTLE</h1>
            <p style="text-align: justify;">Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat. Ut fusce varius nisl ac ipsum gravida vel pretium tellus.</p>
            <table>
                <thead>
                    <tr>
                        <th>Babeczki</th>
                        <th>Babeczki</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>500 kcal</td>
                        <td>400 kcal</td>
                    </tr>
                    <tr>
                        <td>90 min</td>
                        <td>60 min</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel radius ingredients">
                jajka, woda, wanilia, mąka, cukier, truskawki, morele, mąka, masło, agrest, cukier puder
            </div>
        </div>
        <!-- Opis pierwszego wypieku -->
        <form action="#" method="post">
            <div class="opponent" style="background-image: url(<?php echo THEME_URL; ?>images/29.jpg);">
                <!-- Biała maska> -->
                <input type="submit" class="opp-trigger" value="" />
                <!-- Opis -->
                <div class="opp-desc" style="left: 0;">
                    <h2 class="opp-title" style="">Babeczki z pomidorami</h2>
                    Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida.
                </div>
            </div>
        </form>
        <!-- Opis drugiego wypieku -->
        <form action="#" method="post">
            <div class="opponent" style="background-image: url(<?php echo THEME_URL; ?>images/30.jpg);">
                <!-- Biała maska> -->
                <input type="submit" class="opp-trigger" value="" />
                <!-- Opis -->
                <div class="opp-desc" style="right: 0;">
                    <h2 class="opp-title" style="">Babeczki z pomidorami</h2>
                    Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida.
                </div>
            </div>
        </form>
    </div>
    <!-- #endregion -->

    <!-- #region Modals -->
    <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle">Awesome. I have it.</h2>
        <p class="lead">Your couch. It is mine.</p>
        <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- #endregion -->
    
<?php get_footer();?>