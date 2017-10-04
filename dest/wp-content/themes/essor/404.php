<?php get_header(); ?>

	<div class='container-tiny'>

		<h1>404</h1>
		<p>Oups ! Cette page n'existe pas encore... ou plus du tout. <br>Et si vous retentiez votre chance avec une autre ?</p>
		<p>
			<a href='./' class='link'>Retour à l'accueil</a><br>
			<a href='<?php the_field('refsLink', 'options'); ?>' class='link'>Voir nos références</a>
		</p>

	</div>

<?php get_footer(); ?>