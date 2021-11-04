<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


/* WP TRAVEL TEMPLATE OVERRIDES */

remove_action( 'wp_travel_single_trip_after_title', 'wp_travel_trip_price', 1 );
remove_action( 'wp_travel_single_trip_after_title', 'wp_travel_single_excerpt', 1 );

add_action( 'wp_travel_single_trip_after_title', 'wp_travel_single_excerpt_customized', 1 );
add_action( 'wp_travel_single_trip_after_title', 'wp_travel_trip_price_customized', 1 );
//add_action( 'wp_travel_single_trip_meta_list', 'wp_travel_trip_price_customized', 1 );

function wp_travel_single_excerpt_customized( $post_id ) {
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
	<div class="trip-short-desc">
		<?php the_excerpt(); ?>
	</div>
	<div class="wp-travel-trip-meta-info">
		  <ul>
			<?php
			wp_travel_do_deprecated_action( 'wp_travel_single_itinerary_before_trip_meta_list', array( $post_id ), '2.0.4', 'wp_travel_single_trip_meta_list' );  // @since 1.0.4 and deprecated in 2.0.4
			?>
			  <li>
				   <div class="travel-info">
					<strong class="title"><?php echo esc_html( $trip_type_text ); ?></strong>
				</div>
				<div class="travel-info">
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
			   </li>
			   <li>
				<div class="travel-info">
					<strong class="title"><?php echo esc_html( $activities_text ); ?></strong>
				</div>
			   <div class="travel-info">
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
			   </li>
			   <li>
				   <div class="travel-info">
					<strong class="title"><?php echo esc_html( $group_size_text ); ?></strong>
				</div>
				<div class="travel-info">
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
			   </li>
			<?php

			if ( wp_travel_tab_show_in_menu( 'reviews' ) && comments_open() ) :
				?>
			   <li>
				   <div class="travel-info">
					<strong class="title"><?php echo esc_html( $reviews_text ); ?></strong>
				</div>
				<div class="travel-info">
				<span class="value">
				<?php
					$count = (int) get_comments_number();
					echo '<a href="javascript:void(0)" class="wp-travel-count-info">';
					printf( _n( '%s review', '%s reviews', $count, 'wp-travel' ), $count );
					echo '</a>';
				?>
				</span>
				</div>
			   </li>
			<?php endif; ?>
			<?php
			wp_travel_do_deprecated_action( 'wp_travel_single_itinerary_after_trip_meta_list', array( $post_id ), '2.0.4', 'wp_travel_single_trip_meta_list' );  // @since 1.0.4 and deprecated in 2.0.4
			do_action( 'wp_travel_single_trip_meta_list', $post_id );
			?>
		  </ul>
	</div>

	  <div class="booking-form">
		<div class="wp-travel-booking-wrapper">
			<?php
			$trip_enquiry_text = isset( $strings['featured_trip_enquiry'] ) ? $strings['featured_trip_enquiry'] : __( 'Trip Enquiry', 'wp-travel' );
			if ( wp_travel_tab_show_in_menu( 'booking' ) ) :
				$book_now_text = isset( $strings['featured_book_now'] ) ? $strings['featured_book_now'] : __( 'Book Now', 'wp-travel' );
				?>
				<button class="wp-travel-booknow-btn"><?php echo esc_html( apply_filters( 'wp_travel_template_book_now_text', $book_now_text ) ); ?></button>
			<?php endif; ?>
			<?php if ( 'yes' == $enable_enquiry ) : ?>
				<a id="wp-travel-send-enquiries" class="wp-travel-send-enquiries" data-effect="mfp-move-from-top" href="#wp-travel-enquiries">
					<span class="wp-travel-booking-enquiry">
						<span class="dashicons dashicons-editor-help"></span>
						<span>
							<?php echo esc_attr( apply_filters( 'wp_travel_trip_enquiry_popup_link_text', $trip_enquiry_text ) ); ?>
						</span>
					</span>
				</a>
				<?php
			endif;
			?>
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

function wp_travel_trip_price_customized( $trip_id, $hide_rating = false ) {

	$trip_price    = wp_travel_get_price( $trip_id );
	$regular_price = wp_travel_get_price( $trip_id, true );
	$enable_sale   = wp_travel_is_enable_sale_price( $trip_id, true );

	$strings = wp_travel_get_strings();

	?>

	<div class="wp-detail-review-wrap">
		<?php do_action( 'wp_travel_single_before_trip_price', $trip_id, $hide_rating ); ?>
		<div class="wp-travel-trip-detail">
			<?php if ( $trip_price ) : ?>
				<div class="trip-price" >
				<span class="price-from">
					<?php echo esc_html( $strings['from'] ); ?>
				</span>
				<?php if ( $enable_sale ) : ?>
					<del>
						<span><?php echo wp_travel_get_formated_price_currency( $regular_price, true ); ?></span>
					</del>
				<?php endif; ?>
					<span class="person-count">
						<ins>
							<span><?php echo wp_travel_get_formated_price_currency( $trip_price ); ?></span>
						</ins>
					</span>
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

/* END WP TRAVEL TEMPLATE OVERRIDES */