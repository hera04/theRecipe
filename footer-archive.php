    <!-- FOOTER ----------------------------------------------------------------------->
    <div class="site-content footer">
        <div class="row medium-collapse">
            <div class="medium-12 column">

                <!-- Na skróty ----------------------------------------------->
                <div class="row medium-collapse show-for-medium-up">
                    <div class="medium-12 column"> 

                        <?php
                            $restauracje = new WP_Query(array(
                                'post_type'     => 'restaurants',
                                'posts_per_page' => 4                                
                            ));
                        ?>

                        <?php
                            if ($restauracje->have_posts()) echo '<h3>Najnowsze przepisy w tej kategorii:</h3>';
                            while ($restauracje->have_posts()) : $restauracje->the_post(); 
                        ?>
                                <div class="small-6 large-3 column op-wrapper">
                                    <!-- Tytuł przepisu -->
                                    <a href="<?php the_permalink(); ?>"><h3 class="site-titles"><?php the_title(); ?></h3></a>
                                    <!-- Opis przepisu -->
                                    <div class="medium-12 op-desc-wrapper">
                                        <?php 
                                            // Jeśli post nie ma miniaturki - przypisujemy mu domyślną miniaturkę dla wpisu.
                                            if(has_post_thumbnail($post->ID))
                                                the_post_thumbnail('post-thumbnail', array( 'class'	=> 'op-desc-trigger'));
                                            else echo '<img class="op-desc-trigger" src="'.THEME_URL.'images/8.jpg" alt="Zdjęcie wpisu" />';
                                        ?>
                                        <div class="op-desc-to-show">
                                            <div class="medium-12 columns op-desc">
                                                <?php echo cutText(get_the_excerpt(),100); ?>
                                                <a class="right" href="<?php the_permalink(); ?>">Zobacz restaurację.</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Podtytuł i ocena przepisu -->
                                    <div class="medium-12 columns">
                                        <h5 class="left">Na każdą okazję</h5>
                                        <div class="right op-rating">
                                            <?php showRating($post->ID,'ranking',5); ?>
                                        </div>
                                    </div>
                                </div>

                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- O Autorze ----------------------------------------------->
                <div class="row ft-about">
                    <div class="medium-4 column hide-for-small-only">
                        <h5 class="ab-title">Lorem Ipsum</h5>
                        <p class="ab-desc">Sapien elit in malesuada semper mi, id sollicitudin urna fermentum.elit in malesuada semper mi, id sollicitudin urna fermentum.</p>
                    </div>
                    <div class="medium-4 column hide-for-small-only">
                        <h5 class="ab-title">Lorem Ipsum</h5>
                        <p class="ab-desc">Sapien elit in malesuada semper mi, id sollicitudin urna fermentum.elit in malesuada semper mi, id sollicitudin urna fermentum.</p>
                    </div>
                    <div class="medium-4 column">
                        <h5 class="ab-title">Lorem Ipsum</h5>
                        <p class="ab-desc">Sapien elit in malesuada semper mi, id sollicitudin urna fermentum.elit in malesuada semper mi, id sollicitudin urna fermentum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------------------------------------------------->
    
    <script src="<?php echo THEME_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo THEME_URL; ?>bower_components/foundation/js/foundation.min.js"></script>
    <script src="<?php echo THEME_URL; ?>js/main.js"></script>
    <script src="<?php echo THEME_URL; ?>js/app.js"></script>
</body>
</html>
