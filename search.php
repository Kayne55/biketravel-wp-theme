<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package BikeTravel
 */

get_header();
?>

	<main id="primary" class="container my-4">

		<div class="row my-3">
			<div class="col-12 my-4">
				<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>

			<h1 class="bt-display-heading bt-fontprimary" style="text-transform: uppercase;">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'biketravel' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		<div class="container">
			<div class="row my-4">
				<div class="col-6 text-left">
					<?php next_posts_link( '<i class="fas fa-chevron-left"></i> Older posts' ); ?>
				</div>
				<div class="col-6 text-right">
					<?php previous_posts_link( 'Newer posts <i class="fas fa-chevron-right"></i>' ); ?>
				</div>
			</div>
		</div>

		<!-- General Footer Wiget Area -->
		<div class="container">
			<div class="row my-3">
				<div class="col-12">
					<?php dynamic_sidebar( 'general-footer-area-1' ); ?>
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
