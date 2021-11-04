<?php
	get_header();

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	//ACF Extra fields
	$tourHeroIMG 			= get_field('background_hero_image');
	$hasTourVideo 			= get_field('has_tour_video');
	$tourVideoEmbed 		= get_field('tour_video_embed');
	$tourOrgName 			= get_field('tour_organiser_name');
	$tourOrgDesignation		= get_field('tour_organiser_designation');
	$tourOrgPhoto			= get_field('tour_organiser_photo');
	$tourOrgAbout			= get_field('tour_organiser_about_info');
	$tourOrgExp				= get_field('tour_organiser_years_experience');
	$tourOrgTours			= get_field('tour_organiser_tours_done');
	$tourOrgFact			= get_field('tour_organiser_fact');
	
	global $wp_travel_itinerary;
?>

<?php
	do_action( 'wp_travel_before_single_itinerary', get_the_ID() );
	if ( post_password_required() ) {
		echo get_the_password_form();
		return;
	}

	do_action( 'wp_travel_before_content_start');
?>

	<div id="itinerary-<?php the_ID(); ?>" <?php post_class(); ?>>
		<!-- Large Banner -->
		<div class="jumbotron jumbotron-fluid bt-jumbo-header" style="background-image: url(
			<?php if( $tourHeroIMG ): ?>
				<?php echo $tourHeroIMG['url']; ?>
			<?php endif; ?>
			);"
		>
		<div class="bt-overlay-30"></div>
		<div class="container">
			<?php $show_title = apply_filters( 'wp_travel_show_single_page_title', true ); ?>
			<?php if ( $show_title ) : ?>
				<h1 class="display-1"><?php the_title(); ?></h1>
			<?php endif; ?>	
			<div class="row">
				<div class="col-12">
					<h5>
					<span><i class="fas fa-map-marker-alt"></i>&nbsp;<?php do_action( 'biketravel_tour_location_hook', get_the_ID() ); ?></span>
					<span style="padding-left: 1rem;"><i class="fas fa-clock"></i>&nbsp;<?php do_action( 'biketravel_tour_date_hook', get_the_ID() ); ?></span>
				</h5>
				</div>
			</div>
			<div class="row">
			<div class="col-lg-8">
				<p><?php the_excerpt();?></p>
			</div>
			<?php if( $hasTourVideo ): ?>
				<div class="col-lg-4 text-right align-self-end">
					<a href="#" onclick="openModal()"><h3>Watch the Video <i class="far fa-play-circle"></i></i></h3></a>
				</div>
			<?php endif; ?>
			</div>
		</div>
		</div>
		
		<!-- Breadcrumbs -->
		<div class="container">
			<div class="row bt-breadcrumbs">
				<div class="col-12">
					<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
				</div>
			</div>
		</div>

		<!-- Tour Detail Section -->

		<section class="container">
			<div class="card bt-tripcard bt-tripcard-list">
				<div class="row">
					<div class="col-lg-4">
						<div class="bt-tripcard-list-image" style="background-image: url(<?php echo esc_url( wp_travel_get_post_thumbnail_url( get_the_ID(), 'large' ) ) ?>);">
							
							<?php if ( wp_travel_is_enable_sale_price( get_the_ID() ) ) : ?>
								<div class="bt-ribbon">
									<span><?php esc_html_e( 'On Special!', 'wp-travel' ) ?></span>
								</div>
							<?php endif; ?>
							<div class="wp-travel-view-gallery bt-view-gallery">
								<a class="top-view-gallery" href=""><?php esc_html_e( 'View Gallery', 'wp-travel' ) ?></a>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="card-body" style="height: 100%;">
							<!-- START DYNAMIC CONTENT -->
							<!-- Bookmark -->
							<div class="row text-right">
								<div class="col bt-bookmark">
									<?php do_action( 'wp_travel_before_single_title', get_the_ID() ); ?>
									<?php wp_travel_do_deprecated_action( 'wp_tarvel_before_single_title', array( get_the_ID() ), '2.0.4', 'wp_travel_before_single_title' ); ?>
								</div>
							</div>
							<div class="row" style="height: 100%; padding-top: 1rem;">
							    <!-- Trip Heading & Description -->
								<div class="col-lg-8 bt-trip-details">
									<?php 
									wp_travel_do_deprecated_action( 'wp_travel_after_single_title', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_title' );  // @since 1.0.4 and deprecated in 2.0.4
									do_action( 'wp_travel_single_trip_after_title', get_the_ID() ) 
									?>
									<hr>
								</div>
								<!-- Rating / Price-->
								<div class="col-lg-4 ">
									<div style="height: 100%;" class="row align-items-center">
										<div class="col col-lg-12 col-sm-6 bt-star-rating">
											<?php do_action( 'biketravel_tour_rating_hook', get_the_ID() ); ?>
										</div>
										<div class="col col-lg-12 col-sm-6 text-right bt-trip-price">
											<?php do_action( 'biketravel_tour_pricing_hook', get_the_ID() ); ?>
										</div>
									</div>
								</div>
								<!-- Book Now Button, Enquire and Trip Code -->
								<div class="container">
									<div class="row align-items-center bt-trip-details-book">
										<div class="col-md-4 bt-trip-code">
										<?php 
										do_action( 'biketravel_tripcode_hook' );
										?>
										
										<!--
											<small>Trip Code: 
												<span style="font-family: 'Courier New', Courier, monospace;">BT-RE0001</span>
											</small>
										-->
										</div>
										<div class="col-md-4 bt-enquire">
											<?php 
											//wp_travel_do_deprecated_action( 'wp_travel_single_after_trip_booknow', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_booknow' );  // deprecated in 2.0.4
											do_action( 'biketravel_tour_enquiry_button_hook', get_the_ID() );
											?>
										</div>
										<div class="col-md-4 text-right">
											<?php 
											//wp_travel_do_deprecated_action( 'wp_travel_single_after_trip_price', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_price' );  // deprecated in 2.0.4
											do_action( 'wp_travel_single_trip_after_price', get_the_ID() );
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Trip Extras Area -->
				<div class="card-footer">
					<div class="row">
						<?php 
						do_action( 'biketravel_tour_facts_hook', get_the_ID() );
						?>
					</div>
				</div>
			</div>
			<div class="container">
				<?php dynamic_sidebar( 'tourpage-widget-1' ); ?>
			</div>
		</section>
		<!-- Tour Tabs Section -->
		<section class="container my-3">
			<?php do_action( 'biketravel_tour_tabs_hook', get_the_ID() ); ?>
		</section>
		<?php //do_action( 'biketravel_tour_gallery_hook' ); ?>
		
		<?php if ( $tourOrgName ) : ?>
		<!-- Tour Organiser Section -->
		<section class="container mt-5">
			<h1 class="bt-display-heading bt-fontprimary text-center">Tour Organiser</h1>
			<hr class="mb-5">
			<div class="row row align-items-center bt-tourguide">
				<div class="col-sm-2">

					<?php if( $tourOrgPhoto ):

						$alt = $tourOrgPhoto['alt'];
						$size = 'thumbnail';
						$thumb = $tourOrgPhoto['sizes'][ $size ];
						
					?>

						<img class="rounded-circle" style="width: 100%; max-width: 200px; margin: auto;" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($alt); ?>"/>
					
					<?php endif; ?>

				</div>
				<div class="col-sm-7 align-middle bt-tourguide-text">
				<h3 class="bt-display-heading bt-fontprimary my-3">
					<?php echo $tourOrgName; ?>, <span style="color:#777"><?php echo $tourOrgDesignation; ?></span></h3>
				<p>
					<?php echo $tourOrgAbout; ?>
				</p>
				</div>
				<div class="col-sm-3 bt-tourguide-facts">
				<p><strong><?php if ( $tourOrgExp ) { echo $tourOrgExp; } ?> Years Experience</strong></p>
				<p><strong>Over <?php if ( $tourOrgTours ) { echo $tourOrgTours; } ?> Tours</strong></p>
				<p><strong><?php if ( $tourOrgFact ) { echo $tourOrgFact; } ?></strong></p>
				</div>
			</div>
			<hr class="my-5">
		</section>
		<?php endif ?>

		<?php do_action( 'biketravel_reviews_section_hook', get_the_ID() ); ?>

		<!-- Similar Tours Section --
		<section class="container mt-5">
			<h1 class="text-center bt-display-heading bt-fontprimary">Similar Tours</h1>
			<div class="row justify-content-center mt-3">
				<!-- Trip Card --
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('https://www.biketravel.co/html-template/images/Asset 13.jpg');">
					<div class="bt-ribbon">
						<span>On Sale!</span>
					</div>
					<div class="bt-tripcard-overlay"></div>
					<div class="row">
						<div class="col text-center" style="display: inline-table;">
						<h3 class="bt-tripcard-title bt-display-heading">Jungle & Mountain Explorer</h3>
						</div>
						</div>
						<div class="row">
						<div class="col bt-tripcard-location text-left"><span><i class="fas fa-map-marker-alt"></i> Cambodia</span></div>
						<div class="col bt-tripcard-duration text-right"><span><i class="fas fa-clock"></i> Days</span></div>
					</div>
					</div>
					<div class="card-body">
					<div class="row">
						<div class="col bt-bookmark">
						<a href="#"><i class="far fa-bookmark"></i></a>
						</div>
						<div class="col bt-star-rating">
						<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i></div></span>
					</div>
					<div class="row">
						<div class="col">
						<p class="card-text"><span style="font-size: 120%; font-weight: bold;"><span style="position: absolute; bottom: 1.5rem; font-size: 70%; color: #999;">from</span>£3495 / </span><span style="color: #777; font-size: 80%;">person</span></p>
						</div>
						<div class="col text-right">
						<a href="#" class="btn btn-outline-primary bt-button-xs">Details</a>
						</div>
					</div>
					</div>
				</div>
				</div>
				<!-- Trip Card --
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('https://www.biketravel.co/html-template/images/Asset 12.jpg');">
					<div class="bt-ribbon">
						<span>On Sale!</span>
					</div>
					<div class="bt-tripcard-overlay"></div>
					<div class="row">
						<div class="col text-center" style="display: inline-table;">
						<h3 class="bt-tripcard-title bt-display-heading">Hidden Himalayas</h3>
						</div>
						</div>
						<div class="row">
						<div class="col bt-tripcard-location text-left"><span><i class="fas fa-map-marker-alt"></i> India</span></div>
						<div class="col bt-tripcard-duration text-right"><span><i class="fas fa-clock"></i> 14 Days</span></div>
					</div>
					</div>
					<div class="card-body">
					<div class="row">
						<div class="col bt-bookmark">
						<a href="#"><i class="far fa-bookmark"></i></a>
						</div>
						<div class="col bt-star-rating">
						<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i></div></span>
					</div>
					<div class="row">
						<div class="col">
						<p class="card-text"><span style="font-size: 120%; font-weight: bold;"><span style="position: absolute; bottom: 1.5rem; font-size: 70%; color: #999;">from</span>£2495 / </span><span style="color: #777; font-size: 80%;">person</span></p>
						</div>
						<div class="col text-right">
						<a href="#" class="btn btn-outline-primary bt-button-xs">Details</a>
						</div>
					</div>
					</div>
				</div>
				</div>
				<!-- Trip Card --
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('https://www.biketravel.co/html-template/images/Asset 8.jpg');">
					<div class="bt-ribbon">
						<span>On Sale!</span>
					</div>
					<div class="bt-tripcard-overlay"></div>
					<div class="row">
						<div class="col text-center" style="display: inline-table;">
						<h3 class="bt-tripcard-title bt-display-heading">Cape Crusader</h3>
						</div>
						</div>
						<div class="row">
						<div class="col bt-tripcard-location text-left"><span><i class="fas fa-map-marker-alt"></i> South Africa</span></div>
						<div class="col bt-tripcard-duration text-right"><span><i class="fas fa-clock"></i> 14 Days</span></div>
					</div>
					</div>
					<div class="card-body">
					<div class="row">
						<div class="col bt-bookmark">
						<a href="#"><i class="far fa-bookmark"></i></a>
						</div>
						<div class="col bt-star-rating">
						<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i></div></span>
					</div>
					<div class="row">
						<div class="col">
						<p class="card-text"><span style="font-size: 120%; font-weight: bold;"><span style="position: absolute; bottom: 1.5rem; font-size: 70%; color: #999;">from</span>£3495 / </span><span style="color: #777; font-size: 80%;">person</span></p>
						</div>
						<div class="col text-right">
						<a href="#" class="btn btn-outline-primary bt-button-xs">Details</a>
						</div>
					</div>
					</div>
				</div>
				</div>

			</div>
		</section>
		-->
	</div>
	<?php if( $hasTourVideo ): ?>
		<!-- Video Modal -->
		<div id="myModal" class="bt-video-modal">
			<span class="close cursor" onclick="closeModal()">&times;</span>
			<div class="bt-video-modal-content">
			
				<div class="bt-iframe-cont">

					<?php echo $tourVideoEmbed ?>
					<!--
					<iframe class="bt-iframe-resp" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					-->
				</div>

			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'wp_travel_after_single_itinerary', get_the_ID() ); ?>
	
	
<?php
  get_footer();
?>