<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Dynamiczne ustawienie kodowania strony -->
    <meta charset="<?php bloginfo('charset') ?>" />
    
    <!-- Sprawdzenie czy strona jest wyszukiwarką --------------------------------------------------------
    ---- Jeśli tak to zabraniam robotom indeksującym indeksować treści. Unikamy zduplikowanych treści. -->
    <?php 
    if(is_search())
        echo '<meta name="robots" content="noindex, nofollow" />' 
    ?>
    <!-- ----------------------------------------------------------------------------------------- -->

    <title><?php bloginfo('name'); ?></title>

    <link rel="Shortcut icon" href="<?php echo THEME_URL; ?>images/favicon.png" />

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>"/> <!-- Zwraca ścieżkę do głównego pliku style.css -->
    <link rel="stylesheet" href="<?php echo THEME_URL; ?>stylesheets/app.css"/>
    <link rel="stylesheet" href="<?php echo THEME_URL; ?>stylesheets/muffins.css"/>
    <link rel="stylesheet" href="<?php echo THEME_URL; ?>stylesheets/font-awesome.css"/>
    <link rel="stylesheet" href="<?php echo THEME_URL; ?>stylesheets/hero-slider.css"/>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin-ext,latin" type="text/css">
    <link rel="pingback" href="<?php  bloginfo('pingback_url');?>" /> <!-- http://blog.dobert.pl/20101110/funkcje-trackback-i-pingback-w-wordpress.html  -->
    
    <script src="<?php echo THEME_URL; ?>bower_components/modernizr/modernizr.js"></script>
    <script src="<?php echo THEME_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo THEME_URL; ?>bower_components/foundation/js/foundation.min.js"></script>
    <script src="<?php echo THEME_URL; ?>js/main.js"></script>
    <script src="<?php echo THEME_URL; ?>js/app.js"></script>
    
    <?php 
        // http://wpninja.pl/artykuly/wp_head-i-wp_footer-dwie-funkcje-o-ktorych-zawsze-powinienes-pamietac/
        wp_head(); 
    ?>

  </head>
<body <?php body_class(); ?>>
    <header>
    <!-- NAVIGATION ---------------------------------------------------------------- -->
    <div class="fixed">
        <div class="nav_wrapper" id="navigation" style="">
            <nav class="top-bar" data-topbar role="navigation" data-options="is_hover: true">
                <ul class="title-area">
                    <li class="name">
                        <h1>
                            <a href="<?php echo esc_url(home_url('/')); ?>">the Recipe</a>
                        </h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
                </ul>

                <section class="top-bar-section">
                    <ul class="right">

                        <li class="has-dropdown">
                            <a href="#>">Przepisy</a>
                            <ul class="dropdown">
                                <li><a href="<?php echo esc_url(home_url('/index.php/recipes')); ?>">Wszystkie</a></li>
                                <li><a href="#">Babki</a></li>
                                <li><a href="#">Muffinki</a></li>
                                <li><a href="#">Ciasta</a></li>
                                <li><a href="#">Torty</a></li>
                                <li><a href="#">Desery</a></li>
                                <li><a href="#">Przetwory</a></li>
                                <li><a href="#">Napoje</a></li>
                                <li><a href="#">Inne</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Food Fight</a></li>
                        <li><a href="<?php echo esc_url(home_url('/index.php/restaurants')); ?>">Restauracje</a></li>
                        <li><a href="#">Kontakt</a></li>
                        <li class="has-dropdown">
                            <a href="#"><i class="fa fa-user"></i> hera04</a>
                            <ul class="dropdown">
                                <li><a href="<?php echo esc_url(admin_url('/')); ?>"><i class="fa fa-user"></i> Administracja</a></li>
                                <li><a href="#"><i class="fa fa-wrench"></i> Ustawienia</a></li>
                                <li><a href="#"><i class="fa fa-sign-out"></i> Wyloguj się</a></li>
                            </ul>
                        </li>

                    </ul>
                </section>
            </nav>
        </div>
    </div>
    <!-- --------------------------------------------------------------------------- -->
    </header>

    <!--<span class="wp_info">
        <?php bloginfo('charset') ?>    
    </span>-->