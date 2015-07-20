<!-- SIDEBAR - szukajka - komentarze - tagi ------------------ -->
<div class="large-4 column">
    <!-- Szukajka -->
    <div class="row">
        <div class="small-12 medium-8 medium-centered large-12 column">
            <h5>Wyszukiwarka</h5>
            <h3>Na co masz ochotę?</h3>
            <form>
                <!-- Szukaj po nazwie -->
                <div class="row">
                    <div class="large-12 columns">
                        <input type="text" placeholder="Szukaj" class="radius" />
                    </div>
                </div>

                <!-- Szukaj po kategorii -->
                <div class="row">
                    <div class="large-12 columns">
                        <input type="text" placeholder="Kategoria" class="radius" />
                    </div>
                </div>

                <!-- Szukaj po kategorii -->
                <div class="row">
                    <div class="large-12 columns">
                        <select class="radius">
                            <option value="husker">Husker</option>
                            <option value="starbuck">Starbuck</option>
                            <option value="hotdog">Hot Dog</option>
                            <option value="apollo">Apollo</option>
                        </select>
                    </div>
                </div>
                <!-- Button -->
                <div class="row">
                    <div class="large-12 columns">
                        <a href="#" style="width: 100%;" class=" button small text-center radius">
                            Default Button
                        </a>
                    </div>
                </div>
            </form>
            <p>Co masz w <a href="#" data-reveal-id="myModal">lodówce</a>?</p>
        </div>
    </div>

    <!-- Komentarze -->
    <section class="comments">
        <div class="row">
        <div class="small-12 medium-8 medium-centered large-12 column">
            <h3>
                <b>Najnowsze komentarze</b>
            </h3>

            <?php
            /* Sekcja odpowiedzialna za wypisywanie komentarzy. W naszym przypadku wypisujemy ostatnie 4 
            * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
                $recent_comms = fetchRecentComments(4);
                foreach ($recent_comms as $comment){
                    $date = new DateTime($comment->comment_date_gmt);
            ?>
                <div class="row">
                    <div class="medium-12 column comment-wrapper">
                        <a href="<?php echo esc_url( get_permalink($comment->ID)); ?>"><h5 class="site-titles cm-title"><?php echo cutText($comment->post_title,20); ?> <small> 1 komentarz</small></h5></a>
                        <p class="cm-description"><?php echo $comment->comment_content; ?></p>
                        <p class="left cm-date"><?php $date = date("F j, Y"); echo $date; ?></p>
                        <p class="right cm-author">~<?php echo $comment->comment_author; ?></p>
                    </div>
                </div>
            <?php 
                } //end foreach
            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */    
            ?>

        </div>
    </div>
    </section>
    <!-- Tagi -->
    <div class="show-for-large-up">
        TO JEST CHMURKA TAGÓW<br />
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.
    </div>
</div>
<!-- --------------------------------------------------------- -->