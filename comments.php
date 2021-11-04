<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BikeTravel
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h3 class="comments-title bt-display-heading">
			<?php
			$biketravel_comment_count = get_comments_number();
			if ( '1' === $biketravel_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'biketravel' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $biketravel_comment_count, 'comments title', 'biketravel' ) ),
					number_format_i18n( $biketravel_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h3><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 64,
                    'format' => 'html5',
                    //'max_depth' => 3,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'biketravel' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(
        array(
            'must_log_in'			=> '<p class="must-log-in">'.  sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a comment.', 'biketravel' ), '<a href="'. wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) .'">', '</a>' ) .'</p>',
			'logged_in_as'			=> '<p class="logged-in-as">'. esc_html__( 'Logged in as', 'biketravel' ) .' <a href="'. admin_url( 'profile.php' ) .'">'. $user_identity .'</a>. <a href="' . wp_logout_url( get_permalink() ) .'" title="'. esc_html__( 'Log out of this account', 'biketravel' ) .'">'. esc_html__( 'Log out &raquo;', 'biketravel' ) .'</a></p>',
			'comment_notes_before'	=> false,
			'comment_notes_after'	=> false,
			'comment_field'			=> '<div class="comment-textarea my-3"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="100" class="textarea-comment" placeholder="'. esc_html__( 'Write a comment...', 'biketravel' ) .'"></textarea></div>',
			'id_submit'				=> 'comment-submit',
			'label_submit'			=> esc_html__( 'Post Comment', 'biketravel' ),
        )
    );
	?>

</div><!-- #comments -->
