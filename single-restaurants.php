<?php get_header(); ?>
    <?php the_post(); ?>
    
    <!-- #region Banner -->
    <?php
        $options = get_option('general_settings');
        if ($options['show_banner'] == '1') $is_banner = get_banner();   
        //if ( get_option('show_banner') == '1') $is_banner = get_banner();
    ?>
    <!-- #endregion -->

    <!-- #region MAIN CONTENT -->

    <div class="site-content <?php if($is_banner) echo 'sc-static'; else echo 'sc-no-banner';?>" id="siteContent_?">

        <!-- Linki do portali społecznościowych -->
        <?php get_template_part('social-links'); ?>

        <!-- Breadcrumbs -->
        <div class="row brc-wrapper hide-for-small-only">
            <div class="medium-12 column">
                <?php show_breadcrumbs('locations'); ?>        
            </div>
        </div>

        <!-- #region Content -->
        <div class="row" style="text-align: justify;  padding-top: 3%;">

            <!-- #region Główna zawartość -->
            <div class="large-8 column recipe">

                <!-- #region Informacje -->
                <div class="row ">
                    <div class="medium-12 column">

                        <!-- #region Tytuł -->
                        <h1 class="rc-title"><?php the_title(); ?></h1>
                        <h5 class="rc-author"><?php echo '@'.get_the_author().' | '.get_the_date('l, j F Y').' | '.get_the_time('G:i'); ?></h5>
                        <!-- #endregion -->
                        
                        <!-- #region Położnie -->
                        <div class="row">
                            <!-- Mapka -->
                            <div class="medium-8 column">
                                <img src="<?php echo THEME_URL; ?>images/restaurant-map.jpg" class="rc-main-image"/>
                            </div>
                            <!-- Dane adresowe -->
                            <div class="medium-4 column">
                                <?php $restaurant_fields = get_fields($post->ID); // http://www.advancedcustomfields.com/resources/get_fields/ ?>
                                <table class="rst-address-table">
                                    <tbody>
                                    <tr>
                                        <td><i class="fa fa-map-marker"></i></td>
                                        <td><?php echo $restaurant_fields['address']; ?> </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-phone"></i></td>
                                        <td><?php echo $restaurant_fields['telephone'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-clock-o"></i></td>
                                        <td><?php echo $restaurant_fields['opening_hours']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope-o"></i></td>
                                        <td><?php echo '<a href="mailto:'.$restaurant_fields['email'].'">'.$restaurant_fields['email'].'</a>' ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-globe"></i></td>
                                        <td><?php echo '<a href="'.$restaurant_fields['www'].'">'.$restaurant_fields['www'].'</a>' ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- #endregion -->

                    </div>
                </div>
                <!-- #endregion -->

                <!-- #region Recenzja restauracji -->
                <div class="row">
                    <div class="medium-12 column">
                        <h3 class="rc-subtitle">Recenzja</h3>
                        <div class="row">
                            <div class="medium-11 column medium-centered">

                                <?php the_content(); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #endregion -->

                <!-- #region Comments -->
                <div class="row">
                    <div class="medium-12 column">
                        <?php comments_template(); //Funkcja załaduje w to miejsce plik comments.php ?>
                    </div>
                </div>
                <!-- #endregion -->

            </div>
            <!-- #endregion -->

            <!-- #region Sidebar -->
                <?php //get_sidebar('restaurants'); ?>

            <div class="large-4 column recipe-side">

                <!-- Oceń przepis -->
                <div class="row">
                    <div class="medium-12 column">
                        <h3 style="font-weight:500;">Oceń restaurację:</h3>
                        <div class="row">
                            <div class="medium-11 column medium-centered rating">
                                <?php showRating($post->ID, true); ?>
                            </div>
                        </div>
                    </div>
                </div>                

            </div>

            <!-- #endregion -->

        </div>
        <!-- #endregion -->


    </div>

    <!-- #endregion -->
        
    <?php get_footer(); ?>