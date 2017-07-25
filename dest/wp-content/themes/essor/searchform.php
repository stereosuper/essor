<form role='search' method='get' action='<?php echo esc_url( home_url( '/' ) ); ?>' class='form-search header-form-search' id='formSearch'>
	<input type='search' name='s' value='<?php the_search_query(); ?>' placeholder='Votre mot clé'>
	<button class='btn-search' type='submit'>Rechercher <svg class='icon'><use xlink:href='#icon-search'></use></svg></button>
</form>