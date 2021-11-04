<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
      wp_head();
    ?>


  </head>
  <body>
    <!-- Header Start -->
    <header>
      <div class="bt-navbar-sticky">
        <!-- Top Menu -->
        <div class="navbar-light bt-topnav">
            <?php
                wp_nav_menu(
                    array(
                        'menu' => 'topmenu',
                        'container_class' => 'nav justify-content-end container d-flex align-items-center',
                        'theme_location' => 'topmenu',
                        'items_wrap' =>'<ul class="nav justify-content-end container d-flex align-items-center">%3$s</ul>'
                    )
                );
            ?>
        </div>

        <!-- Main Navbar -->
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light bt-navbar">
          <div class="container">
            <a id="bt-header-brand" class="navbar-brand bt-header-brand" href="<?php echo home_url(); ?>">
                <?php
                    if(function_exists('the_custom_logo')){
                        
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id);


                    }
                ?>
                <img src="<?php echo $logo[0] ?>" alt="Bike Travel">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'main',
                        'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container'       => 'div',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'navbar-nav mr-auto',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    ) );
                ?>

            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- Header End -->