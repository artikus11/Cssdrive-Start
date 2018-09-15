<h3 class="widget-title">Посик</h3>
<form role="search" method="get" class="uk-search uk-search-default uk-width-1-1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <span class="uk-search-icon-flip" uk-search-icon></span>
    <input class="uk-search-input" type="search" value="<?php echo get_search_query(); ?>" name="search" placeholder="Поиск...">
</form>