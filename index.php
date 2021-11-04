<?php
  get_header();
?>

    <article class="container my-4">
        <div class="row my-3">
            <div class="col-12 my-4">
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>
            <div class="col-12">
                <!--<h1><?php// wp_title(); ?></h1>-->

                <?php
                
                    if ( is_home() && ! is_front_page() ) :
                        ?>
                        <header>
                            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                        </header>
                        <?php
                    endif;

                    if( have_posts() ){

                        while( have_posts() ){

                        the_post();
                        
                        get_template_part( 'template-parts/content', 'archive' );
                        
                        }

                    } else {
                        _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
                    }
                ?>

            <div class="container">
                <div class="row my-4">
                    <div class="col-6 text-left">
                        <?php next_posts_link( '<i class="fas fa-chevron-left"></i> Older posts' ); ?>
                    </div>
                    <div class="col-6 text-right">
                        <?php previous_posts_link( 'Newer posts <i class="fas fa-chevron-right"></i>' ); ?>
                    </div>
                </div>
            </div>

                
    </article>

<?php
  get_footer();
?>