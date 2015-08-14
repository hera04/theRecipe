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

        <h3 class="rc-subtitle">Komentarze do przepisu: <small><?php comments_number( '0 komentarzy', '1 komentarz', '% komentarzy' );?></small></h3>

        <?php if ( !comments_open() ) : ?>
            
        <?php else: ?>

            <div class="small-12 medium-8 large-11 column large-centered">

                <div class="row comment_list">
                    
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

                    <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
                            
                        <p>Musisz się <a href="<?php wp_login_url(get_permalink()) ?>">zalogować</a></p>
                            
                    <?php else: ?>

                        <span style="padding: 10px 0;"><a href="#" data-reveal-id="addComent">Odpowiedz</a>.</span>

                        <div id="addComent" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="width:50%">

                            <?php
                                $is_reply = checkUrlSingleParam('replytocom');
                            
                                if ($is_reply):
                                    
                                    $parent_ID = get_comment($comment->comment_parent);
                                    //echo '<p class="panel">'.$parent_ID->comment_content.'</p>';
                                    ?>
                                    <script type="text/javascript">
                                        $(document).foundation();
                                        $(document).ready(function () { $('#addComent').foundation('reveal', 'open') });
                                    </script>
                                    <?php
                                endif;
                            ?>

                            <!--<form id="comment-form" method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php">-->

                                <?php
                                
                                    $commenter = wp_get_current_commenter();
                                    $req = get_option( 'require_name_email' );
                                    $aria_req = ( $req ? " aria-required='true'" : '' );
                                
                                    $fields =  array(
                                        'author' =>
                                          '<p class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
                                          ( $req ? '<span class="required">*</span>' : '' ) .
                                          '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                                          '" size="30"' . $aria_req . ' /></p>',

                                        'email' =>
                                          '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
                                          ( $req ? '<span class="required">*</span>' : '' ) .
                                          '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                                          '" size="30"' . $aria_req . ' /></p>',

                                        'url' =>
                                          '<p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
                                          '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                                          '" size="30" /></p>',
                                    );
                                    
                                    $args = array(
                                      'id_form'           => 'commentform',
                                      'id_submit'         => 'submit',
                                      'class_submit'      => 'button tiny right',
                                      'name_submit'       => 'submit',
                                      'title_reply'       => 'Odpowiedz na post.',
                                      'title_reply_to'    => 'Odpowiedz na komentarz %s: <blockquote class="cm-to-reply">'.$comment->comment_content.'</blockquote>',
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

                                      'comment_notes_before' => '<p class="comment-notes">' .
                                        __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
                                        '</p>',

                                      'comment_notes_after' => '',

                                      'fields' => apply_filters( 'comment_form_default_fields', $fields ),
                                    );
                                ?>

                                <?php comment_form( $args, $post->ID ); ?>

                            <!--</form>-->
                
                        </div>
                            
                    <?php endif; ?>

                     
                </div> 

            </div>
        
        <?php endif; ?> 

    </div>
</div>
