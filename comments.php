<<<<<<< HEAD
<?php
    if( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php'==basename($_SERVER['SCRIPT_FILENAME']) )
        die ('Nie możesz bezpośrednio uruchomić tego pliku');

    if (post_password_required()){
        echo 'Post jest chroniony hasłem. Wprowadź hasło aby zobaczyć komentarze.';
        return;
    }
    
    /* 
     * Ustawienie zmiennej, któa zajmuje się zliczaniem komentarzy na stronie.
     * Funkcja trc_comment_template korzysta z niej w celu wyświetlania numeró komentarzy.
     * */
    $comment_number = 0;
?>

<!-- Dodaj komentarz -->
<div class="row">
    <div class="medium-12 column comments">

        <h3 class="rc-subtitle">Komentarze do przepisu:</h3>

        <?php if ( !comments_open() ) : ?>
            
        <?php else: ?>

            <div class="small-12 medium-8 large-11 column large-centered">

                <div class="row comment_list">
                    
                    <a href="#"><h4 class="site-titles cm-title"><?php the_title(); ?> <small><?php comments_number( '0 komentarzy', '1 komentarz', '% komentarzy' );?></small></h4></a>

                    <!--<div class="comment">
                        <div style="font-size: 1.2em; color: #999;">#1</div>                            
                        <div class="parent inner">
                            <p class="cm-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                            <div class="cm-footer">
                                <p class="cm-date left">dzisiaj, 10:30 | <a href="#" data-reveal-id="addComent">Odpowiedz</a></p>
                                <p class="cm-author right">~andrzejek</p>
                            </div>
                        </div>
                    </div>-->
                                
                    <?php if( have_comments() ) :?>

                        <?php 
                            /*
                             * https://codex.wordpress.org/Function_Reference/wp_list_comments
                             * Trzeba pamiętać o tym, żeby nie zamykać znacznika komantarzu, ponieważ WP zrobi to sam.
                             * 
                             * https://codex.wordpress.org/Function_Reference/wp_list_comments
                             * https://codex.wordpress.org/Function_Reference/comment_form
                             * https://codex.wordpress.org/Function_Reference/wp_get_current_commenter
                             * */
                            wp_list_comments(array(
                                'callback'      => 'trc_comment_theme',
                                'style'         => 'div',
                                'reply_text'    => 'Odpowiedz',
                                'type'          => 'comment'
                            ));
                        ?>

                    <?php else: ?>
                        
                    <p>Wpis nie zawiera jeszcze żadnych komentarzy.</p>                        

                    <?php endif; ?>

                    

                </div> 
                
                <div class="row respond"> 

                    <header>
                        <h5><?php comment_form_title('Dodaj komentarz','Odpowiedz na komentarz: %s');?></h5>
                    </header>                           
                    
                    <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
                            
                        <p>Musisz się <a href="<?php wp_login_url(get_permalink()) ?>">zalogować</a></p>
                            
                    <?php else: ?>

                        <span style="padding: 10px 0;"><a href="#" data-reveal-id="addComent">Odpowiedz</a>.</span>

                        <div id="addComent" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="width:50%">

                            <h5><?php comment_form_title('Dodaj komentarz','Odpowiedz na komentarz: %s');?></h5>

                            <?php
                                $is_reply = checkUrlSingleParam('replytocom');
                            
                                if ($is_reply):
                                    
                                    $parent_ID = get_comment($comment->comment_parent);
                                    echo '<p class="panel">'.$parent_ID->comment_content.'</p>';
                                    ?>
                                    <script type="text/javascript">
                                        $(document).foundation();
                                        $(document).ready(function () { $('#addComent').foundation('reveal', 'open') });
                                    </script>
                                    <?php
                                endif;
                            ?>

                            <form id="comment-form" method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php">

                                <textarea name="comment" rows="5"></textarea>
                                <?php comment_id_fields(); ?>
                                <div class="left"><?php cancel_comment_reply_link('Anuluj odpowiedź.'); ?></div>
                                <button type="submit" class="button tiny right">Dodaj Komentarz</button>
                                <?php do_action('comment_form',$post->ID); ?>

                            </form>
                
                        </div>
                            
                    <?php endif; ?>

                     
                </div> 

            </div>
        
        <?php endif; ?> 

    </div>
</div>
=======
>>>>>>> parent of 333ad55... Działające komentarze
