<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<div class='wrapper-top-img small'>
				<div class='top-img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></div>
			</div>
			<div class='container'>
				<article>
					<h1><?php the_title(); ?></h1>
					<div class="postMeta">
						<?php echo get_the_date(); ?>
					</div>
							
					<?php the_content(); ?>	
				</article>
			</div>
		<?php endwhile; ?>


	<?php else : ?>
				
		<article>
			<h1>404</h1>
		</article>

	<?php endif; ?>

<?php get_footer(); ?>
