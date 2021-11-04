<?php
  get_header();
?>

    <?php dynamic_sidebar( 'hompage-banner' ); ?>

    <!-- Latest Articles -->
    <section  class="container mt-5">
      <div class="row">
        <?php dynamic_sidebar( 'hompage-content-above' ); ?>
      </div>
      <div class="row">
        <div class="col">

          <?php
              if( have_posts() ){

                  while( have_posts() ){

                    the_post();
                    the_content();
                  
                  }

              }
          ?>

        </div>
      </div>
      <div class="row">
        <?php dynamic_sidebar( 'hompage-content-below' ); ?>
      </div>
    </section>
<?php
  get_footer();
?>