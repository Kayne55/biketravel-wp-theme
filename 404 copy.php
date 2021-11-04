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

		<div class="row">

			<div class="col-12">

				<h1 class="bt-display-heading bt-fontprimary text-center" style="font-size: 8rem;">404 <span><i class="fas fa-exclamation"></i></span></h1>
				<h3 class="bt-display-heading bt-fontprimary text-center">The page you are looking for cannot be found.</h3>

				<h3 class="bt-display-heading bt-fontprimary text-center">You could try a search:</h3>
				<div class="text-center">
					<?php get_search_form(); ?>
				</div>

			</div>

		</div>
		
	</section>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'TEST Oops! That page can&rsquo;t be found.', 'biketravel' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'biketravel' ); ?></p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'biketravel' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					$biketravel_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'biketravel' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$biketravel_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
