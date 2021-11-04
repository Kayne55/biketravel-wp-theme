<?php
/**
 * Itinerary Single Contnet Template
 *
 * This template can be overridden by copying it to yourtheme/wp-travel/content-single-itineraries.php.
 *
 * HOWEVER, on occasion wp-travel will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.wensolutions.com/document/template-structure/
 * @author      WenSolutions
 * @package     wp-travel/Templates
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_travel_itinerary;
?>

<!-- My custom filters and actions -->
<?php
	function prefix_wp_travel_show_single_page_title( $show ) {
		return true; // This will show the page title.
	}
	add_filter( 'wp_travel_show_single_page_title', 'prefix_wp_travel_show_single_page_title'  );

	function prefix_wp_travel_before_main_content() {
		esc_html_e( '<p>This is the content added using this hook</p>', 'text-domain' );
	}
	add_action( 'wp_travel_before_main_content', 'prefix_wp_travel_before_main_content'  );

	function prefix_wp_travel_before_single_itinerary( $post_id ) {
		esc_html_e( 'This is the content added using this hook', 'text-domain' );
	}
	add_action( 'wp_travel_before_single_itinerary', 'prefix_wp_travel_before_single_itinerary'  );
	
	function prefix_wp_travel_after_single_itinerary( $post_id ) {
		esc_html_e( 'This is the content added using this hook', 'text-domain' );
	}
	add_action( 'wp_travel_after_single_itinerary', 'prefix_wp_travel_after_single_itinerary'  );

	function prefix_wp_travel_before_single_title( $post_id ) {
		esc_html_e( 'This is the content added using this hook', 'text-domain' );
	}
	add_action( 'wp_travel_before_single_title', 'prefix_wp_travel_before_single_title'  );

	function prefix_wp_travel_single_before_trip_price() {
		esc_html_e( 'This is the content added using this hook', 'text-domain' );
	}
	add_action( 'wp_travel_single_before_trip_price', 'prefix_wp_travel_single_before_trip_price'  );

	function prefix_wp_travel_before_trip_details() {
		esc_html_e( 'This is the content added using this hook', 'text-domain' );
	}
	add_action( 'wp_travel_before_trip_details', 'prefix_wp_travel_before_trip_details'  );
?>

<?php
do_action( 'wp_travel_before_single_itinerary', get_the_ID() );
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

do_action( 'wp_travel_before_content_start');
?>
<!--HEADER -->
<div class="bt-itinerary-header" style="background-image: url(<?php echo esc_url( wp_travel_get_post_thumbnail_url( get_the_ID(), 'large' ) ) ?>);">
	<div class="bt-overlay-50"></div>
	<div class="bt-header-container">
		<div class="bt-itinerary-header-info">
			<?php wp_travel_get_trip_duration( get_the_ID() ); ?>
		</div>
		<?php $show_title = apply_filters( 'wp_travel_show_single_page_title', true ); ?>
		<?php if ( $show_title ) : ?>
			<header>
				<?php the_title( '<h1 class="bt-itinerary-header-h1">', '</h1>' ); ?>
			</header>
		<?php endif; ?>
	</div>
</div>
<div style="display: block;">
	<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</div>

<!--ITINRERARY DETAILS -->
<div id="itinerary-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="bt-itinerary-wrapper">
		<div class="bt-itinerary-details">
			<div class="bt-trip-short-desc">
				<?php the_excerpt(); ?>
			</div>
			<!-- Special Offer Element -->
	        <div>
				<?php // if ( $wp_travel_itinerary->is_sale_enabled() ) : ?>
				<?php if ( wp_travel_is_enable_sale_price( get_the_ID() ) ) : ?>
					<div class="wp-travel-offer">
						<span><?php esc_html_e( 'Special', 'wp-travel' ) ?></span>
					</div>
				<?php endif; ?>
			</div>
			<!-- END Special Offer Element -->

			<!-- View Gallery Element --
			<div style="width: 100%; text-align: center;">
				<?php //if ( $wp_travel_itinerary->has_multiple_images() ) : ?>
					<button class="" href=""><?php //esc_html_e( 'View Gallery', 'wp-travel' ) ?></button>
				<?php //endif; ?>
			</div>
			<-- END View Gallery Element -->

	        <div class="" style="width: 100%; text-align: center;">
				<div class="">
					<?php do_action( 'wp_travel_before_single_title', get_the_ID() ); ?>
					<?php wp_travel_do_deprecated_action( 'wp_tarvel_before_single_title', array( get_the_ID() ), '2.0.4', 'wp_travel_before_single_title' ); ?>
					<?php $show_title = apply_filters( 'wp_travel_show_single_page_title', true ); ?>				
					<?php wp_travel_do_deprecated_action( 'wp_travel_after_single_title', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_title' );  // @since 1.0.4 and deprecated in 2.0.4 ?>
					<?php do_action( 'wp_travel_single_trip_after_title', get_the_ID() ) ?>
					
				</div>
	        </div>
	    </div>
		<?php
			wp_travel_do_deprecated_action( 'wp_travel_after_single_itinerary_header', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_header' );  // @since 1.0.4 and deprecated in 2.0.4
			do_action( 'wp_travel_single_trip_after_header', get_the_ID() );
		?>
	</div><!-- .summary -->
</div><!-- #itinerary-<?php the_ID(); ?> -->

<?php do_action( 'wp_travel_after_single_itinerary', get_the_ID() ); ?>
