<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BikeTravel
 */

get_header();
?>

	<section class="container">

		<div class="row align-content-center justify-content-md-center" style="min-height: 65vh;">

			<div class="col-12 my-3">

				<!--<h1 class="bt-display-heading bt-fontprimary text-center" style="font-size: 8rem;">404 <span><i class="fas fa-exclamation"></i></span></h1>-->
				<h1 class="bt-display-heading bt-fontprimary text-center">The page you are looking for cannot be found.</h1>

			</div>
			<div class="col-md-4 my-3">
				<h3 class="bt-display-heading bt-fontprimary text-center">You could try a search:</h3>
				<?php get_search_form(); ?>
			</div>
			<div class="col-12 text-center my-3">
				<a href="<?php echo get_home_url(); ?>" class="btn btn-primary btn-lg" role="button">Return to Home Page</a>
			</div>
		</div>
		
	</section>

    <!-- General Footer Wiget Area -->
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <?php dynamic_sidebar( 'general-footer-area-1' ); ?>
            </div>
        </div>
    </div>


<?php
get_footer();
