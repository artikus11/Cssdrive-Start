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
	
}
add_action( 'after_setup_theme', 'cssd_setup' );


/*------------------------------------------------------------------
  Подключение CSS и JS
-------------------------------------------------------------------*/

function cssd_scripts() {
  wp_enqueue_style( 'uikit', get_theme_file_uri( '/assets/css/uikit.min.css' ), false, '', 'all' );
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  
  if( !is_admin()){ wp_deregister_script('jquery'); } // Отключаем стандартый WP JQuery
	
	wp_enqueue_script( 'jquery', get_theme_file_uri() . '/assets/js/jquery.js', array(), '', true );
	wp_enqueue_script( 'uikit', get_theme_file_uri( '/assets/js/uikit.min.js' ), array( 'jquery' ), '', true );
	wp_enqueue_script( 'uikit-icons', get_theme_file_uri( '/assets/js/uikit-icons.min.js' ), array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'cssd_scripts' );

/*------------------------------------------------------------------
  Подключаем дополнительные файлы functions.php чепер папку /inc/
-------------------------------------------------------------------*/

require get_theme_file_path( '/inc/walker-nav-menu.php' ); // Настройки основного и выпадающего меню
require get_theme_file_path( '/inc/remove-functions.php' ); // Удаляем название [Рубрика:] в категориях
require get_theme_file_path( '/inc/filter-username.php' ); // Фильтр имя пользователя от непригодных для использования символов
require get_theme_file_path( '/inc/list-post-thumbnail.php' ); // Колонка миниатюры в списке записей админки

/*------------------------------------------------------------------
  Интеграция ACF
-------------------------------------------------------------------*/
//require get_theme_file_path( '/inc/advanced-custom-fields/acf.php' ); // Интегрируем ACF в шаблон
//require get_theme_file_path( '/inc/acf-option-page.php' ); // Настройки и произвольные поля