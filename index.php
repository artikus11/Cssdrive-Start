<?php get_header(); ?>

<main id="main" class="site-main uk-section uk-section-small" role="main">
	<div class="uk-container">
		<div class="uk-grid-medium" uk-grid>
			<div class="uk-width-expand@m">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
				<?php endif; ?>
			</div>
			<div class="uk-width-1-4@m">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>