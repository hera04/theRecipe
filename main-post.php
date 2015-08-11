<div class="row main-post">
    <div class="medium-12 column">

        <!-- Data i Kategoria  -->
        <div class="medium-5 large-4 column show-for-medium-up mp-info">
            <h6><?php echo the_time('l').', '; echo the_date('j F'); ?></h6>
            <h3><?php printPostTypeName($post->ID); ?></h3>
        </div>

        <!-- Opis głównej wiadomości -->
        <div class="medium-12 column mp-desc-wrapper show-for-medium-up">
            <a href="<?php the_permalink() ?>"><h2 class="left"><?php the_title();?></h2></a>
            <p class="right">
                <?php echo cutText(get_the_excerpt(),300); ?>
                <br /><a class="right" href="<?php the_permalink() ?>">Zobacz wpis...</a>
            </p>
        </div>

                <!-- Pokazuj inny opis tylko dla małych ekranów -->
                <div class="show-for-small-only">
                    <h2><?php echo the_title(); ?></h2>                                            
                    <h6 class="op-category"><?php echo printPostTypeName($post->ID); echo printRestaurantCategories($post->ID);?></h6> 
                    <p><?php echo cutText(get_the_excerpt(),300); ?><a href="<?php the_permalink() ?>"> Zobacz wpis...</a></p>                                           
                </div>  
                                              
        <!-- Zdjęcie wiadomości -->
        <?php trc_print_thumbnail($post->ID); ?>

    </div>
</div>