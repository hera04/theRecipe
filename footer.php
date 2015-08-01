<!-- FOOTER -------------------------------------------------------------------- -->
    <footer>
    <div class="site-content footer"  style="transform: translateY(-30px);">
        <div class="row medium-collapse">
            <div class="medium-12 column">
                <!-- Na skróty -------------------------------------------- -->
                <div class="row medium-collapse show-for-medium-up">
                    <div class="medium-12 column">

                        <?php
                        
                            $taxonomies_list = array('dessert_type');
                            foreach ( $taxonomies_list as $taxonomy ) :
                                
                                $args = array(
                                    'orderby'           =>'name',
                                    'hide_empty'        => false, 
                                    'number'            => 6 
                                ); 
                                $terms_list = get_terms($taxonomy,$args); // https://codex.wordpress.org/Function_Reference/get_terms
                                
                                    foreach ($terms_list as $term ) :
                                        $url = get_term_link( $term->slug,$term->taxonomy );
                                        $name = $term->name;
                                        ?>
                                        <div class="large-2 medium-4 column link-wrapper">
                                            <ul class="footer_link">
                                                <li class="ft-title"><a href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
                                                <?php
                                                
                                                    #region Loop Settings
                                                    /*
                                                    * WP_Query with taxonomy parameters https://codex.wordpress.org/Class_Reference/WP_Query#Taxonomy_Parameters
                                                    */
                                                        $args = array(
                                                            'post_type' => 'recipes',
                                                            'tax_query' => array(
                                                                array(
                                                                    'taxonomy' => $term->taxonomy,
                                                                    'field'    => 'slug',
                                                                    'terms'    => $term->name,
                                                                    'post_count' => 3
                                                                ),
                                                            ),
                                                        );
                                                        $query = new WP_Query( $args );                                        
                                                    #endregion
                                                    
                                                    if ( $query -> have_posts() ) :
                                                        while ($query -> have_posts() ) :
                                                            $query -> the_post();
                                                            ?>
                                                            <li><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></li>   
                                                            <?php                                                                
                                                        endwhile;                        
                                                    endif; 
                                                
                                                ?>
                                            </ul>
                                        </div>
                                        <?php
                                    endforeach;  
                                
                            endforeach;                        
                        ?>
                        
                    </div>
                </div>
                <!-- Stopka -------------------------------------------- -->
                <div class="row ft-about">

                    <!-- Chmurka tagów -->
                    <div class="medium-4 column hide-for-small-only">
                        <h5 class="ab-title">Chmurka tagów</h5>
                        <?php 
                            $args = array(
                                'taxonomy'  => array('dessert_type','locations'),
                                'smallest'  => '0.5',
                                'largest'   => '1.3',
                                'unit'      => 'em',
                                'number'    => 30,
                            );
                        ?>
                        <p class="ab-desc tag-cloud"><?php wp_tag_cloud($args); ?></p>
                    </div>
                    <!-- ------------- -->

                    <div class="medium-4 column">
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
    </footer>
    <!-- --------------------------------------------------------------------------- -->
    
    <script src="<?php echo THEME_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo THEME_URL; ?>bower_components/foundation/js/foundation.min.js"></script>
    <script src="<?php echo THEME_URL; ?>js/main.js"></script>
    <script src="<?php echo THEME_URL; ?>js/app.js"></script>
</body>
</html>
