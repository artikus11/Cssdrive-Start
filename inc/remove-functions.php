<?php

/*------------------------------------------------------------------
  Удаляем название [Рубрика:] в категориях
-------------------------------------------------------------------*/

function remove_cat_name( $title ){
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  }
  return $title;
}
add_filter( 'get_the_archive_title', 'remove_cat_name' );

/*------------------------------------------------------------------
  Скрыть панель админимстратора на лицевой части сайта
-------------------------------------------------------------------*/

add_filter('show_admin_bar', '__return_false');

/*------------------------------------------------------------------ 
  Удаляем Emoji
-------------------------------------------------------------------*/

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

/*------------------------------------------------------------------
  Удаляем ссылку на WordPress (s.w.org)
-------------------------------------------------------------------*/

function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

/*------------------------------------------------------------------
  Удаляем остальные ненужные meta из head
-------------------------------------------------------------------*/

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

/*------------------------------------------------------------------ 
    Настраиваем редирект со страницы rss /feed/ на главную
-------------------------------------------------------------------*/

add_action( 'do_feed', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rdf', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss2', 'sheensay_redirect_feed', 1 );
 
function sheensay_redirect_feed() {
  wp_redirect( site_url('/') );
  exit;
}

/*------------------------------------------------------------------ 
  Удаляем стили css-класса .recentcomments
-------------------------------------------------------------------*/

function sheensay_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'sheensay_remove_recent_comments_style' );

/*------------------------------------------------------------------
  Отключаем и удаляем wp-json и oembed
-------------------------------------------------------------------*/
 
// Удаляем информацию о REST API из заголовков HTTP и секции head
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
 
// Убираем oembed ссылки в секции head
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
 
// Если собираетесь выводить oembed из других сайтов на своём, то закомментируйте следующую строку
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/*------------------------------------------------------------------
  Код для отключения и удаления XML-RPC
-------------------------------------------------------------------*/

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