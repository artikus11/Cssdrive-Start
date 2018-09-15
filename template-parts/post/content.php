<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article edit-post'); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
	  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		  <?php the_post_thumbnail('thumbnail-post', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); ?>
		</a>
	<?php endif; ?>
	
	<h1 class="uk-article-title"><a class="uk-link-reset" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
	
	<p class="uk-article-meta">Автор <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), 24, '', '', array('class'=>'', 'extra_attr'=>'style="margin-top: -4px;"')); ?><?php the_author(); ?></a> Дата <?php the_date(); ?> (<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?>). Категория <?php printf(__('%s'), get_the_category_list(', ')); ?> <?php edit_post_link('<span style="position: relative; top: -2px;" uk-icon="icon: cog"></span> Изменить','',''); ?></p>
  
  <?php the_excerpt(); ?>
  
  <div class="cssd-content">
	  <?php the_content(); ?>
  </div>
  
  <div class="uk-grid-small" uk-grid>
    <div><a class="uk-button uk-button-text" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Подробнее</a></div>
    <div> <a class="uk-button uk-button-text" href="<?php the_permalink() ?>#comments"> Комментариев <span uk-icon="icon: commenting; ratio:0.9;"></span> <?php comments_number('0', '1', '%'); ?></a></div>
  </div>
  
</article>





