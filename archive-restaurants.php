<?php get_header(); ?>

    <!-- MAIN CONTENT ----------------------------------------------------------------->
    <div class="site-content" id="siteContent_?" style="margin-top: 75px;">

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
            <h1 style="padding-left: 10px;"><?php if( isset($_REQUEST['search']) ) echo 'Wyniki wyszukiwania:'; else echo 'Zrecenzowane restauracje'; ?></h1>
            <!-- WPISY ------------------------------------------------------>
            <div class="large-8 column entrys">
                <!-- POZOSTAŁE WPISY ---------------------------------------->
                <?php
				    $query_params = getQueryParams();
                    if(isset($query_params['search'])) {
						$query_params['post_title_like'] = $query_params['search'];
						unset($query_params['search']);
					}

				    $loop = new WP_Query($query_params);
			    ?>

                <?php if($loop->have_posts()) :?>					
					<?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <section id="restaurant-<?php the_ID(); ?>" <?php post_class('entry'); ?> >
                            <div class="row">
                                <div class="medium-12 column op-wrapper">
                                    <!-- Nazwa restauracji -->
                                    <a href="<?php the_permalink(); ?>" class="left"><h3 class="site-titles"><?php the_title(); ?></h3></a>
                                    <h6 class="op-category right"><?php echo printRestaurantCategories($post->ID);?></h6>                                    
                                    <!-- Opis restauracji -->                                    
                                    <div class="medium-12 columns op-desc-wrapper" style="cursor: default">
                                        <div class="row">
                                            <?php $has_thumb = has_post_thumbnail($post->ID); ?>
                                            <?php if($has_thumb):?>
                                                <div class="medium-6 column">
                                                    <?php the_post_thumbnail('post-thumbnail', array( 'class'	=> 'op-desc-trigger')); ?>
                                                </div>
                                            <?php endif;?>
                                            <div class="<?php if($has_thumb) echo 'medium-6'; else echo 'medium-12';?> column" style="cursor: default">
                                                <h5>Na każdą okazję</h5>
                                                <p><?php echo cutText(get_the_excerpt(),200); ?></p>
                                            </div>
                                            <div class="<?php if($has_thumb) echo 'medium-6'; else echo 'medium-12';?> column right op-footer">
                                                <div class="left">
                                                    <a href="<?php the_permalink(); ?>">Czytaj dalej...</a>
                                                </div>
                                                <div class="right op-rating">
                                                    <ul class="inline-list">
                                                        <?php showRating($post->ID,'ranking',5); ?>
                                                    </ul>
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
                <!----------------------------------------------------------->

                <!-- Paginacja -->
                <div class="row">
                    <div class="medium-12 column text-center">
                        <div class="pagination-centered">
                            <ul class="pagination">
                                <li class="arrow unavailable"><a href="">&laquo;</a></li>
                                <li class="current"><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">4</a></li>
                                <li class="unavailable"><a href="">&hellip;</a></li>
                                <li><a href="">12</a></li>
                                <li><a href="">13</a></li>
                                <li class="arrow"><a href="">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------------------------->
            <!-- SIDEBAR - szukajka - komentarze - tagi --------------------->
            <div class="large-4 column sidebar">
                <!-- Szukajka -->
                <div class="row">
                    <div class="small-12 medium-8 medium-centered large-12 column">
                        <h5>Wyszukiwarka</h5>
                        <h3 class="site-titles">Wyszukaj restauracje</h3>

                        <?php $search = getQuerySingleParam('search'); ?>
                        <form method="get" action="<?php current_page_url(); ?>">
                            <!-- Szukaj po nazwie -->
                            <div class="row">
                                <div class="large-12 columns">
                                    <input type="text" name="search" id="search" placeholder="<?php echo $search ?>" />
                                </div>
                            </div>                            
                            <!-- Button -->
                            <div class="row">
                                <div class="large-12 columns">
                                    <input type="submit" value="Szukaj" class="button tiny text-center radius" style="width: 100%;"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Ostatnio komentowane -->
                <div class="row">
                    <div class="small-12 medium-8 medium-centered large-12 column">
                        <!-- Tytuł przepisu -->
                        <h3 class="site-titles">Ostatnie komentarze</h3>
                        <ul class="example-orbit" data-orbit data-options="slide_number: false; bullets:false;">
                            <li class="active">
                                <div class="row">
                                    <div class="medium-11 column comment-wrapper medium-centered">
                                        <a href="#"><h5 class="site-titles cm-title">Herbata z owocami</h5></a>
                                        <p class="cm-description">
                                            <i class="fa fa-quote-left left"></i><br />
                                        <p class="cm-quote">
                                            Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat. Ut fusce varius nisl ac ipsum gravida vel(...)
                                        </p>
                                        <i class="fa fa-quote-right right"></i>
                                        </p>
                                        <p class="left cm-date">dzisiaj, 10:30</p>
                                        <p class="right cm-author">~andrzejek</p><br />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="medium-11 column comment-wrapper medium-centered">
                                        <a href="#"><h5 class="site-titles cm-title">Herbata z owocami</h5></a>
                                        <p class="cm-description">
                                            <i class="fa fa-quote-left left"></i><br />
                                        <p class="cm-quote">
                                            Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat. Ut fusce varius nisl ac ipsum gravida vel(...)
                                        </p>
                                        <i class="fa fa-quote-right right"></i>
                                        </p>
                                        <p class="left cm-date">dzisiaj, 10:30</p>
                                        <p class="right cm-author">~andrzejek</p><br />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="medium-11 column comment-wrapper medium-centered">
                                        <a href="#"><h5 class="site-titles cm-title">Herbata z owocami</h5></a>
                                        <p class="cm-description">
                                            <i class="fa fa-quote-left left"></i><br />
                                        <p class="cm-quote">
                                            Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat. Ut fusce varius nisl ac ipsum gravida vel(...)
                                        </p>
                                        <i class="fa fa-quote-right right"></i>
                                        </p>
                                        <p class="left cm-date">dzisiaj, 10:30</p>
                                        <p class="right cm-author">~andrzejek</p><br />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Ostatnio dodane wpisy -->
                <div class="row">
                    <div class="small-12 medium-8 medium-centered large-12 column">
                        <!-- Tytuł sekcji -->
                        <h3 class="site-titles">Ostatnio dodane wpisy</h3>
                        <!-- Zawartość sekcji -->
                        <div class="medium-12 column">
                            <ul class="example-orbit op-wrapper" data-orbit data-options="slide_number: false; bullets:false;">
                                <li>
                                    <div class="op-desc-wrapper">
                                        <img class="op-desc-trigger" src="<?php echo THEME_URL ?>images/8.jpg" alt="Zdjęcie wpisu" />
                                        <div class="op-desc-to-show">
                                            <div class="op-desc">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                <a class="right" href="#">Zobacz przepis...</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orbit-caption">
                                        Caption One.
                                    </div>
                                </li>
                                <li class="active">
                                    <div class="op-desc-wrapper">
                                        <img class="op-desc-trigger" src="<?php echo THEME_URL ?>images/9.jpg" alt="Zdjęcie wpisu" />
                                        <div class="op-desc-to-show">
                                            <div class="op-desc">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                <a class="right" href="#">Zobacz przepis...</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orbit-caption">
                                        Caption Two.
                                    </div>
                                </li>
                                <li>
                                    <div class="op-desc-wrapper">
                                        <img class="op-desc-trigger" src="<?php echo THEME_URL ?>images/7.jpg" alt="Zdjęcie wpisu" />
                                        <div class="op-desc-to-show">
                                            <div class="op-desc">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                <a class="right" href="#">Zobacz przepis...</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orbit-caption">
                                        Caption Three.
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Tagi -->
                <div class="row show-for-large-up">
                    <div class="small-12 medium-8 medium-centered large-12 column">
                        <!-- Tytuł przepisu -->
                        <h3 class="site-titles">Chmurka tagów</h3>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.
                    </div>
                </div>
            </div>
            <!--------------------------------------------------------------->

        </div>
        <!------------------------------------------------------------------->
    </div>
    <!--------------------------------------------------------------------------------->
    <!-- MODALE I INFORACJE ----------------------------------------------------------->
        <?php showInfo(); ?>
    <!--------------------------------------------------------------------------------->
    
    <?php get_footer('archive'); ?>