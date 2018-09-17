<div class="site-branding">
	<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' ); if ( has_custom_logo() ) { ?>
		  <?php if ( is_front_page() ) : ?>
				<h1 class="uk-h1 uk-navbar-item uk-margin-remove"><?php echo '<img class="custom-logo uk-margin-small-right" src="'. esc_url( $logo[0] ) .'">'; ?><a class="uk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="uk-h1 uk-navbar-item uk-margin-remove"> <?php echo '<img class="custom-logo uk-margin-small-right" src="'. esc_url( $logo[0] ) .'">'; ?><a class="uk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
		<?php } else { ?>
			<?php if ( is_front_page() ) : ?>
				<h1 class="uk-h1 uk-navbar-item uk-margin-remove"><a class="uk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="uk-h1 uk-navbar-item uk-margin-remove"><a class="uk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
		<?php } ?>
</div>