<?php get_header(); ?>
	<div class="wrap">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header uk-container uk-container-small uk-margin">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php else : ?>
			<header class="page-header uk-container uk-container-small uk-margin">
				<h2 class="page-title"><?php _e( 'Posts', 'cssdrive' ); ?></h2>		
			</header>
		<?php endif; ?>	
		<div id="primary" class="content-area">
		  <main id="main" class="site-main" role="main"> 
			  <?php if ( have_posts() ) : ?>
	        <?php while ( have_posts() ) :the_post(); ?>
					  <?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php posts_pagination(); ?>
				<?php else : ?>
	        <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
				<?php endif; ?>
		  </main>
		</div>	
	</div>
<?php get_footer(); ?>