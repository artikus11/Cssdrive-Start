<?php get_header(); ?>

<main id="main" class="site-main uk-section uk-section-xsmall" role="main">
	<div class="uk-container">
		
		<div class="uk-margin-small-bottom">
			<?php the_archive_title( '<h2 class="page-title uk-margin-remove">', '</h2>' ); ?>
			<?php the_archive_description( '<div class="taxonomy-description uk-text-small">', '</div>' ); ?>
		</div>
		
		<div class="uk-grid-medium" uk-grid>
			<div class="uk-width-expand@m">
				
				<div class="uk-section uk-section-xsmall uk-section-default uk-padding-small">
					<?php
					  $getcat = get_the_category();
					  $cat = $getcat[0]->cat_ID; //  получаем ID активной категории
					  echo 'Количество постов в категории: ', wp_get_cat_postnum($cat);
					?>
				</div>
				
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					<?php endwhile; ?>
					
					<?php post_navigarion(); ?>
					
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