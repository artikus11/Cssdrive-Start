<?php

if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
  require get_parent_theme_file_path( '/inc/back-compat.php' );
}


function cssd_setup() {
  load_theme_textdomain( 'cssd', get_parent_theme_file_path( '/languages' ) );

  theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );

  add_theme_support( 'post-thumbnails' );

  register_nav_menus(
    array(
      'primary' => esc_html__( 'Primary Menu', 'cssd' ),
      'footer'  => esc_html__( 'Footer Menu', 'cssd' ),
      'social'  => esc_html__( 'Social Menu', 'cssd' ),
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


function cssd_scripts() {
  // Theme stylesheet.
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'uikit', get_theme_file_uri( '/assets/css/uikit.min.css' ), false, '3.0.0-rc.15', 'all' );
  wp_enqueue_style( 'theme', get_theme_file_uri( '/assets/css/theme.css' ), false, '1.0.0-beta.1', 'all' );

  // Scripts.
  wp_enqueue_script( 'cssd-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.1.4', true );
  wp_enqueue_script( 'uikit', get_theme_file_uri( '/assets/js/uikit.min.js' ), array(), '3.0.0-rc.15', true );
  wp_enqueue_script( 'uikit-icons', get_theme_file_uri( '/assets/js/uikit-icons.min.js' ), array(), '3.0.0-rc.15', true );

  if ( is_singular( 'post' ) && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'cssd_scripts' );


function cssd_widgets_init() {
  register_sidebar(
    array(
      'name'          => esc_html__( 'Footer', 'coblocks' ),
      'id'            => 'sidebar-1',
      'description'   => esc_html__( 'Appears in the site footer.', 'coblocks' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h6 class="h2">',
      'after_title'   => '</h6>',
    )
  );
}
add_action( 'widgets_init', 'cssd_widgets_init' );


function cssd_site_logo_class( $html ) {
  // Is the border radius option enabled?
  $radius = get_theme_mod( 'custom_logo_border_radius', coblocks_defaults( 'custom_logo_border_radius' ) );
  $radius = ( false === $radius ) ? ' no-border-radius' : null;

  $html = str_replace( 'custom-logo-link', 'custom-logo-link site-logo ' . esc_attr( $radius ), $html );

  return $html;
}
add_filter( 'get_custom_logo', 'cssd_site_logo_class' );
