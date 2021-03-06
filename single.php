<?php get_header(); ?>
	<div class="wrap">
		<div id="primary" class="content-area">
		  <main id="main" class="site-main" role="main">
			  <?php while ( have_posts() ) : the_post(); ?>
			  
					<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					
					<?php if ( comments_open() || get_comments_number() ) : ?>
					  <div class="comments-container uk-section uk-section-small">
						  <?php comments_template(); ?>
					  </div>
					<?php endif; ?>
					
				<?php endwhile; ?>
		  </main>
		</div>
	</div>
<?php get_footer(); ?>