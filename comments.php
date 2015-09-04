<?php
    if( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php'==basename($_SERVER['SCRIPT_FILENAME']) )
        die ('Nie możesz bezpośrednio uruchomić tego pliku');

    if (post_password_required()){
        echo 'Post jest chroniony hasłem. Wprowadź hasło aby zobaczyć komentarze.';
        return;
    }
    
    /* 
     * Ustawienie zmiennej, któa zajmuje się zliczaniem komentarzy na stronie.
     * Funkcja trc_comment_template korzysta z niej w celu wyświetlania numerów komentarzy.
     * */
    $comment_number = 0;
?>

<!-- Dodaj komentarz -->
<div class="row" id="respond">
    <div class="medium-12 column comments">

        <h3 class="rc-subtitle">Komentarze do przepisu: <small><?php comments_number( '0 komentarzy', '1 komentarz', '% komentarzy' );?></small></h3>

        <?php if ( !comments_open() ) : ?>
            
        <?php else: ?>

            <div class="small-12 medium-11 column medium-centered">

                <div class="row comment-list">
                    
                     <?php if( have_comments() ) :?>

                        <?php 
                            /*
                             * https://codex.wordpress.org/Function_Reference/wp_list_comments
                             * Trzeba pamiętać o tym, żeby nie zamykać znacznika komantarza, ponieważ WP zrobi to sam.
                             * 
                             * https://codex.wordpress.org/Function_Reference/wp_list_comments
                             * https://codex.wordpress.org/Function_Reference/comment_form
                             * https://codex.wordpress.org/Function_Reference/wp_get_current_commenter
                             * */
                            wp_list_comments(array(
                                'callback'      => 'trc_comment_theme',
                                'style'         => 'div',
                                'reply_text'    => '<i class="fa fa-reply"></i>',
                                'type'          => 'comment'
                            ));
                        ?>

                    <?php else: ?>
                        
                    <p>Wpis nie zawiera jeszcze żadnych komentarzy.</p>                        

                    <?php endif; ?>

                    

                </div> 
                
                <div class="row"> 

                    <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
                            
                        <p>Musisz się <a href="<?php wp_login_url(get_permalink()) ?>">zalogować</a></p>
                            
                    <?php else: ?>

                        <span style="padding: 10px 0;"><a href="#" data-reveal-id="addComent"><?php comment_form_title('Dodaj komentarz','Kontynuuj odpowiadanie');?></a></span>

                        <div id="addComent" class="reveal-modal medium-10 column" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">

                            <?php
                                $is_reply = checkUrlSingleParam('replytocom');
                            
                                if ($is_reply):
                                    
                                    $parent_comment = get_comment($is_reply);
                                    
                                    ?>
                                    <script type="text/javascript">
                                        $(document).foundation();
                                        $(document).ready(function () { $('#addComent').foundation('reveal', 'open') });
                                    </script>
                                    <?php
                                endif;
                            ?>

                                <?php
                                
                                    $commenter = wp_get_current_commenter();
                                    $req = get_option( 'require_name_email' );
                                    $aria_req = ( $req ? " aria-required='true'" : '' );
                                
                                    $fields =  array(
                                        'author' =>
                                          '<p class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) .( $req ? '<span class="required">*</span>' : '' ).'</label> ' .
                                          '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                                          '" size="30"' . $aria_req . ' /></p>',

                                        'email' =>
                                          '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) .( $req ? '<span class="required">*</span>' : '' ). '</label> ' .
                                          '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                                          '" size="30"' . $aria_req . ' /></p>',

                                        'url' =>
                                          '<p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
                                          '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                                          '" size="30" /></p>',
                                    );
                                    
                                    $args = array(
                                      'id_form'           => 'commentform',
                                      'id_submit'         => 'submit-comment',
                                      'class_submit'      => 'button tiny right',
                                      'name_submit'       => 'submit',
                                      'title_reply'       => 'Odpowiedz na post.',
                                      'title_reply_to'    => 'Odpowiedz na komentarz %s: <blockquote class="cm-to-reply">'.$parent_comment->comment_content.'</blockquote>',
                                      'cancel_reply_link' => 'Anuluj odpowiedź',
                                      'label_submit'      => 'Wyślij komentarz',
                                      'format'            => 'xhtml',

                                      'comment_field' =>  '<textarea name="comment" rows="5" placeholder="Wpisz treść komentarza"></textarea>',

                                      'must_log_in' => '<p class="must-log-in">' .
                                        sprintf(
                                          __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
                                          wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
                                        ) . '</p>',

                                      'logged_in_as' => '<p class="logged-in-as">' .
                                        sprintf(
                                        __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
                                          admin_url( 'profile.php' ),
                                          $user_identity,
                                          wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
                                        ) . '</p>',

                                      'comment_notes_before' => '',

                                      'comment_notes_after' => '',

                                      'fields' => apply_filters( 'comment_form_default_fields', $fields ),
                                    );
                                ?>

                                <?php comment_form( $args, $post->ID ); ?>

                        </div>
                            
                    <?php endif; ?>

                     
                </div> 

            </div>
        
        <?php endif; ?> 

    </div>
</div>
