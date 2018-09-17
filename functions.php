<?php

/*------------------------------------------------------------------
  Global
-------------------------------------------------------------------*/

function cssdrive_setup() {
	
	load_theme_textdomain( 'cssdrive' );
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	
	register_nav_menus(
		array(
			'primary'    => __( 'Primary Menu', 'cssdrive' ),
		)
	);
	
	add_theme_support(
		'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	
	add_theme_support(
		'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		)
	);
	
	add_theme_support( 'custom-logo', array(
   'height'      => 45,
   'width'       => 45,
   'flex-width' => true,
   'flex-height' => true,
   'header-text' => array( 'site-title', 'site-description' ),
	));
	
}
add_action( 'after_setup_theme', 'cssdrive_setup' );

/*------------------------------------------------------------------
  Scripts
-------------------------------------------------------------------*/

function cssdrive_scripts() {
	
	wp_enqueue_style( 'uikit-style', ( 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/css/uikit.min.css' ), false, '3.0.0-rc.16', 'all' );
	wp_enqueue_style( 'cssdrive-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'uikit-script', ( 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit.min.js' ), array( 'jquery' ), '3.0.0-rc.16', true );
	wp_enqueue_script( 'uikit-icons-script', ( 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit-icons.min.js' ), array( 'jquery' ), '3.0.0-rc.16', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'cssdrive_scripts' );

/*------------------------------------------------------------------
  Includes
-------------------------------------------------------------------*/

require get_parent_theme_file_path( '/inc/Walker_Nav_Menu.php' );