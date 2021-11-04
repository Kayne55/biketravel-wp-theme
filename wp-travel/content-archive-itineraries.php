<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
do_action( 'wp_travel_before_archive_itinerary', get_the_ID() );
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
	$enable_sale 	= wp_travel_is_enable_sale_price( get_the_ID() );
	$group_size 	= wp_travel_get_group_size( get_the_ID() );
	$start_date 	= get_post_meta( get_the_ID(), 'wp_travel_start_date', true );
	$end_date 		= get_post_meta( get_the_ID(), 'wp_travel_end_date', true ); ?>
	<?php $view_mode = wp_travel_get_archive_view_mode(); ?>
	<?php if ( 'list' === $view_mode ) : ?>
		<div class="card bt-tripcard bt-tripcard-list">
          <div class="row">
            <div class="col-md-4">
				<a href="<?php the_permalink(); ?>">
					<div class="bt-tripcard-list-image" style="background-image: url('<?php echo wp_travel_get_post_thumbnail_url( get_the_ID() ); ?>');">
						<?php if ( $enable_sale ) : ?>	
							<div class="bt-ribbon">
								<span><?php esc_html_e( 'On Special!', 'wp-travel' ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</a>
            </div>
            <div class="col-md-8">
              <div class="card-body" style="height: 100%;">
                <!-- Bookmark -->
                <div class="row text-right">
                  <div class="col bt-bookmark">
				  	<?php do_action( 'wp_travel_before_archive_content_title', get_the_ID() ); ?>
                  </div>
                </div>
                <div class="row" style="height: 100%;">
                  <!-- Trip Heading & Description -->
                  <div class="col-md-8 bt-trip-desc">
                    <h2 class="bt-display-heading bt-fontprimary">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'wp-travel' ) ) ); ?>">
							<?php the_title(); ?>
						</a>
						<?php //do_action( 'wp_travel_before_archive_content_title', get_the_ID() ); ?>
					</h2>
                    <p>
						<?php 
						
							//the_excerpt()

							$theExcerpt = get_the_excerpt(); 
 
							$theExcerpt = substr( $theExcerpt, 0, 140 ); // Limit excerpt length to 140 characters.
							$result = substr( $theExcerpt, 0, strrpos( $theExcerpt, ' ' ) );
							echo $result . '...';
						?>
					</p>
                  </div>
                  <!-- Rating / Price-->
                  <div class="col-md-4">
                    <div class="row align-items-center" style="height: 100%;">
                      <!-- Trip Rating -->
                      <div class="col col-md-12 col-sm-6 bt-star-rating">
					  	<?php do_action( 'biketravel_tour_rating_hook', get_the_ID() ); ?>
                      </div>
					<!-- Trip Price-->
					<div class="col bt-trip-price text-right">
						<?php do_action( 'biketravel_tour_pricing_hook', get_the_ID() ); ?>
					</div>
					 <!-- 
					  <div class="col col-md-12 col-sm-6 text-right bt-trip-price">
                        <p>
                          <span style="font-size: 70%; color: #999;">from</span>
                          <br>-->
							
                          <!--<br>
                          <span style="font-size: 70%; font-weight: bold;">/ person</span>
                        </p>
					  </div>
					  -->
                    </div>
                  </div>
                  <!-- Trip Meta Data -->
                  <div class="col-md-8 col-sm-8">
                    <div class="row bt-trip-meta-1 my-2 align-items-center">
                      <div class="col col-sm-6">
                        <a href="#"><i class="fas fa-map-marker-alt"></i>&nbsp;<?php do_action( 'biketravel_tour_location_hook', get_the_ID() ); ?></a>
                      </div>
                      <div class="col col-sm-6">
                        <a href="#"><i class="fas fa-clock"></i>&nbsp;<?php do_action( 'biketravel_tour_date_hook', get_the_ID() ); ?></a>
                      </div>
                    </div>
                  </div>
                  <!-- Trip Details Button -->
                  <div class="col-md-4 col-sm-4 text-right">
                    <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-outline-primary bt-button-xl bt-trip-button">Details</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
	<?php else : ?>
		<?php wp_travel_get_template_part( 'shortcode/itinerary', 'item' ); ?>
	<?php endif; ?>

<?php do_action( 'wp_travel_after_archive_itinerary', get_the_ID() ); ?>
