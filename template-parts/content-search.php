<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BikeTravel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="container bt-archive">
	<div class="row my-5">
		<div class="col-sm-2">
			<img class="img-thumbnail img-fluid" src="<?php the_post_thumbnail_url( 'thumbnail' ); ?>" alt="<?php the_title(); ?>">
		</div>
		<div class="col-sm-10">
			<?php the_title( sprintf( '<h2 class="bt-display-heading bt-fontprimary"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			
			<?php if ( 'post' === get_post_type() ) : ?>
				<small>
					<i class="far fa-user-circle"></i> <?php the_author(); ?> - <i class="far fa-clock"></i> <?php the_date(); ?> - <i class="far fa-folder"></i> <?php the_category(', '); //$category = get_the_category(); echo $category[0]->cat_name; ?> - <i class="far fa-comment"></i> <?php comments_number(); ?>
				</small>
			<?php endif; ?>
			<p>
				<?php the_excerpt(); ?>
			</p>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

