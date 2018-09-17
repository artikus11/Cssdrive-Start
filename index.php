<?php get_header(); ?>

<div class="uk-section uk-section-small">
	<div class="uk-container">
	
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<h1 class="uk-h1"><?php single_post_title(); ?></h1>
		<?php else : ?>
			<h2 class="uk-h2"><?php _e( 'Posts', 'cssdrive' ); ?></h2>
		<?php endif; ?>
		
		<div id="primary" class="content-area">
		  <main id="main" class="site-main" role="main">
			  
			  <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) :the_post(); ?>
					  <?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>		
					<?php endwhile; ?>
				<?php else : ?>
	        <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
				<?php endif; ?>
			
		  </main>
		</div>
		
	</div>
</div>

<?php get_footer(); ?>