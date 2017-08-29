<?php get_header(); ?>

	<div class='container-tiny'>

		<h1>404</h1>
		<p>Il semble que cette page n'existe pas ou plus.</p>
		<p>
			<a href='./' class='link'>Retour à l'accueil</a><br>
			<a href='<?php the_field('refsLink', 'options'); ?>' class='link'>Voir nos références</a>
		</p>

	</div>

<?php get_footer(); ?>