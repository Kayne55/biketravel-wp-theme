<?php
/**
 * Itinerary Shortcode Contnet Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
$post_id 		= get_the_ID();
$enable_sale 	= wp_travel_is_enable_sale_price( $post_id );
$trip_price 	= wp_travel_get_trip_price( $post_id );
$sale_price 	= wp_travel_get_trip_sale_price( $post_id ); ?>

<div class="col-md-4">
          <div class="card bt-tripcard bt-tripcard-grid">
            <div class="bt-tripcard-grid-image" style="background-image: url('<?php echo wp_travel_get_post_thumbnail_url( get_the_ID() ); ?>');">
				<?php if ( $enable_sale ) : ?>	
					<div class="bt-ribbon">
						<span><?php esc_html_e( 'On Special!', 'wp-travel' ); ?></span>
					</div>
				<?php endif; ?>
              <div class="bt-tripcard-overlay"></div>
              <div class="row">
                <div class="bt-tripcard-title col-12
                 text-center" style="display: inline-table;">
                  <h3 class="bt-display-heading"><?php the_title(); ?></h3>
                </div>
                </div>
                <div class="row">
                <div class="col bt-tripcard-location text-left"><span><i class="fas fa-map-marker-alt"></i>&nbsp;<?php do_action( 'biketravel_tour_location_hook', get_the_ID() ); ?></span></div>
                <div class="col bt-tripcard-duration text-right"><i class="fas fa-clock"></i>&nbsp;<?php do_action( 'biketravel_tour_date_hook', get_the_ID() ); ?></span></div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col bt-bookmark">
                  <a href="#"><i class="far fa-bookmark"></i></a>
                </div>
                <div class="col bt-star-rating">
				  <?php do_action( 'biketravel_tour_rating_hook', get_the_ID() ); ?>
				</div>
              </div>
              <div class="row align-items-end">
				<div class="col bt-trip-price">
					<?php do_action( 'biketravel_tour_pricing_hook', get_the_ID() ); ?>
				</div>
                <div class="col text-right">
                  <a href="<?php the_permalink() ?>" class="btn btn-outline-primary bt-button-xs">Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
