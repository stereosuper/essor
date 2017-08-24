<?php
/*
Template Name: Sous-Accueil
*/

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
    
        <?php $highlightedProjects = get_field('highlightedProjects');
        $i = 0;

        if( $highlightedProjects ): ?>
            <div class='slider'>
                <?php foreach( $highlightedProjects as $post): ?>
                    <?php setup_postdata($post); ?>
                    <div <?php if( $i !== 0 ){ echo 'style="display:none"'; } ?>>
                        <?php if( function_exists('gacfai_get_field') && gacfai_get_field('img') ){ ?>
                            <?php echo gacfai_get_field('img', $post->ID, 'full', false, ''); ?>
                        <?php }else if( has_post_thumbnail() ){ ?>
                            <?php the_post_thumbnail('full'); ?>
                        <?php } ?>
                    </div>
                <?php $i++; endforeach; ?>
                <?php wp_reset_postdata(); ?>

                <div class='container'>
                    <ul>
                        <?php foreach( $highlightedProjects as $post): ?>
                            <?php setup_postdata($post); ?>
                            <li><a href='<?php the_permalink(); ?>'>
                                <?php the_field('place'); ?>
                                <?php the_title(); ?>
                            </a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>

		<div class='container-small bloc-title-img' id='blocTitle'>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
        </div>

        <div class='container'>
            <div class='sector-detail'>
                <div class='sector-text'>
                    <?php the_field('text'); ?>
                </div>

                <?php if( have_rows('numbers') ): ?>
                    <ul class='list-numbers list-numbers-sector'>
                    <?php while( have_rows('numbers') ): the_row(); ?>

                        <li class='isAnimated'>
                            <div>
                                <?php echo wp_get_attachment_image( get_sub_field('img'), 'full' ); ?>
                                <b><?php the_sub_field('number'); ?><span><?php the_sub_field('unit'); ?></span></b>
                            </div>
                            <span><?php the_sub_field('text'); ?></span>
                            <?php if( get_sub_field('link') && get_sub_field('linkText') ){ ?>
                                <a href='<?php the_sub_field('link'); ?>' class='link'><?php the_sub_field('linkText'); ?></a>
                            <?php } ?>
                        </li>

                    <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if( have_rows('people') ): ?>
                <h2 class='has-margin'><?php the_field('peopleTitle'); ?></h2>

                <ul class='list-people-sector'>
                <?php while( have_rows('people') ): the_row(); ?>

                    <li class='isAnimated'>
                        <?php the_sub_field('job'); ?>
                        <h3><?php the_sub_field('name'); ?></h3>
                    </li>

                <?php endwhile; ?>
                </ul>
            <?php endif; ?>

            <h2 class='has-margin'><?php the_field('projectTitle'); ?></h2>
            <?php
                $projectsQuery = new WP_Query(array('post_type' => 'reference', 'posts_per_page' => 4, 'tax_query' => array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => get_field('sector')), 'post_status' => 'publish'));

                if( $projectsQuery->have_posts() ) {
                ?>
                    <ul class='projects complete'>
                        <?php while( $projectsQuery->have_posts() ) : $projectsQuery->the_post(); ?>
                            <?php get_template_part( 'includes/reference' ); ?>
                        <?php $countProjects ++; endwhile; ?>
                    </ul>
                <?php }
                wp_reset_query();
            ?>
        </div>

        <div class='container-small'>
            <?php the_field('projectText'); ?>
        </div>
        
        <div class='container map-sector'>
            <div class='map-txt-sector'>
                <h2><?php the_field('mapTitle'); ?></h2>
                <?php the_field('mapText'); ?>
            </div>
            <?php echo wp_get_attachment_image( get_field('mapImg'), 'full' ); ?>
        </div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>