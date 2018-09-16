<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article uk-background-default uk-margin'); ?>>
	
	<?php  if ( is_single() ) { ?>	
		<?php if ( has_post_thumbnail() ) : ?>
	  	<?php the_post_thumbnail('thumbnail-post', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); ?>
		<?php endif; ?>
	<?php } else { ?>
	  <?php if ( has_post_thumbnail() ) : ?>
		  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			  <?php the_post_thumbnail('thumbnail-post', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); ?>
			</a>
		<?php endif; ?>
	<? }	?>
	
  <div class="cssd-content-header">
	  <?php
	    if ( is_single() ) {
				the_title( '<h1 class="uk-article-title">', '</h1>' );
			} else {
				the_title( '<h2 class="uk-article-title"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
		
		<?php // echo do_shortcode('[rt_reading_time label="Время на чтение:" postfix="Минуты" postfix_singular="Минута"]'); ?>
		
		<?php if ( is_single() ) { ?>
			<p class="uk-text-small">Последнее изменение: <?php the_modified_date('j F Y'); ?> в <?php the_modified_time(); ?> <?php edit_post_link('<span style="position: relative; top: -2px;" uk-icon="icon: cog"></span> Изменить','',''); ?></p>
		<?php } ?>
		
	  <p class="uk-article-meta">
		  Создан: <?php the_time('j F Y'); ?> в <?php the_time(); ?> (<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?>)<br>
		  Категория: <?php printf(__('%s'), get_the_category_list(', ')); ?><br>
		  <?php the_tags(__('Метки: ', 'ccsdrive') . '', ', ', ''); ?>
		</p>
  </div>
	  
	<div class="cssd-content-body">
    <?php if ( is_front_page() || is_category() || is_tag() || is_date() && ! is_single() ) { the_excerpt(); } else { the_excerpt(); the_content(); } ?>
	</div>
	
	<?php if ( is_single() ) { ?>
		<div class="cssd-content-footer">
		  <a class="uk-text-meta" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
			  <?php echo get_avatar( get_the_author_meta('user_email'), 24, '', '', array('class'=>'uk-margin-small-right uk-border-rounded', 'extra_attr'=>'style="margin-top: -4px;"')); ?><?php the_author(); ?>
			</a>
	  </div>
  <?php } ?>
  
  <?php if ( is_home() ) { ?>
	  <div class="cssd-content-footer">
	    <div class="uk-grid-small" uk-grid>
		    <div><a class="uk-button uk-button-text" href="<?php the_permalink() ?>#comments"> Комментариев <span uk-icon="icon: commenting; ratio:0.9;"></span> <?php comments_number('0', '1', '%'); ?></a></div>
	      <div><a class="uk-button uk-button-text" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Подробнее</a></div>
	    </div>
	  </div>
  <?php } ?>
  
</article>