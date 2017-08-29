<?php
/*
Template Name: Sous-Accueil
*/

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
    


		<div class='container-small'>
			<h1><?php the_title(); ?></h1>
        </div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>