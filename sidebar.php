<?php
	// Стили находятся в файле functions.php
?>

<?php if ( is_active_sidebar('sidebar') ) { ?>
	<?php dynamic_sidebar( 'sidebar' ); ?>
<?php } else { ?>
	<p class="uk-text-center">Виджеты еще не созданы!</p>
<?php }; ?>