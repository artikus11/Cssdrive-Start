<?php if ( post_password_required() ) { return; } ?>

<div id="comments" class="comments-area uk-container uk-container-small">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
	?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'cssdrive' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'cssdrive'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h2>

		<ul class="comment-list uk-list uk-list-large uk-comment-list">
			<?php
				wp_list_comments(
					array(
						/*
							'avatar_size' => 100,
						  'style'       => 'ol',
						  'short_ping'  => true,
						  'reply_text'  => __( 'Reply', 'cssdrive' ),
						*/
						'callback' => 'cssd_comment', // Кастомный шаблон комментариев - /inc/ajax-comments.php
					)
				);
			?>
		</ul>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'cssdrive' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'cssdrive' ) . '</span>',
			)
		);

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'cssdrive' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->