<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
<header class="header">
<nav class="uk-navbar-container uk-navbar-transparent">
	<div class="uk-container">
		<div class="uk-navbar boundary-align" uk-navbar>
			<div class="uk-navbar-left">
				<a class="uk-navbar-item uk-logo" href="<?php echo esc_url(home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/mobian-logo.png" alt="<?php bloginfo( 'name' ); ?>" width="147">
				</a>
			</div>
			<div class="uk-navbar-right">
		    <?php wp_nav_menu( array(
					'menu'            => 'primary',
					'theme_location'  => 'primary',
					'container'       => 'ul',
					'container_id'    => '',
					'container_class' => '',
					'menu_id'         => '',
					'menu_class'      => 'uk-navbar-nav uk-navbar-parent-icon',
					'before'          => '',
					'after'           => '',
					'link_before'     => '<span>',
					'link_after'      => '</span>',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback_cb'     => 'Primary_Walker_Nav_Menu::fallback',
					'depth'           => 2,
					'walker'          => new Primary_Walker_Nav_Menu())
				); ?>
		  </div>
		</div>
	</div>
</nav>	
</header>
