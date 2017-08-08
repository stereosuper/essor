<?php get_header(); ?>

	<div class='container'>

		<?php if ( have_posts() ) : 
		global $wp_query;
		$results = $wp_query->found_posts; ?>

			<h1>La recherche "<?php the_search_query(); ?>" a retourné <?php if($results > 1){ echo $results . ' résultats'; }else{ echo '1 résultat'; } ?> </h1>

			<ul>
				<?php while ( have_posts() ) : the_post(); ?>
					<li>
						<a href='<?php the_permalink(); ?>'>
							<h2><?php the_title(); ?></h2>
							<?php the_excerpt(); ?>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php previous_posts_link('Résultats plus récents'); ?>
			<?php next_posts_link('Résultats plus anciens'); ?>
		
		<?php else : ?>
					
			<h1>La recherche "<?php the_search_query(); ?>" n'a retourné aucun résultat</h1>

		<?php endif; ?>

	</div>

<?php get_footer(); ?>