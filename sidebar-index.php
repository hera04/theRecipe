<!-- SIDEBAR -->
<div class="large-4 column">
    
    <!-- #region Nawigacja przepisów -->

        <!-- Tytuł przepisu -->
        <h3 class="site-titles">Nawigacja</h3>

        <!-- Zawartość sekcji -->            
        <div class="row">
            <div class="small-12 medium-8 large-11 column right">
                <ul>
                <?php
                    $taxonomies_list = array('dessert_type');
                    foreach ( $taxonomies_list as $taxonomy ) :
                                
                        $args = array(
                            'orderby'           =>'name',
                            'hide_empty'        => false
                        ); 
                        $terms_list = get_terms($taxonomy,$args); // https://codex.wordpress.org/Function_Reference/get_terms
                                
                            foreach ($terms_list as $term ) :
                                $url = get_term_link( $term->slug,$term->taxonomy );
                                $name = $term->name;
                                ?>
                                    
                                    <li><a href="<?php echo $url; ?>"><?php echo $name; ?></a></li>

                                <?php
                            endforeach;  
                                
                    endforeach;                        
                ?>
                </ul>
            </div>
        </div>

    <!-- #endregion -->
    
    <!-- #region Ostatnio komentowane -->

        <!-- Tytuł -->
        <h3 class="site-titles">Ostatnie komentarze</h3>

        <!-- Zawartość sekcji -->
        <div class="row">
            <div class="small-12 medium-8 large-11 column right">
                <ul class="example-orbit comment-list" data-orbit data-options="slide_number: false; bullets:false;">
                    <?php 
                        $comment_active = 1;
                    
                        $recent_comments = get_comments(array(
                            'orderby'           => 'comment_date_gmt',
                            'number'            => 4,
                            'post_status'       => 'publish',
                            'status'            => 'approve'
                        ));
                    
                        if (!empty($recent_comments)) :
                    
                            foreach ($recent_comments as $comment) : 
                                $date = new DateTime($comment->comment_date); ?>

                                <li<?php ($comment_active==1) ? '' : 'class="active"'; ?>>                                
                        
                                    <div class="comment-parent">
                                        <div class="cm-title">
                                            <a href="<?php echo get_permalink($comment->ID); ?>"><h5 class="site-titles"><?php echo cutText($comment->post_title,20); ?></h5></a>
                                        </div>

                                        <div class="cm-text">
                                            <p><i class="fa fa-quote-left left"></i></p>
                                            <p style="margin:10px;"><?php echo cutText( $comment->comment_content,200 ); ?></p>
                                            <p><i class="fa fa-quote-right right"></i></p>
                                        </div>

                                        <div class="cm-footer">
                                            <p class="left"><?php $date = date("l, j F Y, H:i"); echo $date; ?></p>
                                            <p class="right">~<?php echo comment_author(); ?></p>
                                        </div>                                
                                    </div>
                                
                                </li>

                                <?php
                                $comment_active++;
                            endforeach;
                        else:
                            echo '<p>Nie ma żadnych komentarzy</p>';
                        endif;
                    ?>
                </ul>
            </div>
        </div>

    <!-- #endregion -->

    <!-- #region Ostatnio dodane wpisy -->

        <!-- Tytuł sekcji -->
        <h3 class="site-titles">Ostatnio dodane wpisy</h3>

        <!-- Zawartość sekcji -->
        <div class="row">
            <div class="small-12 medium-8 large-11 column right">

                <?php 
                    $last_posts = new WP_Query(array(
                        'posts_per_page'   => 3,                                        
                        'orderby'       => 'post_date',                                 
                        'order'         => 'DESC',                                      
                        'post_type'     => array( 'restaurants', 'post', 'recipes' ),
                        'post_status'   => 'publish'
                    ));
                ?>

                <ul class="example-orbit op-wrapper" data-orbit data-options="slide_number: false; bullets:false;">
                            <?php
                                if ( $last_posts -> have_posts() ) :
                                    while ($last_posts -> have_posts() ) :
                                        $last_posts -> the_post();
                                        ?>

                                        <li class="active">
                                            <div class="op-desc-wrapper">
                                                <?php trc_print_thumbnail($post->ID) ?>
                                        
                                            </div>
                                            <div class="orbit-caption">
                                                <a class="left" style="color:white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </div>
                                        </li>

                                        <?php
                                    endwhile;
                                endif;
                                wp_reset_query();
                            ?>
                        </ul>

            </div>
        </div>

    <!-- #endregion -->

</div>