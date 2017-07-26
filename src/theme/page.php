<?php get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php the_post_thumbnail('full'); ?>

		<div class='container-small'>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>