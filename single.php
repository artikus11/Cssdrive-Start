<?php get_header(); ?>

<main id="main" class="site-main uk-section uk-section-xsmall" role="main">
	<div class="uk-container">
		
		<div class="uk-grid-medium" uk-grid>
			<div class="uk-width-expand@m">
				<?php while ( have_posts() ) : the_post(); ?>	
				  
				  <?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
				  
				  <div class="navigation post-navigation uk-section uk-section-small uk-section-default uk-margin uk-border-rounded"  role="navigation">
						<div class="uk-padding uk-padding-remove-vertical">
							<ul class="uk-child-width-expand uk-grid-divider" uk-grid>
								
								<?php $prev_post = get_previous_post(); if( ! empty($prev_post) ){ ?>
									<li class="nav-previous uk-text-center">
										<a class="uk-link-reset" href="<?php echo get_permalink( $prev_post->ID ); ?>" rel="prev">
											<div class="uk-inline-clip uk-transition-toggle uk-light">
							        	<?php echo get_the_post_thumbnail($prev_post->ID, array(100,100) ); ?>
							        	<div class="uk-position-center uk-transition-fade uk-overlay uk-overlay-primary">
						                <span class="uk-transition-fade uk-transition-slide-right-small" uk-icon="icon: arrow-left; ratio: 2"></span>
						            </div>
											</div>
								        </a>
								        <h2 class="uk-h4">
									        <a class="uk-link-reset" href="<?php echo get_permalink( $prev_post->ID ); ?>" rel="prev">
										        <?php echo $prev_post->post_title; ?>
									        </a>
									    </h2>
								    </li>
							    <?php } ?>
							    
							    <?php $next_post = get_next_post(); if( ! empty($next_post) ){ ?>
									<li class="nav-next uk-text-center">
										<a class="uk-link-reset" href="<?php echo get_permalink( $next_post->ID ); ?>" rel="next">
											<div class="uk-inline-clip uk-transition-toggle uk-light">
												<?php echo get_the_post_thumbnail($next_post->ID, array(100,100) ); ?>
							        	<div class="uk-position-center uk-transition-fade uk-overlay uk-overlay-primary">
						               <span class="uk-transition-fade uk-transition-slide-left-small" uk-icon="icon: arrow-right; ratio: 2"></span>
						            </div>
											</div>
										</a>
										<h2 class="uk-h4">
											<a class="uk-link-reset" href="<?php echo get_permalink( $next_post->ID ); ?>" rel="next">
												<?php echo $next_post->post_title; ?>
											</a>
										</h2>
									</li>
								<?php } ?>
								
							</ul>
						</div>
					</div>
					
					<article class="uk-comment uk-background-default uk-margin uk-padding">
						<?php if ( comments_open() || get_comments_number() ) : ?>
							<div class="uk-comment-body">
								<?php comments_template(); ?>
							</div>
						<?php endif; ?>
					</article>
  
				<?php endwhile;?>
				
				
			</div>
			<div class="uk-width-1-4@m">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>