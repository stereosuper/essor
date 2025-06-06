<?php
/*
Template Name: Sitemap
*/
get_header(); ?>

	<div class='container-small'>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>

				<h2>Pages</h2>
				<ul>
					<?php wp_list_pages( array('post_type' => 'page', 'title_li' => '', 'sort_column' => 'post_title') ); ?>
				</ul>

				<?php
					function listPosts($postType, $tax){
						$options = $tax ? array( array('taxonomy' => 'types', 'field' => 'slug', 'terms' => $tax) ) : '';
						$posts = get_posts( array('post_type' => $postType, 'orderby' => 'title', 'posts_per_page' => -1, 'order' => 'ASC', 'tax_query' => $options) );

						if(!$posts)
							echo '<p>Rien n\'a été trouvé</p>';

						$output = "<ul>";
						foreach( $posts as $post ){
							$output .= '<li>';
							$output .= '<a href="'. get_permalink($post->ID) .'" title="'. get_the_title($post->ID) .'">';
							$output .= get_the_title($post->ID);
							$output .= '</a>';
							$output .= '</li>';
						}
						$output .= '</ul>';

						echo $output;
					}
				?>

				<h2>Références</h2>
				<?php listPosts('reference', ''); ?>

				<h2>Articles</h2>
				<?php listPosts('post', ''); ?>

				<h2>Offres d'emploi</h2>
				<?php listPosts('offre', ''); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php echo '404'; ?>

		<?php endif; ?>

	</div>

<?php get_footer(); ?>
