<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<div class='wrapper-top-img small'>
				<div class='top-img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></div>
			</div>
			<div class='container-small'>
				<article>
					<div class='bloc-title-blog'>
						<div class='postMeta'>En Mars 2017 dans <a href='#'>Chantier</a>, <a href='#'>Ingénierie</a></div>
						<h1><?php the_title(); ?></h1>
					</div>
					<!-- <div class="postMeta">
						<?php echo get_the_date(); ?>
					</div> -->
					<div class='blog-content'>
						<?php the_content(); ?>
					</div>
				</article>
			</div>
		<?php endwhile; ?>


	<?php else : ?>
				
		<article>
			<h1>404</h1>
		</article>

	<?php endif; ?>

<?php get_footer(); ?>
