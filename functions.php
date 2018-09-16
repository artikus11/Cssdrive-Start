<?php
	
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/*------------------------------------------------------------------
  Настройки WordPress
-------------------------------------------------------------------*/

function cssd_setup() {
	
	// Header
	add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  
  //  Миниатюры
  add_theme_support( 'post-thumbnails' );
  
  // Меню
  register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'cssd' ),
		)
	);
	
	// Настройки динамичного контента
	add_theme_support(
		'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	
	// Подключаем форматы постов
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	));
	
	// Подключаем управление фоном
	add_theme_support('custom-background', apply_filters( 'cssdrive_custom_background_args', array(
		'default-color' => 'e5e8eb',
		'default-image' => '',
	)));
	
	// Добавьте поддержку изображений полной ширины и другого контента, например видео в Gutenberg.
	add_theme_support( 'align-wide' );
	
}
add_action( 'after_setup_theme', 'cssd_setup' );


/*------------------------------------------------------------------
  Подключение CSS и JS
-------------------------------------------------------------------*/

function cssd_scripts() {
	//wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'uikit', get_theme_file_uri( '/assets/css/uikit.min.css' ), false, '', 'all' );
  wp_enqueue_style( 'lora', ( '//fonts.googleapis.com/css?family=Lora:400,400i,700,700i&subset=cyrillic' ), false, '', 'all' );
  wp_enqueue_style( 'style', get_theme_file_uri( '/assets/css/style.css' ), false, '', 'all' );
  wp_enqueue_style( 'theme', get_theme_file_uri( '/assets/css/theme.css' ), false, '', 'all' );
  
  wp_dequeue_style('wp-block-library'); // Отключаем Gutenberg style
  
  if( !is_admin()){ wp_deregister_script('jquery'); } // Отключаем стандартый WP JQuery
	
	wp_enqueue_script( 'jquery', get_theme_file_uri() . '/assets/js/jquery.js', array(), '', true );
	wp_enqueue_script( 'uikit', get_theme_file_uri( '/assets/js/uikit.min.js' ), array( 'jquery' ), '', true );
	wp_enqueue_script( 'uikit-icons', get_theme_file_uri( '/assets/js/uikit-icons.min.js' ), array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'cssd_scripts' );

/*------------------------------------------------------------------
  Includes
-------------------------------------------------------------------*/

//require get_theme_file_path( '/' );

/*------------------------------------------------------------------
  Вывдим количество постов в категории
-------------------------------------------------------------------*/

function wp_get_cat_postnum($id) {
  $cat = get_category($id);
  $count = (int) $cat->count;
  $taxonomy = 'category';
  $args = array(
    'child_of' => $id,
  );
  $tax_terms = get_terms($taxonomy,$args);
  foreach ($tax_terms as $tax_term) {
    $count +=$tax_term->count;
  }
  return $count;
}

/*------------------------------------------------------------------
  Добавляем класс к аннотациям постов the_excerpt
-------------------------------------------------------------------*/

function add_class_excerpt( $excerpt ) {
  return str_replace( '<p>', '<p class="uk-text-lead">', $excerpt );
}
add_filter( "the_excerpt", "add_class_excerpt" );

/*------------------------------------------------------------------
  Главное меню
-------------------------------------------------------------------*/
	
// Изменяет основные параметры меню
add_filter( 'wp_nav_menu_args', 'filter_wp_menu_args_header' );
function filter_wp_menu_args_header( $args ) {
	if ( $args['theme_location'] === 'primary' ) {
		$args['container']   = false;
		$args['items_wrap']  = '<ul class="%2$s">%3$s</ul>';
		$args['menu_class']  = 'uk-navbar-nav';
	}
	return $args;
}
// Изменяем атрибут id у тега li
add_filter( 'nav_menu_item_id', 'filter_menu_item_css_id_header', 10, 4 );
function filter_menu_item_css_id_header( $menu_id, $item, $args, $depth ) {
	return $args->theme_location === 'primary' ? '' : $menu_id;
}
// Изменяем атрибут class у тега li
add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes_header', 10, 4 );
function filter_nav_menu_css_classes_header( $classes, $item, $args, $depth ) {
	if ( $args->theme_location === 'primary' ) {
		$classes = [
			'lvl-' . ( $depth + 1 )
		];
		if ( $item->current ) {
			$classes[] = 'uk-active';
		}
	}
	return $classes;
}
// Изменяет класс у вложенного ul
add_filter( 'nav_menu_submenu_css_class', 'filter_nav_menu_submenu_css_class_header', 10, 3 );
function filter_nav_menu_submenu_css_class_header( $classes, $args, $depth ) {
	if ( $args->theme_location === 'primary' ) {
		$classes = [
			'uk-nav uk-navbar-dropdown-nav',
		];
	}
	return $classes;
}
// ДОбавляем классы ссылкам
add_filter( 'nav_menu_link_attributes', 'filter_nav_menu_link_attributes_header', 10, 4 );
function filter_nav_menu_link_attributes_header( $atts, $item, $args, $depth ) {
	if ( $args->theme_location === 'primary' ) {
		$atts['class'] = '';
		if ( $item->current ) {
			$atts['class'] .= '';
		}
	}
	return $atts;
}

/*------------------------------------------------------------------
  Walker Nav Menu
-------------------------------------------------------------------*/

class WalkerNavMenu extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$classes = array( 'sub-menu' );
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$output .= "{$n}{$indent}<div class='uk-navbar-dropdown' uk-drop='offset: -15; delay-show: 50; delay-hide: 30; duration: 50;'><ul$class_names>{$n}";
	}
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "$indent</ul></div>{$n}";
	}
}

/*------------------------------------------------------------------ 
  Регистрируем виджеты
-------------------------------------------------------------------*/

register_sidebar( array(
  'name' => 'Сайдбар',
  'id' => 'sidebar',
  'before_widget' => '<div id="%1$s" class="%2$s uk-tile uk-tile-default uk-padding-small uk-margin">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>'
));

/*------------------------------------------------------------------
  Постраничная навигация
-------------------------------------------------------------------*/

function post_navigarion( $before = '', $after = '', $echo = true, $args = array(), $wp_query = null ) {
	if( ! $wp_query )
		global $wp_query;
	// параметры по умолчанию
	$default_args = array(
		'text_num_page'   => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
		'num_pages'       => 6, // сколько ссылок показывать
		'step_link'       => 12, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…', // промежуточный текст "до".
		'dotright_text2'  => '…', // промежуточный текст "после".
		'back_text'       => '<span uk-pagination-previous></span>', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => '<span uk-pagination-next></span>', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
		'first_page_text' => 'к началу', // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 'в конец', // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);
	$default_args = apply_filters('pagenavi_args', $default_args ); // чтобы можно было установить свои значения по умолчанию
	$args = array_merge( $default_args, $args );
	extract( $args );
	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	$paged          = (int) $wp_query->query_vars['paged'];
	$max_page       = $wp_query->max_num_pages;
	//проверка на надобность в навигации
	if( $max_page <= 1 )
		return false;
	if( empty( $paged ) || $paged == 0 )
		$paged = 1;
	$pages_to_show = intval( $num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor( $pages_to_show_minus_1/2 ); //сколько ссылок до текущей страницы
	$half_page_end = ceil( $pages_to_show_minus_1/2 ); //сколько ссылок после текущей страницы
	$start_page = $paged - $half_page_start; //первая страница
	$end_page = $paged + $half_page_end; //последняя страница (условно)
	if( $start_page <= 0 )
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}
	if( $start_page <= 0 )
		$start_page = 1;
	//выводим навигацию
	$out = '';
	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace( 99999999, '___', get_pagenum_link( 99999999 ) );
	$first_url = get_pagenum_link( 1 );
	if( false === strpos( $first_url, '?') )
		$first_url = user_trailingslashit( $first_url );
	$out .= $before . "<section class='uk-section uk-section-xsmall uk-section-default'><div class='uk-container uk-container-expand'><ul class='uk-pagination uk-flex-center' uk-margin>\n";
		if( $text_num_page ){
			$text_num_page = preg_replace( '!{current}|{last}!', '%s', $text_num_page );
			$out.= sprintf( "<li><span class='pages'>$text_num_page</span></li> ", $paged, $max_page );
		}
		// назад
		if ( $back_text && $paged != 1 )
			$out .= '<li><a href="'. ( ($paged-1)==1 ? $first_url : str_replace( '___', ($paged-1), $link_base ) ) .'">'. $back_text .'</a></li> ';
			
		// в начало
		if ( $start_page >= 2 && $pages_to_show < $max_page ) {
			$out.= '<li><a class="first" href="'. $first_url .'">'. ( $first_page_text ? $first_page_text : 1 ) .'</a></li> ';
			if( $dotright_text && $start_page != 2 ) $out .= '<li><span class="extend">'. $dotright_text .'</span><li> ';
		}
		// пагинация
		for( $i = $start_page; $i <= $end_page; $i++ ) {
			if( $i == $paged )
				$out .= '<li class="uk-active"><span>'.$i.'</span></li> ';
			elseif( $i == 1 )
				$out .= '<li><a href="'. $first_url .'">1</a></li> ';
			else
				$out .= '<li><a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a></li> ';
		}
		//ссылки с шагом
		$dd = 0;
		if ( $step_link && $end_page < $max_page ){
			for( $i = $end_page+1; $i<=$max_page; $i++ ) {
				if( $i % $step_link == 0 && $i !== $num_pages ) {
					if ( ++$dd == 1 )
						$out.= '<li><span class="extend">'. $dotright_text2 .'</span></li> ';
					$out.= '<li><a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a></li> ';
				}
			}
		}
		// в конец
		if ( $end_page < $max_page ) {
			if( $dotright_text && $end_page != ($max_page-1) )
				$out.= '<li><span class="extend">'. $dotright_text2 .'</span></li> ';
			$out.= '<li><a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $last_page_text ? $last_page_text : $max_page ) .'</a></li> ';
		}
		// вперед
		if ( $next_text && $paged != $end_page )
			$out.= '<li><a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $next_text .'</a></li> ';
	$out .= "</ul></div></section>". $after ."\n";
	$out = apply_filters('pagenavi', $out );
	if( $echo )
		return print $out;
	return $out;
}

/*------------------------------------------------------------------ 
  Удаляем в строке браузера, срочку category
-------------------------------------------------------------------*/

/* hooks */
register_activation_hook( __FILE__,   'remove_category_url_refresh_rules' );
register_deactivation_hook( __FILE__, 'remove_category_url_deactivate' );

/* actions */
add_action( 'created_category', 'remove_category_url_refresh_rules' );
add_action( 'delete_category',  'remove_category_url_refresh_rules' );
add_action( 'edited_category',  'remove_category_url_refresh_rules' );
add_action( 'init',             'remove_category_url_permastruct' );

/* filters */
add_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' );
add_filter( 'query_vars',             'remove_category_url_query_vars' );    // Adds 'category_redirect' query variable
add_filter( 'request',                'remove_category_url_request' );       // Redirects if 'category_redirect' is set
add_filter( 'plugin_row_meta', 		    'remove_category_url_plugin_row_meta', 10, 4 );

function remove_category_url_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function remove_category_url_deactivate() {
	remove_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' ); // We don't want to insert our custom rules again
	remove_category_url_refresh_rules();
}

function remove_category_url_permastruct() {
	global $wp_rewrite, $wp_version;

	if ( 3.4 <= $wp_version ) {
		$wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
	} else {
		$wp_rewrite->extra_permastructs['category'][0] = '%category%';
	}
}

function remove_category_url_rewrite_rules( $category_rewrite ) {
	global $wp_rewrite;

	$category_rewrite = array();

	/* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
	if ( class_exists( 'Sitepress' ) ) {
		global $sitepress;

		remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
		$categories = get_categories( array( 'hide_empty' => false, '_icl_show_all_langs' => true ) );
		add_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
	} else {
		$categories = get_categories( array( 'hide_empty' => false ) );
	}

	foreach ( $categories as $category ) {
		$category_nicename = $category->slug;
		if (  $category->parent == $category->cat_ID ) {
			$category->parent = 0;
		} elseif ( 0 != $category->parent ) {
			$category_nicename = get_category_parents(  $category->parent, false, '/', true  ) . $category_nicename;
		}
		$category_rewrite[ '(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/page/?([0-9]{1,})/?$' ] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/?$' ] = 'index.php?category_name=$matches[1]';
	}

	// Redirect support from Old Category Base
	$old_category_base = get_option( 'category_base' ) ? get_option( 'category_base' ) : 'category';
	$old_category_base = trim( $old_category_base, '/' );
	$category_rewrite[ $old_category_base . '/(.*)$' ] = 'index.php?category_redirect=$matches[1]';

	return $category_rewrite;
}

function remove_category_url_query_vars( $public_query_vars ) {
	$public_query_vars[] = 'category_redirect';

	return $public_query_vars;
}

function remove_category_url_request( $query_vars ) {
	if ( isset( $query_vars['category_redirect'] ) ) {
		$catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
		status_header( 301 );
		header( "Location: $catlink" );
		exit;
	}

	return $query_vars;
}

function remove_category_url_plugin_row_meta( $links, $file ) {
	if( plugin_basename( __FILE__ ) === $file ) {
		$links[] = sprintf(
			'<a target="_blank" href="%s">%s</a>',
			esc_url('#'),
			__( 'Donate', 'remove_category_url' )
		);
	}
	return $links;
}

/*------------------------------------------------------------------ 
  Удаляем лишнее из WordPress
-------------------------------------------------------------------*/

/* Удаляем название [Рубрика:] в категориях
function remove_cat_name( $title ){
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  }
  return $title;
}
add_filter( 'get_the_archive_title', 'remove_cat_name' );
*/

// Удаляем Emoji
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}
// Удаляем ссылку на WordPress (s.w.org)
function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
// Удаляем остальные ненужные meta из head
function wp_version_js_css($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version')))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'wp_version_js_css', 9999);
add_filter('script_loader_src', 'wp_version_js_css', 9999);
// Удаляем код meta name="generator"
remove_action( 'wp_head', 'wp_generator' );
// Удаляем link rel="canonical" // Этот тег лучше выводить с помощью плагина Yoast SEO или All In One SEO Pack
remove_action( 'wp_head', 'rel_canonical' );
// Удаляем link rel="shortlink" - короткую ссылку на текущую страницу
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); 
// Удаляем link rel="EditURI" type="application/rsd+xml" title="RSD"
// Используется для сервиса Really Simple Discovery 
remove_action( 'wp_head', 'rsd_link' ); 
// Удаляем link rel="wlwmanifest" type="application/wlwmanifest+xml"
// Используется Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' );
// Удаляем различные ссылки link rel
// на главную страницу
remove_action( 'wp_head', 'index_rel_link' ); 
// на первую запись
remove_action( 'wp_head', 'start_post_rel_link', 10 );  
// на предыдущую запись
remove_action( 'wp_head', 'parent_post_rel_link', 10 ); 
// на следующую запись
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
// Удаляем связь с родительской записью
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); 
// Удаляем вывод /feed/
remove_action( 'wp_head', 'feed_links', 2 );
// Удаляем вывод /feed/ для записей, категорий, тегов и подобного
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Удаляем ненужный css плагина WP-PageNavi
remove_action( 'wp_head', 'pagenavi_css' );
// Настраиваем редирект со страницы rss /feed/ на главную
add_action( 'do_feed', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rdf', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss2', 'sheensay_redirect_feed', 1 );
function sheensay_redirect_feed() {
  wp_redirect( site_url('/') );
  exit;
}
// Удаляем стили css-класса .recentcomments
function sheensay_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'sheensay_remove_recent_comments_style' );
// Отключаем и удаляем wp-json и oembed
// Удаляем информацию о REST API из заголовков HTTP и секции head
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
// Убираем oembed ссылки в секции head
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// Если собираетесь выводить oembed из других сайтов на своём, то закомментируйте следующую строку
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
// Код для отключения и удаления XML-RPC
add_filter( 'xmlrpc_methods', 'sheensay_block_xmlrpc_attacks' );
function sheensay_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}
add_filter( 'wp_headers', 'sheensay_remove_x_pingback_header' );
function sheensay_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}
// Не рекомендую использовать, т.к. несовместимо с плагином JetPack и подобными
add_filter('xmlrpc_enabled', '__return_false');