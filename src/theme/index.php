<?php get_header(); ?>

	<div class='container'>
		
		<div class='wrapper-title'>
            <div class='title'>
            	<h1><?php single_post_title(); ?></h1>
                <?php the_field('text', get_option( 'page_for_posts' )); ?>
            </div>
            <aside>
                <span class='title-aside'>Réseaux sociaux :</span>
                <?php if( have_rows('socialNetworks', 'options') ){ ?>
                    <ul class='menu-social'>
                        <?php while( have_rows('socialNetworks', 'options') ){ the_row(); ?>
                            <li><a href='<?php the_sub_field('link'); ?>'><?php the_sub_field('name'); ?> <svg class='icon icon-<?php the_sub_field('icon'); ?>'><use xlink:href='#icon-<?php the_sub_field('icon'); ?>'></use></svg></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </aside>
        </div>

		<?php if ( have_posts() ) : ?>

			<ul class='news'>

				<?php while ( have_posts() ) : the_post(); ?>
					<li>
						<a href='<?php the_permalink(); ?>'>
							<span class='wrapper-img'>
								<span class='img' style='background-image: url("<?php echo get_the_post_thumbnail_url(); ?>")'></span>
							</span>
							<span class='wrapper-txt'>
								<h3><?php the_title(); ?></h3>
								<?php the_excerpt(); ?>
							</span>
						</a>
					</li>
				<?php endwhile; ?>

				<li class='load-more'>
                    <a href='#'>
                        <span class='txt-more'>Charger la suite<svg class='icon'><use xlink:href='#icon-arrow-bottom'></use></svg></span>
                    </a>
                </li>

			</ul>
		
		<?php else : ?>
					
			<p>Pas d'articles</p>

		<?php endif; ?>

	</div>

<?php get_footer(); ?>