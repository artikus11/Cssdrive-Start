<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class('uk-offcanvas-content'); ?>>

<header id="masthead" role="banner">	
	<nav id="site-navigation" class="uk-navbar-container" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'cssdrive' ); ?>">
	  <div class="uk-container">
	    <div class="uk-navbar" uk-navbar>
	      <div class="uk-navbar-left">
		      <?php
			      /*
				     *  /template-parts/header/site-branding.php
				     */
			      get_template_part( 'template-parts/header/site', 'branding' ); ?>
	      </div>
	      <?php if ( has_nav_menu( 'primary' ) ) : ?>
		      <div class="uk-navbar-center uk-visible@m">
		        <?php
			        /*
				       *  /inc/Walker_Nav_Menu.php
				       */
			        wp_nav_menu( [ 'theme_location' => 'primary', 'walker' => new True_Walker_Nav_Menu(), ] ); ?>
		      </div>
	      <?php endif; ?>
	      <div class="uk-navbar-right">
		      <div>
            <a class="uk-navbar-toggle" uk-search-icon href="#"></a>
            <div style="width: 110px !important;" class="uk-drop" uk-drop="mode: click; pos: left-center; offset: 0">
                <form role="search" method="get" class="uk-search uk-search-navbar uk-width-1-1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input class="uk-search-input" type="search" value="<?php echo get_search_query(); ?>" name="search" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'cssdrive' ); ?>" autofocus>
                </form>
            </div>
          </div>
          <a class="uk-navbar-toggle" type="button" uk-toggle="target: #offcanvas-overlay">
	          <span uk-navbar-toggle-icon></span>
	        </a>
	      </div>
	    </div>
	  </div>
	</nav>		
</header>

<div id="offcanvas-overlay" uk-offcanvas="overlay: true; flip: true;">
  <div class="uk-offcanvas-bar">
    <button class="uk-offcanvas-close" type="button" uk-close></button>
    <h3>Боковое меню</h3>
    <p>Используйте по собственному желанию!</p>
  </div>
</div>

<div id="content">