<?php
/**
 * Itinerary Archive Template
*/

// register global vars
$objectName = get_queried_object()->name;
$post_id = get_queried_object()->taxonomy . "_" . get_queried_object()->term_id;
$catHeaderIMG = get_field('background_image', $post_id);
$hasCatVideo = get_field('has_cat_video', $post_id);
$tourVideoEmbed = get_field('cat_video_link', $post_id);
$catShortDesc = get_field('short_description', $post_id);
$catLongDesc = get_field('category_long_description', $post_id);

// FAQs
$catTheRiding = get_field('cat_whats_the_riding_like', $post_id);
$catMotorcycles = get_field('cat_common_motorcycles', $post_id);
$catTimeOfYear = get_field('cat_best_times_of_year', $post_id);
$catSafety = get_field('cat_touring_safe', $post_id);
$catLicense = get_field('cat_motorcycle_license', $post_id);
$catIdp = get_field('cat_idp', $post_id);
$catVaccines = get_field('cat_vaccinations', $post_id);
$catVisa = get_field('cat_visa', $post_id);

// Reasons to Ride in Country
$catReason1 = get_field('reason_1', $post_id);
$catReason2 = get_field('reason_2', $post_id);
$catReason3 = get_field('reason_3', $post_id);
$catReason4 = get_field('reason_4', $post_id);
$catReason5 = get_field('reason_5', $post_id);

//$catVideoEmbed = get_field('cat_video_link', $post_id);

get_header( 'itinerary' ); ?>

		<!-- Header Banner -->
		<div class="jumbotron jumbotron-fluid bt-jumbo-header" style="background-image: url(
			<?php if( $catHeaderIMG ): ?>
				<?php echo $catHeaderIMG['url']; ?>
			<?php else : ?>
				<?php the_post_thumbnail_url( 'full' ) ?>
			<?php endif; ?>
			); min-height: 250px;"
		>
			<div class="bt-overlay-30"></div>
			<div class="container">
				<h1 class="display-1">
					<?php
						//echo 'Motorcycle Tours - ' . $objectName;
					 	
						if ( get_queried_object()->taxonomy === 'itinerary_types' ) {
							echo $objectName . ' Motorcycle Tours';
						} elseif ( get_queried_object()->taxonomy === 'activity' ) {
							echo $objectName . ' Motorcycle Tours';
						} elseif ( get_queried_object()->taxonomy === 'travel_locations' ) {
							echo 'Motorcycle Tours in ' . $objectName;
						} else {
							echo 'Motorcycle Tours';
						}
						
					?>
				</h1>

				<?php
					//For testing - check the taxonomy / category and ID of the requested page:
					//echo get_queried_object()->taxonomy . "_" . get_queried_object()->term_id;
					//echo $objectName;
					//echo get_queried_object()->taxonomy;
				?>

				<div class="row">
				<div class="col-lg-8">
					<!-- Add the Short Description Here -->
					
					<?php 
					///	if( $catShortDesc ) {
					///		echo $catShortDesc;
					///	}
						the_archive_description( '<div class="taxonomy-description">', '</div>' ); 
					?>
				</div>
				<?php if( $hasCatVideo ): ?>
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

<?php if ( get_queried_object()->taxonomy === 'travel_locations' ) : ?>
	<?php if ( $catLongDesc ) : ?>
		<section class="container">
			<?php echo $catLongDesc; ?>
		</section>
	<?php endif; ?>
<?php endif; ?>
			
<section class="container">
	<?php do_action( 'biketravel_archive_toolbar_hook' ); ?>
	<div class="col-12 text-center bt-more-filters">
		<button id="bt-fullscreenNav" class="btn btn-outline-primary" onclick="fullScreenNav()">More Filters</button>
	</div>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php wp_travel_get_template_part( 'content', 'archive-itineraries' ); ?>
		<?php endwhile; // end of the loop. ?>
	<?php else : ?>
		<?php wp_travel_get_template_part( 'content', 'archive-itineraries-none' ); ?>
	<?php endif; ?>
</section>

<?php if ( get_queried_object()->taxonomy === 'travel_locations' ) : ?>
	<section class="container my-3">
		<div class="row">
			<div class="col-12">
				<?php if ( $catTheRiding ) : ?>
					<h2 class="bt-display-heading bt-fontprimary text-center mt-5"><?php echo $objectName; ?> - FAQ's</h2>
					<button class="bt-accordion-heading">What's the Riding Like?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catTheRiding; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catMotorcycles ) : ?>
					<button class="bt-accordion-heading">What are the best motorcycles for touring in <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catMotorcycles; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catTimeOfYear ) : ?>
					<button class="bt-accordion-heading">What are the best times of year to ride in <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catTimeOfYear; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catSafety ) : ?>
					<button class="bt-accordion-heading">Is motorcycle touring in <?php echo $objectName; ?> safe?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catSafety; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catLicense ) : ?>
					<button class="bt-accordion-heading">Do I need a motorcycle license to ride in <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catLicense; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catIdp ) : ?>
					<button class="bt-accordion-heading">Do I need an international driving permit (IDP) to ride in <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catIdp; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catVaccines ) : ?>
					<button class="bt-accordion-heading">Do I need vaccinations to visit <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catVaccines; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catVisa ) : ?>
					<button class="bt-accordion-heading">Do I need a visa to visit <?php echo $objectName; ?>?</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catVisa; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<?php if ( $catReason1 ) : ?>
					<h2 class="bt-display-heading bt-fontprimary text-center mt-5">5 Reasons to Ride in <?php echo $objectName; ?></h2>
					<button class="bt-accordion-heading">Reason 1</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catReason1; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catReason2 ) : ?>
					<button class="bt-accordion-heading">Reason 2</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catReason2; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catReason3 ) : ?>
					<button class="bt-accordion-heading">Reason 3</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catReason3; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catReason4 ) : ?>
					<button class="bt-accordion-heading">Reason 4</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catReason4; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $catReason5 ) : ?>
					<button class="bt-accordion-heading">Reason 5</button>
					<div class="bt-accordion-content">
						<div class="bt-accordion-content-inner">
							<?php echo $catReason5; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php do_action( 'wp_travel_after_main_content' ); ?>
<?php do_action( 'wp_travel_archive_listing_sidebar' ); ?>

<div id="bt-NavOverlay">
	<div class="row justify-content-md-center">
		<div class="bt-NavOverlayClose col-12">
			<i class="fas fa-times" onclick="fullScreenNavClose()"></i>
			<br>
			<small>Close</small>
		</div>
		<div class="bt-NavOverlayContent col-lg-6">
			<?php dynamic_sidebar( 'tour-archive-filters-1' ); ?>
		</div>
	</div>
</div>

<?php if ( $hasTourVideo ) : ?>
	<!-- Video Modal -->
	<div id="myModal" class="bt-video-modal">
		<span class="close cursor" onclick="closeModal()">&times;</span>
		<div class="bt-video-modal-content">
		
			<div class="bt-iframe-cont">

				<?php echo $tourVideoEmbed ?>

			</div>

		</div>
	</div>
<?php endif; ?>
<?php get_footer(); ?>