<?php get_header(); ?>
    <?php the_post(); ?>
    
    <!-- #region Banner -->
    <?php
        $options = get_option('general_settings');
        if ($options['show_banner'] == '1') $is_banner = get_banner();
    ?>
    <!-- #endregion -->

    <!-- #region Content wrapper -->
    <div class="site-content <?php if($is_banner) echo 'sc-static'; else echo 'sc-no-banner';?>" id="siteContent_?">

        <!-- Linki do portali społecznościowych -->
        <?php get_template_part('social-links'); ?>

        <!-- #region Breadcrumbs -->
        <div class="row brc-wrapper hide-for-small-only">
            <div class="medium-12 column">
                <?php show_breadcrumbs('dessert_type'); ?>        
            </div>
        </div>
        <!-- #endregion -->

        <!-- #region Main content -->
        <div class="row" style="text-align: justify;  padding-top: 3%;">

            <!-- #region Content -->
            <div class="large-8 column recipe">

                <!-- #region Informations -->
                <div class="row ">
                    <div class="medium-12 column">

                        <!-- #region Title -->
                        <h1 class="rc-title"><?php the_title(); ?></h1>
                        <h5 class="rc-author"><?php echo '@'.get_the_author().' | '.get_the_date('l, j F Y').' | '.get_the_time('G:i'); ?></h5>
                        <!-- #endregion -->
                        
                        <!-- #region Description -->
                        <div class="row">
                            <!-- Miniaturka przepisu -->
                            <div class="medium-8 column">
                                <?php trc_print_thumbnail($post->ID); ?>
                            </div>

                            <!-- Szybki przegląd -->
                            <div class="medium-4 column">
                                <p>Szybki przegląd:</p>

                                <?php $recipe_fields = get_fields($post->ID); // http://www.advancedcustomfields.com/resources/get_fields/ ?>
                                <table class="rc-review-table">
                                    <tbody>
                                    <tr title="Kalorie">
                                        <td style="text-align:center;"><i class="fa fa-balance-scale"></i></td>
                                        <td><?php echo $recipe_fields['kcal']; ?> kcal</td>
                                    </tr>
                                    <tr title="Czas przygotowania">
                                        <td style="text-align:center;"><i class="fa fa-clock-o"></i></td>
                                        <td><?php echo $recipe_fields['preparation_time'] ?></td>
                                    </tr>
                                    <tr title="Trudność">
                                        <td style="text-align:center;"><i class="fa fa-level-up"></i></td>
                                        <td><?php echo $recipe_fields['difficulty']; ?></td>
                                    </tr>
                                    <tr title="Porcje">
                                        <td style="text-align:center;"><i class="fa fa-cutlery "></i></td>
                                        <td><?php echo $recipe_fields['servings']; ?></td>
                                    </tr>
                                    <tr title="Koszt">
                                        <td style="text-align:center;"><i class="fa fa-money "></i></td>
                                        <td><?php echo $recipe_fields['cost']; ?></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <span style="padding: 10px 0;">Wydrukuj <a href="#" data-reveal-id="printList">listę zakupów</a>.</span>
                            </div>

                        </div>
                        <!-- #endregion -->

                        <!-- #region Excerpt -->
                        <?php if (has_excerpt($post->ID)) :?>
                            <div class="row">
                                <div class="medium-11 column">
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!-- #endregion -->

                    </div>
                </div>
                <!-- #endregion -->

                <!-- #region Recipe -->
                <div class="row">
                    <div class="medium-12 column">
                        <h3 class="rc-subtitle">Przepis</h3>
                        <div class="row">
                            <div class="medium-11 column medium-centered">

                                <p>Składniki:</p>
                                <?php printIngredients($post->ID);?>

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
                        <h3 style="font-weight:500;">Ocena przepisu:</h3>
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

    <!-- #region Modals -->

        <!-- #region printIngredients -->
            <div id="printList" class="reveal-modal" style="width: 50%;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
                <?php $ingredients = getIngredients($post->ID); ?>
                <div class="medium-8 column medium-centered">
                    <?php echo '<h3>'.get_the_title().'</h3>'; ?>
                    <table>            
                        <tbody>
                            <?php foreach ($ingredients as $ingredient) : ?>            
                            <tr>
                                <td><?php echo $ingredient; ?></td>
                                <td><i class="fa fa-square-o"></i></td>
                            </tr>
                            <?php endforeach; ?> 
                        </tbody>             
                    </table>
                    <a href="#" class="button small right">Drukuj</a>
                    <?php?>
                </div>                  
            </div>
        <!-- #endregion -->

        <!-- #region Comments -->

            

        <!-- #endregion -->

    <!-- #endregion -->
        
<?php get_footer(); ?>