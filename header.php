<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!------------------------------------------------------------------
  Главное меню сайта
------------------------------------------------------------------->

<nav class="uk-navbar-container">
  <div class="uk-container">
    <div class="uk-navbar" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="<?php echo esc_url(home_url( '/' ) ); ?>"><strong><?php bloginfo('name'); ?></strong> <span class="uk-visible@m">&nbsp;/&nbsp;<?php is_home() ? bloginfo('description') : wp_title(''); ?></span></a>
      </div>
      <div class="uk-navbar-right">
        <?php wp_nav_menu( [ 'theme_location' => 'primary', 'walker' => new Primary_Walker_Nav_Menu(), ] ); ?>
      </div>
    </div>
  </div>
</nav>