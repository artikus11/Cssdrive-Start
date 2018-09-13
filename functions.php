<?php

if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_parent_theme_file_path( '/inc/back-compat.php' );
}

// Settings
function cssd_setup() {
	
	add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  
  register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'cssd' ),
		)
	);
	
	add_theme_support(
		'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
}
add_action( 'after_setup_theme', 'cssd_setup' );

// Scripts
function cssd_scripts() {
  wp_enqueue_style( 'uikit', get_theme_file_uri( '/assets/css/uikit.min.css' ), false, '3.0.0-rc.16', 'all' );
  wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'uikit', get_theme_file_uri( '/assets/js/uikit.min.js' ), array( 'jquery' ), '3.0.0-rc.16', true );
	wp_enqueue_script( 'uikit-icons', get_theme_file_uri( '/assets/js/uikit-icons.min.js' ), array( 'jquery' ), '3.0.0-rc.16', true );

	if ( is_singular( 'post' ) && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cssd_scripts' );

// includes
require get_theme_file_path( '/inc/walker-nav-menu.php' );