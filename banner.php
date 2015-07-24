<?php 
    $search = getQuerySingleParam('search');
    if (empty($search)){
        $search = 'Wpisz tekst do wyszukania';
    };
?>
<section class="banner">
    <div class="cd-hero">
        <ul class="cd-hero-slider autoplay slider half-height">

            <li style="background-image: url(<?php echo THEME_URL ?>images/33.jpg);" class="selected sl-item">
                <div class="mask"></div>
            </li>

            <li style="background-image: url(<?php echo THEME_URL ?>images/24.jpg);" class="selected sl-item">
                <div class="mask"></div>
            </li>

            <li style="background-image: url(<?php echo THEME_URL ?>images/8.jpg);" class="selected sl-item">
                <div class="mask"></div>
            </li>
        </ul>

        <div class="search-bar search-bar-center">
            <form method="get" action="<?php current_page_url(); ?>">
                <div class="row">
                    <div class="medium-10 columns">
                        <input type="text" name="search" id="search" placeholder="<?php echo $search ?>" class="radius search-form" />
                    </div>
                    <div class="medium-2 column">
                        <input type="submit" value="Szukaj" class="button show-for-large-up radius" style="width: 100%;"/>
                        <!--<input type="submit" value="GO!" class="button hide-for-large-up radius" style="width: 100%;"/>-->
                    </div>
                </div>
            </form>
        </div>

        <div class="cd-slider-nav sl-nav">
            <nav>
                <ul>
                    <li class="selected"><p><i class="fa fa-circle-thin"></i></p></li>
                    <li class=""><p><i class="fa fa-circle-thin"></i></p></li>
                    <li class=""><p><i class="fa fa-circle-thin"></i></p></li>
                </ul>
            </nav>
        </div>
    </div>
</section>