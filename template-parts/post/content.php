<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( is_sticky() && is_home() ) { ?>
	  <div class="uk-container uk-container-small uk-margin">
		  <span uk-icon="icon: bell"></span> Закреплена
	  </div>
	<?php }	?>
	
	<header class="entry-header uk-container uk-container-small">	
	  <? if ( is_single() ) {
				the_title( '<h1 class="uk-h1 entry-title">', '</h1>' );
			} elseif ( is_front_page() && is_home() ) {
				the_title( '<h3 class="uk-h1 entry-title"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			} else {
				the_title( '<h2 class="uk-h1 entry-title"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
		<div class="entry-meta uk-margin">
			<ul class="uk-article-meta uk-child-width-auto@m uk-grid-small uk-flex-middle" uk-grid>
				<li><span uk-icon="icon: calendar"></span> <?php the_time('d.m.Y'); ?></li>
				<li><span uk-icon="icon: user"></span> <a class="uk-text-meta" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author(); ?></a></li>
				<li><span uk-icon="icon: comments"></span> <a class="uk-text-meta" href="<?php the_permalink() ?>#comments"><?php comments_number('Добавить комментарий', '1 Комментарий', '% Комментария'); ?></a></li>
				<li><?php printf(__('<span uk-icon="icon: bookmark"></span> %s', 'cssdrive'), get_the_category_list(', ')); ?></li>
				<li><?php the_tags(__('<span uk-icon="icon: tag"></span> ', 'thefubon') . '', ', ', ''); ?></li>
			</ul>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail uk-margin">
			<?php if ( has_post_thumbnail() ) : ?>
			  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				  <?php the_post_thumbnail('large', ['class' => 'attachment-post-thumbnail size-post-thumbnail uk-width-1-1', 'uk-img' => '']); ?>
				</a>
			<?php endif; ?>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	
	<div class="entry-content uk-margin">
	  <?php if ( is_front_page() || is_category() || is_tag() || is_date() && ! is_single() ) { ?>
	    <?php the_excerpt(); ?>
	  <?php } else { ?>
	    <?php the_excerpt(); ?>
	    <?php the_content(); ?>
	  <?php } ?>
	</div><!-- .entry-content -->
	
	<div class="entry-footer uk-container uk-container-small uk-margin">
	  <?php if ( is_single() ) { ?>
			<a class="uk-text-meta" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
			  <?php echo get_avatar( get_the_author_meta('user_email'), 24, '', '', array('class'=>'uk-margin-small-right uk-border-rounded', 'extra_attr'=>'style="margin-top: -4px;"')); ?><?php the_author(); ?>
			</a>
		  <?php edit_post_link('<span uk-icon="icon: pencil"></span> Изменить','',''); ?>  
		<?php } else { ?>
			<a class="uk-button uk-button-text uk-button-small" href="<?php the_permalink() ?>" rel="bookmark">
				<?php esc_attr_e( 'Read more', 'cssdrive' ); ?>
			</a>
		<?php }	?>
	</div><!-- .entry-footer -->
	
</article><!-- #post-## -->