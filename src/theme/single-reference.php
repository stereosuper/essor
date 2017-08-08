<?php get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>
        <div class='wrapper-top-img'>
            <div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></div>
        </div>

        <div class='container'>
            <div class='grid align-end pos-relative'>
                <div class='col-6 content-right-aligned'>
                    <div class='bloc-title isAnimated'>
                        <div class='wrapper-title-links'>
                            <h1><span><?php the_field('place'); ?></span><?php the_title(); ?></h1>
                            <ul>
                                <li><a href='<?php the_field('refsLink', 'options'); ?>?year=<?php echo get_the_date( 'Y' ); ?>'><?php echo get_the_date( 'Y' ); ?><svg class='icon icon-right'><use xlink:href='#icon-right'></use></svg></a></li>
                                <li>
                                    <?php
                                    $buildingTypes = get_the_terms( $post->ID, 'batiment' );
                                    if( $buildingTypes ){
                                        foreach( $buildingTypes as $buildingType ){ ?>
                                            <a href='<?php the_field('refsLink', 'options'); ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?><svg class='icon icon-right'><use xlink:href='#icon-right'></use></svg></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    $sectors = get_the_terms( $post->ID, 'metier' );
                                    if( $sectors ){
                                        foreach( $sectors as $sector ){ ?>
                                            <a href='<?php echo get_the_permalink(get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID); ?>'><?php echo $sector->name; ?><svg class='icon icon-right'><use xlink:href='#icon-right'></use></svg></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <?php the_excerpt(); ?>
                    </div>

                    <?php if( have_rows('details') ) : ?>
                        <ul class='side-infos col-2'>
                            <?php while( have_rows('details') ) : the_row(); ?>
                                <li>
                                    <span class='info-title'><?php the_sub_field('title'); ?></span>
                                    <span class='info-content'><?php the_sub_field('text'); ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <?php the_content(); ?>
                </div>
            </div>
            
            <?php
            $similarProjectsQuery = new WP_Query( array('post_type' => 'reference', 'posts_per_page' => 4, 'post__not_in' => array($post->ID), 'tax_query' => array(array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $buildingTypes[0]->slug)), 'orderby' => 'rand') );

            if( $similarProjectsQuery->have_posts() ) :
            ?>
                <h2 class='half-title'>Projets similaires</h2>
                <ul class='projects'>
                    <?php while( $similarProjectsQuery->have_posts() ) : $similarProjectsQuery->the_post(); ?>
                        <?php get_template_part( 'includes/reference' ); ?>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>