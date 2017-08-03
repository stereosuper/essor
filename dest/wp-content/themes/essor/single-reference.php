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

            <h2 class='half-title'>Projets similaires</h2>
            <ul class='projects'>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <h3>Parc de stationnement pour le groupe Total<span>Pau (64)</span></h3>
                    </a>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2016</a></li>
                    </ul>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <h3>Oceanet<span>Saint-Herblain (44)</span></h3>
                    </a>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2014</a></li>
                    </ul>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <h3>Agence Pôle Emploi à Pau Blum<span>Pau Blum (64)</span></h3>
                    </a>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2015</a></li>
                    </ul>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <h3>Siège de Varel Europe à Pau<span>Pau (64)</span></h3>
                    </a>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2011</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>