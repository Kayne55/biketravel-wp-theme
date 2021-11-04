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
remove_action( 'wp_travel_single_trip_after_booknow', 'wp_travel_single_keywords', 1 );
remove_action( 'wp_travel_single_trip_after_header', 'wp_travel_frontend_contents', 15 );

remove_action( 'wp_travel_before_main_content', 'wp_travel_archive_toolbar' );

// Replace WP Travel Actions with your own customised functions
add_action( 'wp_travel_before_single_itinerary', 'wp_travel_wrapper_start_custom' );
add_action( 'wp_travel_single_trip_after_title', 'biketravel_tour_meta' );
add_action( 'biketravel_tour_location_hook', 'biketravel_tour_location');
add_action( 'biketravel_tour_date_hook', 'biketravel_tour_date');
add_action( 'biketravel_tour_rating_hook', 'biketravel_tour_rating' );
add_action( 'biketravel_tour_pricing_hook', 'biketravel_tour_pricing' );
add_action( 'biketravel_tripcode_hook', 'biketravel_tripcode', 1 );
add_action( 'biketravel_tour_enquiry_button_hook', 'biketravel_tour_enquiry_button' );
add_action( 'wp_travel_single_trip_after_price', 'biketravel_tour_booknow_button' );
add_action( 'biketravel_tour_facts_hook', 'biketravel_tour_facts' );
add_action( 'biketravel_tour_tabs_hook', 'biketravel_tour_tabs' );
add_action( 'biketravel_tour_gallery_hook', 'biketravel_tour_gallery' );
add_action( 'biketravel_reviews_section_hook', 'biketravel_reviews_section' );
add_action( 'biketravel_archive_toolbar_hook', 'biketravel_archive_toolbar');

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
 * WP TRAVEL CUSTOM LAYOUT FOR BIKE TRAVEL
 * 
 */

function biketravel_tour_meta( $post_id ) {

	if ( ! $post_id ) {
		return;
	}
	
	//Get Strings
	$strings = wp_travel_get_strings();
	
	$terms = get_the_terms( $post_id, 'travel_locations' );

	$fixed_departure = get_post_meta( $post_id, 'wp_travel_fixed_departure', true );
	$fixed_departure = ( $fixed_departure ) ? $fixed_departure : 'yes';
	$fixed_departure = apply_filters( 'wp_travel_fixed_departure_defalut', $fixed_departure );

	$trip_duration       = get_post_meta( $post_id, 'wp_travel_trip_duration', true );
	$trip_duration       = ( $trip_duration ) ? $trip_duration : 0;
	$trip_duration_night = get_post_meta( $post_id, 'wp_travel_trip_duration_night', true );
	$trip_duration_night = ( $trip_duration_night ) ? $trip_duration_night : 0;

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
	$trip_type_text  		= isset( $strings['trip_type'] ) ? $strings['trip_type'] : __( 'Trip Type', 'wp-travel' );
	$activities_text 		= isset( $strings['activities'] ) ? $strings['activities'] : __( 'Activities', 'wp-travel' );
	$group_size_text 		= isset( $strings['group_size'] ) ? $strings['group_size'] : __( 'Group size', 'wp-travel' );
	$reviews_text   		= isset( $strings['reviews'] ) ? $strings['reviews'] : __( 'Reviews', 'wp-travel' );
	
	$locations_text       	= isset( $strings['locations'] ) ? $strings['locations'] : __( 'Locations', 'wp-travel' );
	$fixed_departure_text 	= isset( $strings['fixed_departure'] ) ? $strings['fixed_departure'] : __( 'Fixed departure', 'wp-travel' );
	$trip_duration_text  	= isset( $strings['trip_duration'] ) ? $strings['trip_duration'] : __( 'Trip duration', 'wp-travel' );

	$wp_travel_itinerary = new WP_Travel_Itinerary();
	?>
        <!-- Trip Meta Data -->
        <div class="row">
            <!-- Trip Type -->
            <div class="col-sm-6 mb-2">
                <strong><?php echo esc_html( $trip_type_text ); ?></strong>
                <br>
                <span>
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
			<div class="col-sm-6 mb-2">
				<strong><?php echo esc_html( $activities_text ); ?></strong>
				<br>
				<span>
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
			<div class="col-sm-6 mb-2">
				<strong><?php echo esc_html( $group_size_text ); ?></strong>
				<br>
				<span>
					<?php
					$group_size = wp_travel_get_group_size( $post_id );
					if ( (int) $group_size && $group_size < 999 ) {
						printf( apply_filters( 'wp_travel_template_group_size_text', __( '%d Riders', 'wp-travel' ) ), esc_html( $group_size ) );
					} else {
						echo esc_html( apply_filters( 'wp_travel_default_group_size_text', __( 'No size limit', 'wp-travel' ) ) );
					}
					?>
				</span>
			</div>
			<?php
			if ( wp_travel_tab_show_in_menu( 'reviews' ) && comments_open() ) :
				?>
				<!-- Reviews -->
				<div class="col-sm-6 mb-2">
					<strong><?php echo esc_html( $reviews_text ); ?></strong>
					<br>
					<span>
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
			if ( is_array( $terms ) && count( $terms ) > 0 ) :
				?>
				<!-- Locations -->
				<div class="col-sm-6 mb-2">
					<strong><?php echo esc_html( $locations_text ); ?></strong>
					<br>
					<span>
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
			<!-- Tour Date / Duration -->
			<?php
			if ( 'yes' === $fixed_departure ) :
				if ( $dates = wp_travel_get_fixed_departure_date( $post_id ) ) {
					?>
						<div class="col-sm-6 mb-2">
							<strong><?php echo esc_html( $fixed_departure_text ); ?></strong>
							<br>
							<span>
								<?php echo $dates; ?>
							</span>
						</div>
					<?php
				}
				?>

			<?php else : ?>
				<?php if ( $trip_duration || $trip_duration_night ) : ?>
					<div class="col-sm-6 mb-2">
						<strong><?php echo esc_html( $trip_duration_text ); ?></strong>
						<br>
						<span>
							<?php printf( __( '%1$s Day(s) %2$s Night(s)', 'wp-travel' ), $trip_duration, $trip_duration_night ); ?>
						</span>
					</div>
				<?php endif; ?>
				<?php
			endif;
			?>
		</div>
	<?php
}

function biketravel_tour_rating( $post_id ) {
	
	$count = (int) get_comments_number();
	$average_rating = wp_travel_get_average_rating( $post_id );

	/*
	if ( ! is_singular( WP_TRAVEL_POST_TYPE ) ) {
		return;
	}
	*/
	if ( ! $post_id ) {
		return;
	}
	if ( $hide_rating ) {
		return;
	}
	if ( ! wp_travel_tab_show_in_menu( 'reviews' ) ) {
		return;
	}

	if ( is_singular( WP_TRAVEL_POST_TYPE ) && $count > 0 ) {
	?>

			<div class="wp-travel-average-review" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'wp-travel' ), $average_rating ); ?>">
				<a>
					<span style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%">
					</span>
				</a>
			</div>
			<?php
			echo '<small class="bt-reviews-count" style="display: block;"><a href="javascript:void(0)" class="wp-travel-count-info">';
			printf( _n( '(%s review(', '(%s reviews)', $count, 'wp-travel' ), $count );
			echo '</a></small>';
			?>

	<?php
	} elseif ( ! is_singular( WP_TRAVEL_POST_TYPE ) && $count > 0 ) {
		?>

		<div class="wp-travel-average-review" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'wp-travel' ), $average_rating ); ?>">
				<a>
					<span style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%">
					</span>
				</a>
			</div>
			<?php
			$view_mode = wp_travel_get_archive_view_mode();
			if ( 'list' === $view_mode ) {
				echo '<small style="display: block; color: #777;">';
				printf( _n( '(%s review(', '(%s reviews)', $count, 'wp-travel' ), $count );
				echo '</small>';
		}
	}
}

function biketravel_tour_pricing( $trip_id ) {

	$trip_price    = wp_travel_get_price( $trip_id );
	$regular_price = wp_travel_get_price( $trip_id, true );
	$enable_sale   = wp_travel_is_enable_sale_price( $trip_id, true );

	$strings = wp_travel_get_strings();

	?>
	<?php if ( $trip_price ) : ?>

			<span class="bt-price-from">
				<?php echo esc_html( $strings['from'] ); ?>
				<?php if ( $enable_sale ) : ?>
					<del>
						<span><?php echo wp_travel_get_formated_price_currency( $regular_price, true ); ?></span>
					</del>
				<?php endif; ?>
			</span>
			<br>
			<span class="person-count">
				<?php echo wp_travel_get_formated_price_currency( $trip_price ); ?>
			</span>

	<?php endif;
	
}

function biketravel_tripcode() {
	$wp_travel_itinerary = new WP_Travel_Itinerary();
	//global $wp_travel_itinerary;
	if ( is_singular( WP_TRAVEL_POST_TYPE ) ) :
		?>
		<div class="wp-travel-trip-code"><span><?php esc_html_e( 'Trip Code', 'wp-travel' ); ?>: </span><code><?php echo esc_html( $wp_travel_itinerary->get_trip_code() ); ?></code></div>
		<?php
	endif;

}

function biketravel_tour_enquiry_button( $post_id ) {

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

	?>
		<!-- Enquiry Button -->
		<?php
		$trip_enquiry_text = isset( $strings['featured_trip_enquiry'] ) ? $strings['featured_trip_enquiry'] : __( 'Trip Enquiry', 'wp-travel' );

		if ( 'yes' == $enable_enquiry ) : ?>
			<a id="wp-travel-send-enquiries" class="wp-travel-send-enquiries" data-effect="mfp-move-from-top" href="#wp-travel-enquiries">
				<span><?php echo esc_attr( apply_filters( 'wp_travel_trip_enquiry_popup_link_text', $trip_enquiry_text ) ); ?>&nbsp;<i class="fas fa-question-circle"></i></span>
			</a>
		<?php
		endif;

		if ( 'yes' == $enable_enquiry ) :
			wp_travel_get_enquiries_form();
		endif;
		?>
		<?php
}

function biketravel_tour_booknow_button( $post_id ) {

	if ( ! $post_id ) {
		return;
	}
	$strings = wp_travel_get_strings();
	// Get Settings
	$settings = wp_travel_get_settings();
	?>
	<div class="booking-form">
		<div class="wp-travel-booking-wrapper">
		<?php
		if ( wp_travel_tab_show_in_menu( 'booking' ) ) :
			$book_now_text = isset( $strings['featured_book_now'] ) ? $strings['featured_book_now'] : __( 'Book Now', 'wp-travel' );
			?>
			<button class="btn btn-lg btn-outline-primary bt-button-xl bt-trip-button wp-travel-booknow-btn"><?php echo esc_html( apply_filters( 'wp_travel_template_book_now_text', $book_now_text ) ); ?></button>
		<?php endif; ?>
		</div>
	</div>
	<?php
}

function biketravel_tour_location( $post_id ) {
	
	if ( ! $post_id ) {
		return;
	}
	// Get Strings
/*
	$strings = wp_travel_get_strings();

	$terms = get_the_terms( $post_id, 'travel_locations' )[0];

	if ( is_array( $terms ) && count( $terms ) > 0 ) :
		?>
		<span>
			<?php
			$i = 0;
			foreach ( $terms as $term ) :
				if ( $i > 0 ) :
					?>
						,
					<?php
				endif;
				?>
				<span><?php echo esc_html( $term->name ); ?></span>
				<?php
				$i++;
			endforeach;
			?>
		</span>
	<?php endif;
*/
	// Retrieve all the travel locations:
	$all_locations = get_the_terms( $post_id, 'travel_locations' );
	// Get the parent travel location (the Continent):
	$the_continent = $all_locations[0];
	//if the parent location has children (Countries), get the first Child:
	$the_country = $all_locations[1];
	
	if ( $the_country ) {
		// If the current term is a child:
		echo esc_html( $the_country->name );

	} else {
		// If the current term does not have children display the parent term:
		echo esc_html( $the_continent->name );

	}

}

function biketravel_tour_date( $post_id ) {
	if ( ! $post_id ) {
		return;
	}

	// Get Strings
	$strings = wp_travel_get_strings();

	$fixed_departure = get_post_meta( $post_id, 'wp_travel_fixed_departure', true );
	$fixed_departure = ( $fixed_departure ) ? $fixed_departure : 'yes';
	$fixed_departure = apply_filters( 'wp_travel_fixed_departure_defalut', $fixed_departure );

	$trip_duration       = get_post_meta( $post_id, 'wp_travel_trip_duration', true );
	$trip_duration       = ( $trip_duration ) ? $trip_duration : 0;

	// Strings
	$fixed_departure_text = isset( $strings['fixed_departure'] ) ? $strings['fixed_departure'] : __( 'Fixed departure', 'wp-travel' );
	$trip_duration_text   = isset( $strings['trip_duration'] ) ? $strings['trip_duration'] : __( 'Trip duration', 'wp-travel' );

	if ( 'yes' === $fixed_departure ) :
		if ( $dates = wp_travel_get_fixed_departure_date( $post_id ) ) {
			?>
				<span>
					<?php echo $dates; ?>
				</span>
			<?php
		}
		?>

	<?php else : ?>
		<?php if ( $trip_duration ) : ?>
			<span>
				<?php printf( __( '%1$s Days', 'wp-travel' ), $trip_duration ); ?>
			</span>
		<?php endif; ?>
		<?php
	endif;
}

function biketravel_tour_facts( $post_id ) {

	if ( ! $post_id ) {
		return;
	}
	$settings = wp_travel_get_settings();

	if ( empty( $settings['wp_travel_trip_facts_settings'] ) ) {
		return '';
	}

	$wp_travel_trip_facts_enable = isset( $settings['wp_travel_trip_facts_enable'] ) ? $settings['wp_travel_trip_facts_enable'] : 'yes';

	if ( 'no' === $wp_travel_trip_facts_enable ) {
		return;
	}

	$wp_travel_trip_facts = get_post_meta( $post_id, 'wp_travel_trip_facts', true );

	if ( is_string( $wp_travel_trip_facts ) && '' != $wp_travel_trip_facts ) {

		$wp_travel_trip_facts = json_decode( $wp_travel_trip_facts, true );
	}

	if ( is_array( $wp_travel_trip_facts ) && count( $wp_travel_trip_facts ) > 0 ) {
		?>
		<!-- TRIP FACTS -->
					<?php foreach ( $wp_travel_trip_facts as $key => $trip_fact ) : ?>
						<?php
						if ( isset( $trip_fact['fact_id'] ) ) {
							$trip_fact_id = $trip_fact['fact_id'];
							if ( ! isset( $settings['wp_travel_trip_facts_settings'][ $trip_fact_id ] ) ) {
								continue;
							}
							$icon  = $settings['wp_travel_trip_facts_settings'][ $trip_fact_id ]['icon'];
							$label = $settings['wp_travel_trip_facts_settings'][ $trip_fact_id ]['name'];
						} else {
							$trip_fact_setting = array_filter(
								$settings['wp_travel_trip_facts_settings'],
								function( $setting ) use ( $trip_fact ) {

									return $setting['name'] === $trip_fact['label'];
								}
							);
							foreach ( $trip_fact_setting as $set ) {
								$icon  = $set['icon'];
								$label = $set['name'];
							}
						}

						if ( isset( $trip_fact['value'] ) ) :
							?>
							<div class="col-sm-4">
								<small class="text-muted">
									<i class="fas <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
									<strong><?php echo esc_html( $label ); ?></strong>:
									<?php
									if ( $trip_fact['type'] === 'multiple' ) {
										$count = count( $trip_fact['value'] );
										$i     = 1;
										foreach ( $trip_fact['value'] as $key => $val ) {
											// echo esc_html( $val );
											if ( isset( $trip_fact['fact_id'] ) ) {
												echo esc_html( $settings['wp_travel_trip_facts_settings'][ $trip_fact['fact_id'] ]['options'][ $val ] );
											} else {
												echo esc_html( $val );
											}
											if ( $count > 1 && $i !== $count ) {
												echo esc_html( ',', 'wp-travel' );
											}
											$i++;
										}
									} else {
										if ( isset( $trip_fact['fact_id'] ) && 'single' === $trip_fact['type'] ) {
											echo esc_html( $settings['wp_travel_trip_facts_settings'][ $trip_fact['fact_id'] ]['options'][ $trip_fact['value'] ] );
										} else {
											echo esc_html( $trip_fact['value'] );
										}
									}
									?>
								</small>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<!-- TRIP FACTS END -->
		<?php
	}
}

function biketravel_tour_tabs( $post_id ) {
	$wp_travel_itinerary = new WP_Travel_Itinerary();
	//global $wp_travel_itinerary;
	$no_details_found_message = '<p class="wp-travel-no-detail-found-msg">' . __( 'No details found.', 'wp-travel' ) . '</p>';
	$trip_content             = $wp_travel_itinerary->get_content() ? $wp_travel_itinerary->get_content() : $no_details_found_message;
	$trip_outline             = $wp_travel_itinerary->get_outline() ? $wp_travel_itinerary->get_outline() : $no_details_found_message;
	$trip_include             = $wp_travel_itinerary->get_trip_include() ? $wp_travel_itinerary->get_trip_include() : $no_details_found_message;
	$trip_exclude             = $wp_travel_itinerary->get_trip_exclude() ? $wp_travel_itinerary->get_trip_exclude() : $no_details_found_message;
	$gallery_ids              = $wp_travel_itinerary->get_gallery_ids();

	$wp_travel_itinerary_tabs = wp_travel_get_frontend_tabs();

	$fixed_departure = get_post_meta( $post_id, 'wp_travel_fixed_departure', true );

	$trip_start_date = get_post_meta( $post_id, 'wp_travel_start_date', true );
	$trip_end_date   = get_post_meta( $post_id, 'wp_travel_end_date', true );
	$trip_price      = wp_travel_get_trip_price( $post_id );
	$enable_sale     = wp_travel_is_enable_sale_price( $post_id );

	$trip_duration       = get_post_meta( $post_id, 'wp_travel_trip_duration', true );
	$trip_duration       = ( $trip_duration ) ? $trip_duration : 0;
	$trip_duration_night = get_post_meta( $post_id, 'wp_travel_trip_duration_night', true );
	$trip_duration_night = ( $trip_duration_night ) ? $trip_duration_night : 0;

	$settings      = wp_travel_get_settings();
	$currency_code = ( isset( $settings['currency'] ) ) ? $settings['currency'] : '';

	$currency_symbol = wp_travel_get_currency_symbol( $currency_code );
	$price_per_text  = wp_travel_get_price_per_text( $post_id );
	$sale_price      = wp_travel_get_trip_sale_price( $post_id );
	?>
	<div id="wp-travel-tab-wrapper">
		<?php if ( is_array( $wp_travel_itinerary_tabs ) && count( $wp_travel_itinerary_tabs ) > 0 ) : ?>

			<?php if ( is_array( $wp_travel_itinerary_tabs ) && count( $wp_travel_itinerary_tabs ) > 0 ) : ?>
				<?php $index = 1; ?>
				<?php foreach ( $wp_travel_itinerary_tabs as $tab_key => $tab_info ) : ?>
					<?php if ( 'reviews' === $tab_key && ! comments_open() ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<?php if ( 'yes' !== $tab_info['show_in_menu'] ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<?php
					switch ( $tab_key ) {

						case 'reviews':
							?>
							<div id="<?php //echo esc_attr( $tab_key ); ?>" class="tab-list-content">
								<?php //comments_template(); ?>
							</div>
							<?php
							break;
						case 'booking':
							$booking_template = wp_travel_get_template( 'content-pricing-options.php' );
							load_template( $booking_template );

							break;
						case 'faq':
							?>
						<div id="<?php echo esc_attr( $tab_key ); ?>" class="tab-list-content">
							<div class="panel-group" id="accordion">
							<?php
							$faqs = wp_travel_get_faqs( $post_id );
							if ( is_array( $faqs ) && count( $faqs ) > 0 ) {
								?>
								<div class="wp-collapse-open clearfix">
									<a href="#" class="open-all-link"><span class="open-all" id="open-all"><?php esc_html_e( 'Open All', 'wp-travel' ); ?></span></a>
									<a href="#" class="close-all-link" style="display:none;"><span class="close-all" id="close-all"><?php esc_html_e( 'Close All', 'wp-travel' ); ?></span></a>
								</div>
								<?php foreach ( $faqs as $k => $faq ) : ?>
								<div class="panel panel-default">
								<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo esc_attr( $k + 1 ); ?>">
									<?php echo esc_html( $faq['question'] ); ?>
									<span class="collapse-icon"></span>
									</a>
								</h4>
								</div>
								<div id="collapse<?php echo esc_attr( $k + 1 ); ?>" class="panel-collapse collapse">
								<div class="panel-body">
									<?php echo wp_kses_post( wpautop( $faq['answer'] ) ); ?>
								</div>
								</div>
							</div>
									<?php
								endforeach;
							} else {
								?>
								<div class="while-empty">
									<p class="wp-travel-no-detail-found-msg" >
										<?php esc_html_e( 'No Details Found', 'wp-travel' ); ?>
									</p>
								</div>
							<?php } ?>
							</div>
						</div>
							<?php
							break;
						case 'trip_outline':
							?>
						<div id="<?php echo esc_attr( $tab_key ); ?>" class="tab-list-content">
							<?php
								//echo wp_kses_post( $tab_info['content'] );

								$itinerary_list_template = wp_travel_get_template( 'itineraries-list.php' );
								load_template( $itinerary_list_template );
							?>
						</div>
							<?php
							break;
						default:
							?>
							<div id="<?php echo esc_attr( $tab_key ); ?>" class="tab-list-content">
								<?php
								if ( apply_filters( 'wp_travel_trip_tabs_output_raw', false, $tab_key ) ) {

									echo do_shortcode( $tab_info['content'] );

								} else {

									echo apply_filters( 'the_content', $tab_info['content'] );
								}

								?>
							</div>
						<?php break; ?>
					<?php } ?>
					<?php
					$index++;
				endforeach;
				?>
			<?php endif; ?>
		<?php endif; ?>

	</div>
	<?php
}

function biketravel_tour_gallery( $post_id ) {

	$wp_travel_itinerary = new WP_Travel_Itinerary();

	$gallery_ids = $wp_travel_itinerary->get_gallery_ids();
	?>
	<!-- Tour Gallery Section -->
	<section class="container">
      <h1 class="bt-display-heading bt-fontprimary text-center">Tour Gallery</h1>
      <div class="row bt-tour-gallery">
        <div class="col-md-4">
          <img src="https://www.biketravel.co/html-template/images/gallery/20191104_084159.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/20191104_174420.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/20191106_100450.jpg" alt="">
          
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_6006.jpg" alt="">
        </div>
        <div class="col-md-4">
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_5997.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_9046.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_9417.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_9430.jpg" alt="">
        </div>
        <div class="col-md-4">
          <img src="https://www.biketravel.co/html-template/images/gallery/Screenshot 2019-11-18 at 15.44.25.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/Screenshot 2019-11-18 at 15.55.38.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/Screenshot 2019-11-18 at 16.17.32.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/Screenshot 2019-11-20 at 08.22.00.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/Screenshot 2019-11-20 at 08.51.23.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/20191108_120735.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/20191108_154525-PANO.jpg" alt="">
          <img src="https://www.biketravel.co/html-template/images/gallery/IMG_5925.jpg" alt="">
        </div>
      </div>
    </section>
	<?php
}

function biketravel_reviews_section( $post_id ) {
	?>
	<section class="container my-5">
		<h1 class="bt-display-heading bt-fontprimary text-center">Tour Reviews</h1>
		<div id="<?php echo esc_attr( $tab_key ); ?>" class="tab-list-content">
			<?php comments_template(); ?>
		</div>
	</section>

	<?php
}

/**
 * Archive page toolbar.
 *
 * @since 1.0.4
 * @return void
 */
function biketravel_archive_toolbar() {
	$view_mode = wp_travel_get_archive_view_mode();
	if ( ( is_wp_travel_archive_page() || is_search() ) && ! is_admin() ) :
		?>
		<?php if ( is_wp_travel_archive_page() ) : ?>
	<div class="wp-travel-toolbar clearfix">
		<div class="wp-toolbar-content wp-toolbar-left">
			<?php wp_travel_archive_filter_by(); ?>
		</div>
		<div class="wp-toolbar-content wp-toolbar-right">
			<?php
			$current_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			?>
			<ul class="wp-travel-view-mode-lists">
				<li class="wp-travel-view-mode <?php echo ( 'grid' === $view_mode ) ? 'active-mode' : ''; ?>" data-mode="grid" ><a href="<?php echo esc_url( add_query_arg( 'view_mode', 'grid', $current_url ) ); ?>"><i class="dashicons dashicons-grid-view"></i></a></li>
				<li class="wp-travel-view-mode <?php echo ( 'list' === $view_mode ) ? 'active-mode' : ''; ?>" data-mode="list" ><a href="<?php echo esc_url( add_query_arg( 'view_mode', 'list', $current_url ) ); ?>"><i class="dashicons dashicons-list-view"></i></a></li>
			</ul>
		</div>
	</div>
	<?php endif; ?>
		<?php

		$archive_sidebar_class = '';

		if ( is_active_sidebar( 'DELETEwp-travel-archive-sidebar' ) ) {
			$archive_sidebar_class = 'DELETEwp-travel-trips-has-sidebar';
		}

		?>
		<!-- 
		Using a flexible bootstrap layout, so remove the list functionality here.
		Can also remove the sidebar class as the sidbar won't be used. Rather place the search widget in a drop down.
		-->
	<div class="row">
		<?php if ( 'grid' === $view_mode ) : ?>
				<!-- Add some functionality here when displaying in "Grid" view. -->
		<?php endif; ?>
	<?php endif; ?>

	<?php
}