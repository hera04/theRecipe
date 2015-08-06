<?php 
    $search = getQuerySingleParam('search');
    if (empty($search)){
        $search = 'Wpisz tekst do wyszukania';
    };
    
    $options = get_option('general_settings');
    $number_of_items = $options['number_of_items'];
    
?>
<section class="banner">
    <div class="cd-hero">
        <ul class="cd-hero-slider autoplay slider half-height">

            <?php
                /**
                 * W tym miejscu tworzone są elementy w bannerze. Z ustawień pobierana jest informacja co ma być wyświetlane.
                 * Obiekty są dodawane w <li>. W zależności od ustawień wyświetlane jest menu najlepszyh postów, lub pasek wyszukiwania. Domyślnie jest to pasek wyszukiwania.
                 * */
                for ( $i=0; $i<$number_of_items; $i++){ ?>
                    <li style="background-image: url(<?php echo THEME_URL ?>images/33.jpg);" class="<?php if ($i == 0) echo 'selected' ?> sl-item">
                        <?php
                        /**
                         * Wyświetlanie najlepszych postów.
                         * */
                        if($options['select_content'] == 'posts_bar'){ ?>                            
                            <a href="#">
                                <div class="small-12 medium-10 large-6 column" style="margin-top: 60px;">                                                            
                                    <div class="sl-desc-wrapper">
                                        <h2 class="sl-desc-title">Deser z truskawami</h2>
                                        <p>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.
                                        </p>
                                    </div>                               
                                </div>
                            </a><?php
                        };
                        ?>
                        <div class="mask"></div>
                    </li>
            <?php
                };
                
            ?>
        </ul>

        <?php
            /**
             * Wyświetlanie paska wyszukiwania.
             */
            if($options['select_content'] == 'search_bar'){ ?>
            
                <div class="search-bar search-bar-center">
                    <form method="get" action="<?php current_page_url(); ?>">
                        <div class="row">
                            <div class="small-9 medium-10 columns">
                                <input type="text" name="search" id="search" placeholder="<?php echo $search; ?>" class="radius search-form" />
                            </div>
                            <div class="small-3 medium-2 column">
                                <input type="submit" value="Szukaj" class="button show-for-large-up radius" style="width: 100%;"/>
                                <input type="submit" value="GO!" class="button hide-for-large-up radius" style="width: 100%;"/>
                            </div>
                        </div>
                    </form>
                </div> <?php    
                
            };
        ?>
        
        <div class="cd-slider-nav sl-nav">
            <nav>
                <ul>
                    <?php
                        for ($i=0; $i<$number_of_items; $i++){
                            if ($i == 0) echo '<li class="selected"><p><i class="fa fa-circle-thin"></i></p></li>';
                            else echo '<li class=""><p><i class="fa fa-circle-thin"></i></p></li>';
                        };
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</section>