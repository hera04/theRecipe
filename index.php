<?php get_header(); ?>

    <!-- POPULARNE WPISY -------------------------------------------------------------->
    <section class="cd-hero">
        <ul class="cd-hero-slider autoplay slider full-height">

            <li style="background-image: url(<?php echo THEME_URL ?>images/33.jpg);" class="selected sl-item">
                <div class="large-6 column" style="margin-top: 20%;">
                    <div class="sl-desc-wrapper">
                        <h2 class="sl-desc-title">Deser z truskawami</h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                        </p>
                    </div>
                </div>
                <div class="mask"></div>
            </li>

            <li style="background-image: url(<?php echo THEME_URL ?>images/24.jpg);" class="sl-item">
                <div class="large-6 column" style="margin-top: 20%;">
                    <div class="sl-desc-wrapper">
                        <h2 class="sl-desc-title">Deser z truskawami</h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                        </p>
                    </div>
                </div>
                <div class="mask"></div>
            </li>

            <li style="background-image: url(<?php echo THEME_URL ?>images/8.jpg);" class="sl-item">
                <div class="large-6 column" style="margin-top: 20%;">
                    <div class="sl-desc-wrapper">
                        <h2 class="sl-desc-title">Deser z truskawami</h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                        </p>
                    </div>
                </div>
                <div class="mask"></div>
            </li>
        </ul>

        <div class="search-bar search-bar-bottom">
            <form>
                <div class="row">
                    <div class="medium-10 columns">
                        <input type="text" placeholder="Na co masz ochotę?" class="radius search-form" />
                    </div>
                    <div class="medium-2 column">
                        <a href="#" class="button hide-for-large-up radius"><i class="fa fa-search"></i></a>
                        <a href="#" class="button show-for-large-up radius">Wyszukaj</a>
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
    </section>
    <!-- --------------------------------------------------------------------------- -->


    <!-- MAIN CONTENT -------------------------------------------------------------- -->
    <div class="site-content" id="siteContent">

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
        <!-- ------------------------------------------------------------- -->
        <!-- Sekcja wpisów ----------------------------------------------- -->
        <div class="row" style="text-align: justify;">
            <h1 style="padding-left:10px;">Najnowsze wpisy</h1>

            <!-- WPISY --------------------------------------------------- -->
            <div class="large-8 column">
                <!-- GŁÓWNY WPIS ----------------------------------------- -->
                <div class="row main-post show-for-medium-up">
                    <div class="medium-12 column">
                        <!-- Data i Kategoria ---------------------------- -->
                        <div class="medium-5 large-4 column show-for-medium-up mp-info">
                            <h6>poniedziałek, 20 listopad</h6>
                            <h3><b>Dania</b></h3>
                        </div>
                        <!-- Opis głównej wiadomości---------------------- -->
                        <div class="medium-12 column mp-desc-wrapper">
                            <h2>Pomysł na sorbet owocowy</h2>
                            <p class="right show-for-small-only"><a href="#">Zobacz przepis...</a></p>
                            <p class="show-for-medium-up">
                                Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.
                                <br /><a class="right" href="#">Zobacz przepis...</a>
                            </p>
                        </div>
                        <!-- Zdjęcie wiadomości -->
                        <img src="<?php echo THEME_URL; ?>images/6.jpg" />
                    </div>
                </div>
                <!-- ----------------------------------------------------- -->
                <!-- POZOSTAŁE WPISY ------------------------------------- -->
                <div class="medium-12 column">
                    <!-- Wpisy 1 - 6 -->
                    <div class="row other-posts">
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#"><h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu" />
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#"><h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu" />
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#"><h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu" />
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#">
                                <h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu"/>
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#">
                                <h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu"/>
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 column op-wrapper">
                            <!-- Tytuł przepisu -->
                            <h5 class="op-category">Dania</h5>
                            <a href="#"><h3 class="site-titles">Pasztet z sosem</h3></a>
                            <!-- Opis przepisu -->
                            <div class="medium-12 op-desc-wrapper">
                                <img class="op-desc-trigger" src="<?php echo THEME_URL; ?>images/8.jpg" alt="Zdjęcie wpisu" />
                                <div class="op-desc-to-show">
                                    <div class="medium-12 columns op-desc">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                        <a class="right" href="#">Zobacz przepis...</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Podtytuł i ocena przepisu -->
                            <div class="medium-12 columns">
                                <h5 class="left">Na każdą okazję</h5>
                                <div class="right op-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Link do wszystkich przepisów -->
                    <div class="row">
                        <div class="medium-12 column text-center">
                            <a>Zobacz więcej przepisów...</a>
                        </div>
                    </div>
                </div>
                <!-- ----------------------------------------------------- -->
            </div>
            <!-- --------------------------------------------------------- -->
            <!-- SIDEBAR - szukajka - komentarze - tagi ------------------ -->
            <?php get_sidebar( 'index' ); ?>
            <!-- --------------------------------------------------------- -->

        </div>
        <!-- ------------------------------------------------------------- -->
    </div>
    <!-- --------------------------------------------------------------------------- -->
    <!-- FOOD BATTLE --------------------------------------------------------------- -->
    <div class="show-for-large-up battle-wrapper">
        <!-- Statystyki i opis wypieków -->
        <div class="medium-4 column medium-offset-4 bt-desc">
            <h1>MUFFINS BATTLE</h1>
            <p style="text-align: justify;">Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat. Ut fusce varius nisl ac ipsum gravida vel pretium tellus.</p>
            <table>
                <thead>
                    <tr>
                        <th>Babeczki</th>
                        <th>Babeczki</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>500 kcal</td>
                        <td>400 kcal</td>
                    </tr>
                    <tr>
                        <td>90 min</td>
                        <td>60 min</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                    <tr>
                        <td>***</td>
                        <td>****</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel radius ingredients">
                jajka, woda, wanilia, mąka, cukier, truskawki, morele, mąka, masło, agrest, cukier puder
            </div>
        </div>
        <!-- Opis pierwszego wypieku -->
        <form action="#" method="post">
            <div class="opponent" style="background-image: url(<?php echo THEME_URL; ?>images/29.jpg);">
                <!-- Biała maska> -->
                <input type="submit" class="opp-trigger" value="" />
                <!-- Opis -->
                <div class="opp-desc" style="left: 0;">
                    <h2 class="opp-title" style="">Babeczki z pomidorami</h2>
                    Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida.
                </div>
            </div>
        </form>
        <!-- Opis drugiego wypieku -->
        <form action="#" method="post">
            <div class="opponent" style="background-image: url(<?php echo THEME_URL; ?>images/30.jpg);">
                <!-- Biała maska> -->
                <input type="submit" class="opp-trigger" value="" />
                <!-- Opis -->
                <div class="opp-desc" style="right: 0;">
                    <h2 class="opp-title" style="">Babeczki z pomidorami</h2>
                    Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.Ut fusce varius nisl ac ipsum gravida vel pretium tellus tincidunt integer eu augue augue nunc elit dolor, luctus placerat.e varius nisl ac ipsum gravida.
                </div>
            </div>
        </form>
    </div>
    <!-- --------------------------------------------------------------------------- -->
    <!-- MODALE -------------------------------------------------------------------- -->
    <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle">Awesome. I have it.</h2>
        <p class="lead">Your couch. It is mine.</p>
        <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- --------------------------------------------------------------------------- -->
    
    <?php get_footer();?>