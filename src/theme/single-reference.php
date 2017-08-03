<?php get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>
        <div class='wrapper-top-img'>
            <div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></div>
        </div>

        <div class='container'>
            <div class='grid align-end pos-relative'>
                <div class='col-6 content-right-aligned'>
                    <div class='bloc-title'>
                        <div class='wrapper-title-links'>
                            <h1><span><?php the_field('place'); ?></span><?php the_title(); ?></h1>
                            <ul>
                                <li><a href='#'><?php echo get_the_date( 'Y' ); ?></a></li>
                                <li>
                                    <?php
                                    $buildingTypes = get_the_terms( $post->ID, 'batiment' );
                                    if( $buildingTypes ){
                                        foreach( $buildingTypes as $buildingType ){ ?>
                                            <a href='#'><?php echo $buildingType->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    $sectors = get_the_terms( $post->ID, 'metier' );
                                    if( $sectors ){
                                        foreach( $sectors as $sector ){ ?>
                                            <a href='#'><?php echo $sector->name; ?></a>
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
            $similarProjectsQuery = new WP_Query( array('post_type' => 'reference', 'posts_per_page' => 4, 'post__not_in' => array($post->ID), 'tax_query' => array(array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $buildingTypes[0]->slug))) );

            if( $similarProjectsQuery->have_posts() ) :
            ?>
                <h2 class='half-title'>Projets similaires</h2>
                <ul class='projects'>
                    <?php while( $similarProjectsQuery->have_posts() ) : $similarProjectsQuery->the_post(); ?>
                        <li>
                            <a href='<?php the_permalink(); ?>'>
                                <span class='wrapper-img'>
                                    <span class='img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></span>
                                </span>
                                <h3><?php the_title(); ?><span><?php the_field('place'); ?></span></h3>
                            </a>
                            <ul>
                                <li>
                                    <?php
                                    $sectors = get_the_terms( $post->ID, 'metier' );
                                    if( $sectors ){
                                        foreach( $sectors as $sector ){ ?>
                                            <a href='#'><?php echo $sector->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    $buildingTypes = get_the_terms( $post->ID, 'batiment' );
                                    if( $buildingTypes ){
                                        foreach( $buildingTypes as $buildingType ){ ?>
                                            <a href='#'><?php echo $buildingType->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li><a href='#'><?php echo get_the_date( 'Y' ); ?></a></li>
                            </ul>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>