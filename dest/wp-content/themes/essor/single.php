<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( has_post_thumbnail() ){ ?>
				<div class='wrapper-top-img small'>
					<div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url();?>")'></div>
				</div>
			<?php } ?>
			
			<article class='container-small'>
				<div class='bloc-title-blog <?php if( has_post_thumbnail() ){ echo "has-img"; } ?>'>
					<div class='postMeta'>Le <?php echo get_the_date(); ?> dans <?php echo get_the_category_list(', '); ?></div>
					<h1><?php the_title(); ?></h1>
				</div>

				<div class='blog-content clearfix'>
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>


	<?php else : ?>
				
		<article>
			<h1>404</h1>
		</article>

	<?php endif; ?>

<?php get_footer(); ?>
