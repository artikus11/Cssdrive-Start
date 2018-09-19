<?php get_header(); ?>

<div class="uk-section uk-section-small">
	<div id="primary" class="content-area">
	  <main id="main" class="site-main uk-container" role="main">
		  
		  <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) :the_post(); ?>
				  СТРАНИЦА
				<?php endwhile; ?>
			<?php else : ?>
        <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
			<?php endif; ?>
		
	  </main>
	</div>
</div>

<?php get_footer(); ?>