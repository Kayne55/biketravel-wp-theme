<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package BikeTravel
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function biketravel_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'biketravel_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function biketravel_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'biketravel_pingback_header' );


/**
 * WP Travel overrides for plugins/wp-travel/inc/template-functions.php
 * */

// Remove WP Actions
remove_action( 'wp_travel_before_single_itinerary', 'wp_travel_wrapper_start' );
remove_action( 'wp_travel_after_single_itinerary', 'wp_travel_wrapper_end' );
remove_action( 'wp_travel_single_trip_after_title', 'wp_travel_trip_price', 1 );
remove_action( 'wp_travel_single_trip_after_price', 'wp_travel_single_trip_rating', 10, 2 );
remove_action( 'wp_travel_single_trip_after_title', 'wp_travel_single_excerpt', 1 );
remove_action( 'wp_travel_single_trip_meta_list', 'wp_travel_single_location', 1 );

// Replace WP Actions with your own customised functions
add_action( 'wp_travel_before_single_itinerary', 'wp_travel_wrapper_start_custom' );
add_action( 'wp_travel_single_trip_after_title', 'wp_travel_single_tour_metadata', 1 );
add_action( 'wp_travel_single_trip_meta_list', 'wp_travel_single_location_custom', 1 );
add_action( 'wp_travel_single_trip_after_title', 'wp_travel_trip_price_custom', 1 );
add_action( 'wp_travel_single_trip_after_price', 'wp_travel_single_trip_rating_custom', 10, 2 );

add_action( 'wp_travel_after_single_itinerary', 'wp_travel_wrapper_end_custom' );

/**
 * Wrapper Start.
 */

function wp_travel_wrapper_start_custom() {
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}

	$template = get_option( 'template' );

	switch ( $template ) {
		case 'twentyeleven':
			echo '<div id="primary"><div id="content" role="main" class="twentyeleven">';
			break;
		case 'twentytwelve':
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="twentytwelve">';
			break;
		case 'twentythirteen':
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
			break;
		case 'twentyfourteen':
			echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfWSC">';
			break;
		case 'twentyfifteen':
			echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15WSC">';
			break;
		case 'twentysixteen':
			echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main">';
			break;
		case 'twentyseventeen':
			echo '<div class="wrap"><div id="primary" class="content-area twentyseventeen"><div id="main" class="site-main">';
			break;
		default:
			echo '<div id="wp-travel-content" class="wp-travel-content clearfix" role="main">';
			break;
	}
}

/**
 * Wrapper Ends.
 */
function wp_travel_wrapper_end_custom() {
	$template = get_option( 'template' );

	switch ( $template ) {
		case 'twentyeleven':
			echo '</div></div>';
			break;
		case 'twentytwelve':
			echo '</div></div>';
			break;
		case 'twentythirteen':
			echo '</div></div>';
			break;
		case 'twentyfourteen':
			echo '</div></div></div>';
			get_sidebar( 'content' );
			break;
		case 'twentyfifteen':
			echo '</div></div>';
			break;
		case 'twentysixteen':
			echo '</div></main>';
			break;
		case 'twentyseventeen':
			echo '</div></div></div>';
			break;
		default:
			echo '</div>';
			break;
	}
}

/**
 * Add html of trip price.
 *
 * @param int  $trip_id ID for current trip.
 * @param bool $hide_rating Boolean value to show/hide rating.
 */
function wp_travel_trip_price_custom( $trip_id, $hide_rating = false ) {

	$trip_price    = wp_travel_get_price( $trip_id );
	$regular_price = wp_travel_get_price( $trip_id, true );
	$enable_sale   = wp_travel_is_enable_sale_price( $trip_id, true );

	$strings = wp_travel_get_strings();

	?>

	<div class="del-wp-detail-review-wrap">
		<?php do_action( 'del-wp_travel_single_before_trip_price', $trip_id, $hide_rating ); ?>
		<div class="del-wp-travel-trip-detail">
			<?php if ( $trip_price ) : ?>
				<div class="col col-lg-12 col-sm-6 text-right bt-trip-price" >
					<p>
						<small class="bt-price-from">
							<?php echo esc_html( $strings['from'] ); ?>
							<?php if ( $enable_sale ) : ?>
								<del>
									<span><?php echo wp_travel_get_formated_price_currency( $regular_price, true ); ?></span>
								</del>
							<?php endif; ?>
						</small>
						<br>
						<span class="person-count">
							<span><?php echo wp_travel_get_formated_price_currency( $trip_price ); ?></span>
						</span>
					</p>
				</div>
			<?php endif; ?>
		</div>
		<?php
			wp_travel_do_deprecated_action( 'wp_travel_single_after_trip_price', array( $trip_id, $hide_rating ), '2.0.4', 'wp_travel_single_trip_after_price' );  // deprecated in 2.0.4
			do_action( 'wp_travel_single_trip_after_price', $trip_id, $hide_rating );
		?>
	</div>

	<?php
}

/**
 * Add html of Rating.
 *
 * @param int  $post_id ID for current post.
 * @param bool $hide_rating Flag to sho hide rating.
 */
function wp_travel_single_trip_rating_custom( $post_id, $hide_rating = false ) {
	if ( ! is_singular( WP_TRAVEL_POST_TYPE ) ) {
		return;
	}
	if ( ! $post_id ) {
		return;
	}
	if ( $hide_rating ) {
		return;
	}
	if ( ! wp_travel_tab_show_in_menu( 'reviews' ) ) {
		return;
	}
	$average_rating = wp_travel_get_average_rating( $post_id );
	?>
	<div class="col col-lg-12 col-sm-6 bt-star-rating wp-travel-average-review" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'wp-travel' ), $average_rating ); ?>">
		<a>
			<span style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%">
				<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average_rating ); ?></strong> <?php printf( esc_html__( 'out of %1$s5%2$s', 'wp-travel' ), '<span itemprop="bestRating">', '</span>' ); ?>
			</span>
		</a>

	</div>
	<?php
}

/**
 * Add html for excerpt and booking button.
 *
 * @param int $post_id ID of current post.
 *
 * @since Modified in 2.0.7
 */
function wp_travel_single_tour_metadata( $post_id ) {

	if ( ! $post_id ) {
		return;
	}
	$strings = wp_travel_get_strings();
	// Get Settings
	$settings = wp_travel_get_settings();

	$enquery_global_setting = isset( $settings['enable_trip_enquiry_option'] ) ? $settings['enable_trip_enquiry_option'] : 'yes';

	$global_enquiry_option = get_post_meta( $post_id, 'wp_travel_use_global_trip_enquiry_option', true );

	if ( '' === $global_enquiry_option ) {
		$global_enquiry_option = 'yes';
	}
	if ( 'yes' == $global_enquiry_option ) {

		$enable_enquiry = $enquery_global_setting;

	} else {
		$enable_enquiry = get_post_meta( $post_id, 'wp_travel_enable_trip_enquiry_option', true );
	}

	// Strings
	$trip_type_text  = isset( $strings['trip_type'] ) ? $strings['trip_type'] : __( 'Trip Type', 'wp-travel' );
	$activities_text = isset( $strings['activities'] ) ? $strings['activities'] : __( 'Activities', 'wp-travel' );
	$group_size_text = isset( $strings['group_size'] ) ? $strings['group_size'] : __( 'Group size', 'wp-travel' );
	$reviews_text    = isset( $strings['reviews'] ) ? $strings['reviews'] : __( 'Reviews', 'wp-travel' );

	$wp_travel_itinerary = new WP_Travel_Itinerary();
	?>
		<div class="row">
			<!-- Trip Type -->
			<div class="col-sm-6">
				<strong class="title"><?php echo esc_html( $trip_type_text ); ?></strong>
				<br>
				<span class="value">
					<?php
						$trip_types_list = $wp_travel_itinerary->get_trip_types_list();
						if ( $trip_types_list ) {
							echo wp_kses( $trip_types_list, wp_travel_allowed_html( array( 'a' ) ) );
						} else {
							echo esc_html( apply_filters( 'wp_travel_default_no_trip_type_text', __( 'No trip type', 'wp-travel' ) ) );
						}
					?>
				</span>
			</div>
			<!-- Activity -->
			<div class="col-sm-6">
				<strong class="title"><?php echo esc_html( $activities_text ); ?></strong>
				<br>
				<span class="value">
					<?php
					$activity_list = $wp_travel_itinerary->get_activities_list();
					if ( $activity_list ) {
						echo wp_kses( $activity_list, wp_travel_allowed_html( array( 'a' ) ) );
					} else {
						echo esc_html( apply_filters( 'wp_travel_default_no_activity_text', __( 'No Activities', 'wp-travel' ) ) );
					}
					?>
					</span>
			</div>
			<!-- Group Size -->
			<div class="col-sm-6">
				<strong class="title"><?php echo esc_html( $group_size_text ); ?></strong>
				<br>
				<span class="value">
					<?php
					$group_size = wp_travel_get_group_size( $post_id );
					if ( (int) $group_size && $group_size < 999 ) {
						printf( apply_filters( 'wp_travel_template_group_size_text', __( '%d pax', 'wp-travel' ) ), esc_html( $group_size ) );
					} else {
						echo esc_html( apply_filters( 'wp_travel_default_group_size_text', __( 'No size limit', 'wp-travel' ) ) );
					}
					?>
				</span>
			</div>
			<!-- Reviews -->
			<?php
			if ( wp_travel_tab_show_in_menu( 'reviews' ) && comments_open() ) :
				?>
				<div class="col-sm-6">
					<strong class="title"><?php echo esc_html( $reviews_text ); ?></strong>
					<br>
					<span class="value">
						<?php
							$count = (int) get_comments_number();
							echo '<a href="javascript:void(0)" class="wp-travel-count-info">';
							printf( _n( '%s review', '%s reviews', $count, 'wp-travel' ), $count );
							echo '</a>';
						?>
					</span>
				</div>
			<?php endif; ?>
			<?php
			wp_travel_do_deprecated_action( 'wp_travel_single_itinerary_after_trip_meta_list', array( $post_id ), '2.0.4', 'wp_travel_single_trip_meta_list' );  // @since 1.0.4 and deprecated in 2.0.4
			do_action( 'wp_travel_single_trip_meta_list', $post_id );
			?>
		
		<div class="col-lg-12">
			<div class="row">
				<!-- Enquiry Button -->
				<?php
				$trip_enquiry_text = isset( $strings['featured_trip_enquiry'] ) ? $strings['featured_trip_enquiry'] : __( 'Trip Enquiry', 'wp-travel' );

				if ( 'yes' == $enable_enquiry ) : ?>
					<div class="col-md-4">
						<a id="wp-travel-send-enquiries" class="wp-travel-send-enquiries" data-effect="mfp-move-from-top" href="#wp-travel-enquiries">
							<span><?php echo esc_attr( apply_filters( 'wp_travel_trip_enquiry_popup_link_text', $trip_enquiry_text ) ); ?>&nbsp;<i class="fas fa-question-circle"></i></span>
						</a>
					</div>
				<?php
				endif;
				?>
				<!-- Book Now Button -->
				<?php
				if ( wp_travel_tab_show_in_menu( 'booking' ) ) :
					$book_now_text = isset( $strings['featured_book_now'] ) ? $strings['featured_book_now'] : __( 'Book Now', 'wp-travel' );
				?>
				<div class="col-md-4 text-right">
					<button class="btn btn-lg btn-outline-primary bt-button-xl bt-trip-button"><?php echo esc_html( apply_filters( 'wp_travel_template_book_now_text', $book_now_text ) ); ?></button>
				</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
		if ( 'yes' == $enable_enquiry ) :
			wp_travel_get_enquiries_form();
		endif;
	?>
	<?php
	wp_travel_do_deprecated_action( 'wp_travel_single_after_booknow', array( $post_id ), '2.0.4', 'wp_travel_single_trip_after_booknow' );  // @since 1.0.4 and deprecated in 2.0.4
	do_action( 'wp_travel_single_trip_after_booknow', $post_id ); // @since 2.0.4

}

/**
 * Add html for Keywords.
 *
 * @param int $post_id ID of current post.
 */
function wp_travel_single_location_custom( $post_id ) {
	if ( ! $post_id ) {
		return;
	}
	// Get Strings
	$strings = wp_travel_get_strings();

	$terms = get_the_terms( $post_id, 'travel_locations' );

	$fixed_departure = get_post_meta( $post_id, 'wp_travel_fixed_departure', true );
	$fixed_departure = ( $fixed_departure ) ? $fixed_departure : 'yes';
	$fixed_departure = apply_filters( 'wp_travel_fixed_departure_defalut', $fixed_departure );

	$trip_duration       = get_post_meta( $post_id, 'wp_travel_trip_duration', true );
	$trip_duration       = ( $trip_duration ) ? $trip_duration : 0;
	$trip_duration_night = get_post_meta( $post_id, 'wp_travel_trip_duration_night', true );
	$trip_duration_night = ( $trip_duration_night ) ? $trip_duration_night : 0;

	// Strings
	$locations_text       = isset( $strings['locations'] ) ? $strings['locations'] : __( 'Locations', 'wp-travel' );
	$fixed_departure_text = isset( $strings['fixed_departure'] ) ? $strings['fixed_departure'] : __( 'Fixed departure', 'wp-travel' );
	$trip_duration_text   = isset( $strings['trip_duration'] ) ? $strings['trip_duration'] : __( 'Trip duration', 'wp-travel' );

	if ( is_array( $terms ) && count( $terms ) > 0 ) :
		?>
		<div class="col-sm-6">
			<strong class="title"><?php echo esc_html( $locations_text ); ?></strong>
			<br>
			<span class="value">
				<?php
				$i = 0;
				foreach ( $terms as $term ) :
					if ( $i > 0 ) :
						?>
							,
						<?php
					endif;
					?>
					<span class="wp-travel-locations"><a href="<?php echo esc_url( get_term_link( $term->term_id ) ); ?>"><?php echo esc_html( $term->name ); ?></a></span>
					<?php
					$i++;
				endforeach;
				?>
			</span>
		</div>
	<?php endif; ?>
	<?php
	if ( 'yes' === $fixed_departure ) :
		if ( $dates = wp_travel_get_fixed_departure_date( $post_id ) ) {
			?>
				<div class="col-sm-6">
					<strong class="title"><?php echo esc_html( $fixed_departure_text ); ?></strong>
					<br>
					<span class="value">
						<?php echo $dates; ?>
					</span>
				</div>
			<?php
		}
		?>

	<?php else : ?>
		<?php if ( $trip_duration || $trip_duration_night ) : ?>
			<div class="col-sm-6">
				<strong class="title"><?php echo esc_html( $trip_duration_text ); ?></strong>
				<br>
				<span class="value">
					<?php printf( __( '%1$s Day(s) %2$s Night(s)', 'wp-travel' ), $trip_duration, $trip_duration_night ); ?>
				</span>
			</div>
		</div>
		<?php endif; ?>
		<?php
	endif;
}

/* END WP TRAVEL TEMPLATE OVERRIDES */