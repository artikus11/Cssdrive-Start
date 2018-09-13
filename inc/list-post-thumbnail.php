<?php

/*------------------------------------------------------------------
  Колонка миниатюры в списке записей админки
-------------------------------------------------------------------*/
	
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Миниатюра');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
	if($column_name === 'riv_post_thumbs'){ ?>
    <img src="<?php the_post_thumbnail('thumbnail', array(50,50)); ?>">  
<?php }} ?>