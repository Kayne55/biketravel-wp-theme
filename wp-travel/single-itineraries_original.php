<?php
	get_header();

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	// register global vars
	$tourHeroIMG = get_field('background_hero_image');
	$hasTourVideo = get_field('has_tour_video');
	$tourVideoEmbed = get_field('tour_video_embed');
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
			<div class="col col-sm-4 col-lg-2">
				<h5><i class="fas fa-map-marker-alt"></i> South Africa</h5>
			</div>
			<div class="col col-sm-4 col-lg-2">
				<h5><i class="fas fa-clock"></i>14 Days</h5>
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
						<div class="row" style="height: 100%;">
							<!-- Trip Heading & Description -->
							<div class="col-lg-8 bt-trip-details">
								<?php wp_travel_do_deprecated_action( 'wp_travel_after_single_title', array( get_the_ID() ), '2.0.4', 'wp_travel_single_trip_after_title' );  // @since 1.0.4 and deprecated in 2.0.4 ?>
								<?php do_action( 'wp_travel_single_trip_after_title', get_the_ID() ) ?>
							</div>
							<!-- Rating / Price-->
							<div class="col-lg-4">

							</div>
						</div>
					</div>
				</div>
			</div>


				<!-- Trip Extras Area -->
				<div class="card-footer">
				<div class="row">
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-route"></i> Distance: </strong>
						2700km
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-mountain"></i> Terrain: </strong>
						Blacktop & Gravel (approx 65:35)
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-clock"></i> Duration: </strong>
						14 Days
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-life-ring"></i> Support: </strong>
						Fully Supported
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-award"></i> Standard: </strong>
						Premium
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-compass"></i> Guided: </strong>
						Yes
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-motorcycle"></i> Motorcycles: </strong>
						KTM 790 Adventure R, KTM 1290 Super Adventure R
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-plane-arrival"></i> Fly In: </strong>
						Cape Town, South Africa
						</p>
					</small>
					</div>
					<div class="col-sm-4">
					<small class="text-muted">
						<p>
						<strong><i class="fas fa-plane-departure"></i> Fly Out: </strong>
						Port Elizabeth, South Africa
						</p>
					</small>
					</div>
				</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
				<div class="col bt-share-sm">
					<span>
					Share it: 
					<a href="#">
						<i class="fab fa-whatsapp"></i>
					</a>
					<a href="#">
						<i class="fab fa-facebook-messenger"></i>
					</a>
					<a href="#">
						<i class="fab fa-instagram"></i>
					</a>
					<a href="#">
						<i class="fab fa-facebook"></i>
					</a>
					<a href="#">
						<i class="fab fa-twitter"></i>
					</a>
					</span>
				</div>
				</div>
			</div>
		</section>

		<!-- Tour Tabs Section -->
		<section class="container my-3">
			<div class="row">
				<div class="col">
				<nav>
					<div class="nav nav-pills justify-content-center" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Tour Overview</a>
					<a class="nav-item nav-link" id="itinerary-tab" data-toggle="tab" href="#itinerary" role="tab" aria-controls="itinerary" aria-selected="false">Detailed Itinerary</a>
					<a class="nav-item nav-link" id="includes-excludes-tab" data-toggle="tab" href="#includes-excludes" role="tab" aria-controls="includes-excludes" aria-selected="false">Inclusions &amp; Exclusions</a>
					<a class="nav-item nav-link" id="highlights-tab" data-toggle="tab" href="#highlights" role="tab" aria-controls="highlights" aria-selected="false">Tour Highlights</a>
					<a class="nav-item nav-link" id="motorcycles-tab" data-toggle="tab" href="#motorcycles" role="tab" aria-controls="motorcycles" aria-selected="false">The Motorcycles</a>
					<a class="nav-item nav-link" id="faqs-tab" data-toggle="tab" href="#faqs" role="tab" aria-controls="faqs" aria-selected="false">FAQs</a>
					</div>
				</nav>
				<div class="tab-content py-4 bt-tour-tabs" id="nav-tabContent">
					<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">              
					<h3 class="bt-display-heading">Tour Overview</h3>
					<p>
						sit amet consectetur adipisicing elit. Aperiam harum ipsum expedita pariatur quibusdam, mollitia, reprehenderit explicabo facilis autem libero iusto maiores dolorum alias recusandae voluptate ratione aut asperiores? Repellat.
					<h4 class="bt-display-heading">Laudantium</h4>
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium vero delectus autem cumque nobis, sapiente, veniam similique iste minima a error atque voluptatibus corrupti. Voluptatum possimus perferendis vero dignissimos dolor.
					</p>
					</div>
					<div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
					<div class="accordion" id="accordionExample">
						<div class="card">
						<div class="card-header" id="headingOne">
							<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Day 1: Welcome to Cape Town
							</button>
							</h2>
						</div>
					
						<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
								<img src="https://biketravel.co/wp-content/uploads/2020/05/Cape-Town-Motorcycle-Tour-300x200-1-150x150.jpg">
								</div>
								<div class="col-sm-9">
								<p>
									The first day of the tour starts with your arrival at Cape Town International Airport. You’ll be met from the plane and transferred directly to your hotel in the heart of the city. Once you’ve checked in it’s a chance to relax after the long flight. In the afternoon we’ll get all the riders together to meet the team and give you a full briefing of the exciting motorcycle adventure ahead.
								</p>
								<p>
									We’ll then venture out to the waterfront for a welcome dinner overlooking the harbour.
								</p>
									<span style="color:#00B2AF;font-weight: bold">Accommodation:</span> 4* hotel with a pool.
								</p>
								<p>
									<span style="color:#00B2AF;font-weight: bold">Meals:</span> Dinner
								</p>
								</div>
							</div>
							</div>
						</div>
						</div>
						<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Day 2: Cape Town Acclimatisation Day
							</button>
							</h2>
						</div>
						<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							<div class="card-body">
							<div class="col-sm-3">
								<img src="https://biketravel.co/wp-content/uploads/2020/05/South-Africa-Guided-Motorcycle-Tours-09-300x169-1-150x150.jpg" alt="">
							</div>
							<div class="col-sm-9">
								<p>
								So, you can’t be in Cape Town and not go up onto Table Mountain – it’s one of the most iconic sights in Africa and apparently older than the Himalayas, though there are no eye witnesses to confirm. So, after breakfast we’ll take you to the gently rotating cable car  that climbs steeply to the top. It’s a massive and stunning area that you can explore and you might even get a photo with a Dassie and of course the obligatory selfie!
								Once descended from the mountain, you’ve got some time to explore Cape Town before collecting the BMW motorcycles later in the afternoon.
								</p>
								<p>
								<span style="color:#00B2AF;font-weight: bold">Accommodation:</span> 4* hotel with a pool.
								</p>
								<p>
								<span style="color:#00B2AF;font-weight: bold">Meals:</span> Breakfast
								</p>
							</div>
							</div>
						</div>
						</div>
						<div class="card">
						<div class="card-header" id="headingThree">
							<h2 class="mb-0">
							<button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Day 3: Cape Town to Hermanus 240km
							</button>
							</h2>
						</div>
						<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
							<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
								<img src="https://biketravel.co/wp-content/uploads/2020/05/South-Africa-Guided-Motorcycle-Tours-11-300x168-1-150x150.jpg" alt="">
								<p>
									It’s the first riding day of this South African motorcycle tour, so today the real adventure begins! So, hop on and thumb the starter… We’ll start the day with a trip down the fantastic Cape peninsula and following stunning coastal roads down to the historic Cape of Good Hope. We then follow the coast east through picturesque coastal towns and villages all the way to Hermanus for our first stop. Along the way we will stop to visit a penguin colony at ‘Betty’s Bay’. 
								</p>
								<p>
									Accommodation: Guesthouse with sea views.
								</p>
								<p>
									Meals: Breakfast, lunch and dinner
								</p>
								</div>
							</div>
							</div>
						</div>
						</div>
					</div>
					</div>
					<div class="tab-pane fade" id="includes-excludes" role="tabpanel" aria-labelledby="includes-excludes-tab">
					<h3 class="bt-display-heading">Includsions</h3>
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste quo doloribus unde officiis reiciendis. Nemo aspernatur porro id, doloribus et officiis consectetur, doloremque animi molestiae quasi, nesciunt tenetur deleniti dolores.
					</p>
					<h3 class="bt-display-heading">Exclusions</h3>
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste quo doloribus unde officiis reiciendis. Nemo aspernatur porro id, doloribus et officiis consectetur, doloremque animi molestiae quasi, nesciunt tenetur deleniti dolores.
					</p>
					</div>
					<div class="tab-pane fade" id="highlights" role="tabpanel" aria-labelledby="highlights-tab">
					<h3 class="bt-display-heading">Tour Highlights</h3>
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste quo doloribus unde officiis reiciendis. Nemo aspernatur porro id, doloribus et officiis consectetur, doloremque animi molestiae quasi, nesciunt tenetur deleniti dolores.
					</p>
					</div>
					<div class="tab-pane fade" id="motorcycles" role="tabpanel" aria-labelledby="motorcycles-tab">
					<h3 class="bt-display-heading">The Motorcycles</h3>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste quo doloribus unde officiis reiciendis. Nemo aspernatur porro id, doloribus et officiis consectetur, doloremque animi molestiae quasi, nesciunt tenetur deleniti dolores.
					</div>
					<div class="tab-pane fade" id="faqs" role="tabpanel" aria-labelledby="faqs-tab">
					<h3 class="bt-display-heading">FAQs</h3>
					<div class="accordion" id="accordionExample">
						<div class="card">
						<div class="card-header" id="headingOne">
							<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Question 1?
							</button>
							</h2>
						</div>
					
						<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero sed dolorem harum obcaecati iste voluptatum delectus ratione reiciendis tempora earum. Cum eligendi voluptas quas ipsam maiores quisquam. Necessitatibus, quibusdam doloribus?</p>
							</div>
						</div>
						</div>
						<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Question 2?
							</button>
							</h2>
						</div>
						<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							<div class="card-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta unde dolor quod, ipsa ut, numquam sed iure quibusdam eveniet vitae necessitatibus quo illo nemo magni sunt exercitationem expedita, temporibus quos?</p>
							</div>
						</div>
						</div>
						<div class="card">
						<div class="card-header" id="headingThree">
							<h2 class="mb-0">
							<button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Question 3?
							</button>
							</h2>
						</div>
						<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
							<div class="card-body">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque aut harum illo quidem, debitis sint mollitia voluptate porro quod, aliquid ipsum pariatur earum ipsa placeat quae officiis odio? Rerum, magni?
							</p>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
				</div>
			</div>
		</section>

		<!-- Tour Gallery Section -->
		<section class="container">
			<h1 class="bt-display-heading bt-fontprimary text-center">Tour Gallery</h1>
			<div class="row bt-tour-gallery">
				<div class="col-md-4">
				<img src="/biketravel-html-theme/images/gallery/20191104_084159.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/20191104_174420.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/20191106_100450.jpg" alt="">
				
				<img src="/biketravel-html-theme/images/gallery/IMG_6006.jpg" alt="">
				</div>
				<div class="col-md-4">
				<img src="/biketravel-html-theme/images/gallery/IMG_5997.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/IMG_9046.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/IMG_9417.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/IMG_9430.jpg" alt="">
				</div>
				<div class="col-md-4">
				<img src="/biketravel-html-theme/images/gallery/Screenshot 2019-11-18 at 15.44.25.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/Screenshot 2019-11-18 at 15.55.38.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/Screenshot 2019-11-18 at 16.17.32.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/Screenshot 2019-11-20 at 08.22.00.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/Screenshot 2019-11-20 at 08.51.23.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/20191108_120735.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/20191108_154525-PANO.jpg" alt="">
				<img src="/biketravel-html-theme/images/gallery/IMG_5925.jpg" alt="">
				</div>
			</div>
		</section>

		<!-- Tour Guide Section -->
		<section class="container">
			<hr class="my-5">
			<div class="row row align-items-center bt-tourguide">
				<div class="col-sm-2">
				<img class="rounded-circle" style="width: 100%; max-width: 200px; margin: auto;" src="/biketravel-html-theme/images/P1244732.jpg" alt="">
				</div>
				<div class="col-sm-7 align-middle bt-tourguide-text">
				<h3 class="bt-display-heading bt-fontprimary my-3">Nono, <span style="color:#777">Tour Guide</span></h3>
				<p>
					Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita modi rerum rem illo, obcaecati alias, quibusdam neque distinctio nemo et.
				</p>
				</div>
				<div class="col-sm-3 bt-tourguide-facts">
				<p><strong>8 Years Experience</strong></p>
				<p><strong>Over 100 Tours</strong></p>
				<p><strong>Loves Bunnies</strong></p>
				</div>
			</div>
			<hr class="my-5">
		</section>

		<!-- Similar Tours Section -->
		<section class="container mt-5">
			<h1 class="text-center bt-display-heading bt-fontprimary">Similar Tours</h1>
			<div class="row justify-content-center mt-3">
				<!-- Trip Card -->
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('/biketravel-html-theme/images/Asset 13.jpg');">
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
				<!-- Trip Card -->
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('/biketravel-html-theme/images/Asset 12.jpg');">
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
				<!-- Trip Card -->
				<div class="col-lg-4">
				<div class="card bt-tripcard bt-tripcard-grid">
					<div class="bt-tripcard-grid-image" style="background-image: url('/biketravel-html-theme/images/Asset 8.jpg');">
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
	</div>
	<?php if( $hasTourVideo ): ?>
		<!-- Video Modal -->
		<div id="myModal" class="bt-video-modal">
			<span class="close cursor" onclick="closeModal()">&times;</span>
			<div class="bt-video-modal-content">
			
				<div class="mySlides">
					<div class="bt-iframe-cont">

						<?php echo $tourVideoEmbed ?>
						<!--
						<iframe class="bt-iframe-resp" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						-->
					</div>
				</div>

			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'wp_travel_after_single_itinerary', get_the_ID() ); ?>
	
	
<?php
  get_footer();
?>