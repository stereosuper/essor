<?php 
/*
Template Name: Références
*/

$buildingTypeQuery = isset( $_GET['batiment'] ) ? $_GET['batiment'] : '';
$dateQuery = isset( $_GET['year'] ) ? $_GET['year'] : '';

$currentPageLink = get_the_permalink();

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <div class='container'>
            <div class='wrapper-title'>
                <div class='title'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>

                <aside>
                    <span class='title-aside'>Filter</span>
                    <div class='dropdown'>
                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                        <?php
                        $allBuildingTypes = get_terms('batiment');
                        if( $allBuildingTypes ){ ?>
                            <ul>
                                <li <?php if( !$buildingTypeQuery ){ echo 'class="active"'; } ?>><a href='<?php the_field('refsLink', 'options'); ?>'>Tout type de bâtiment</a></li>
                                <?php foreach( $allBuildingTypes as $buildingType ){ ?>
                                    <li <?php if( $buildingTypeQuery === $buildingType->slug){ echo 'class="active"'; } ?>><a href='<?php the_field('refsLink', 'options'); ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class='dropdown'>
                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                        <?php
                        $allSectors = get_terms('metier');
                        if( $allSectors ){ ?>
                            <ul>
                                <li <?php if( $currentPageLink === get_field('refsLink', 'options') ){ echo "class='active'"; } ?>><a href='<?php the_field('refsLink', 'options'); ?>'>Tous les métiers</a></li>
                                <?php foreach( $allSectors as $sector ){ ?>
                                    <?php
                                    $sectorPageID = get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID;
                                    ?>
                                    <li <?php if( $sectorPageID === $post->ID ){ echo "class='active'"; } ?>><a href='<?php echo get_the_permalink($sectorPageID); ?>'><?php echo $sector->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </aside>
            </div>

            <?php
            $projectsArgs = array('post_type' => 'reference', 'posts_per_page' => 10, 'tax_query' => array('relation' => 'AND'));
            
            if( get_field('sector') ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_term(get_field('sector'))->slug));
            }

            if( $buildingTypeQuery ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $buildingTypeQuery));
            }

            if( $dateQuery ){
                $projectsArgs['date_query'] = array(array('year'  => $dateQuery)); 
            }
            
            $projectsQuery = new WP_Query( $projectsArgs );

            if( $projectsQuery->have_posts() ) :
            ?>
                <ul class='projects complete'>
                    <?php while( $projectsQuery->have_posts() ) : $projectsQuery->the_post(); ?>
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
                                            <a href='<?php echo get_the_permalink(get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID); ?>'><?php echo $sector->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    $buildingTypes = get_the_terms( $post->ID, 'batiment' );
                                    if( $buildingTypes ){
                                        foreach( $buildingTypes as $buildingType ){ ?>
                                            <a href='<?php echo $currentPageLink; ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li><a href='<?php echo $currentPageLink; ?>?year=<?php echo get_the_date( 'Y' ); ?>'><?php echo get_the_date( 'Y' ); ?></a></li>
                            </ul>
                        </li>
                    <?php $countProjects ++; endwhile; ?>

                    <li class='load-more'>
                        <a href='#'><span class='txt-more'>Charger la suite<svg class='icon icon-arrow-bottom'><use xlink:href='#icon-arrow-bottom'></use></svg></span></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>