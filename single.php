<?php
  get_header();
?>

    <!-- Breadcrumbs -->
    <div class="container">
      <div class="row bt-breadcrumbs">
        <div class="col">
          <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        </div>
      </div>
    </div>


    <!-- Article -->
    <article class="container bt-article my-4">
        <div class="row my-3">
            <div class="col-12">
                <h1><?php the_title();?></h1>

                <?php
                    if( have_posts() ){

                        while( have_posts() ){

                        the_post();
                        
                        get_template_part( 'template-parts/content', 'article' );
                        
                        }

                    }
                ?>
                
    </article>

    <!-- General Footer Wiget Area -->
    <div class="container">
      <div class="row my-3">
        <div class="col-12">
          <?php dynamic_sidebar( 'general-footer-area-1' ); ?>
        </div>
      </div>
    </div>

<?php
  get_footer();
?>